<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/resources/head.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Authenticator.php";

class Builder
{

    public static function build(callable $contentCallback, $title)
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <?php buildHead($title); ?>
        <body>

        <?php
        echo "<!-- HEADER -->";
        include_once "{$_SERVER['DOCUMENT_ROOT']}/php/resources/header.php";
        ?>

        <div id="content">
            <?php
            echo "<!-- BODY -->";
            $contentCallback();
            ?>
        </div>

        <?php
        echo "<!-- FOOTER -->";
        include_once "{$_SERVER['DOCUMENT_ROOT']}/php/resources/footer.php";
        ?>

        </body>
        </html>

        <?php
    }


    public static function buildFromName(string $name)
    {
        self::build(function () use ($name) {
            if (file_exists("{$_SERVER['DOCUMENT_ROOT']}/php/views/{$name}")) {
                include_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/{$name}";
            } else {
                include_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/404.php";
            }
        }, pathinfo($name, PATHINFO_FILENAME));
    }

    public static function buildAfterAuthentication(string $name)
    {
        $error_msg = null;
        try {
            if (Authenticator::authenticate()) {
                self::buildFromName($name);
                return;
            }
        } catch (SessionExpiredException $e) {
            $error_msg = "Session Expired";
        } catch (LoginException $e) {
            $error_msg = "Login Credentials do not match";;
        }
        require_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/login.php";
        self::build(function () use ($error_msg) {
            buildLogin($error_msg);
        }, "Login");
    }
}