<?php
include_once "{$_SERVER['DOCUMENT_ROOT']}/php/resources/head.php";

function build($file, $hasSlideshow = false)
{
    ?>
	<!DOCTYPE html>
	<html lang="en">
    <?php buildHead($file, $hasSlideshow); ?>
	<body>

    <?php
    echo "<!-- HEADER -->";
    include_once "{$_SERVER['DOCUMENT_ROOT']}/php/resources/header.php";
    ?>

	<div id="content">
        <?php
        echo "<!-- BODY -->";
        if (file_exists("{$_SERVER['DOCUMENT_ROOT']}/php/views/{$file}")) {
            include_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/{$file}";
        } else {
            include_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/404.php";
        }
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