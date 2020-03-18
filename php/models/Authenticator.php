<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/exceptions/AuthenticationException.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/exceptions/LoginException.php";

class Authenticator
{
    // Number of seconds before the user gets logged out.
    private const Timeout = 600;

    function authenticate()
    {
        if (self::isLoggedIn($_POST['username'] ?? null)) {
            return true;
        }

        // Not already logged in.
        try {
            self::login($_POST['username'] ?? null, $_POST['password'] ?? null);
            // Successfully logged in
            return true;
        } catch (LoginException $e) {
            if (isset($_POST['username'], $_POST['password'])) {
                $GLOBALS['loginError'] = "Failed to log user in";
            }

            build("login.php");
            return false;
        }
    }

    /**
     * @param string $username The username to try to login
     * @param string $password The password for the user
     * @return bool True if the user could authenticate with the given password , false otherwise
     */
    static function login(string $username, string $password)
    {
        $conn = SQLManager::createConnection(ConnectionType::UserAuth);
        $query = "SELECT account_id, password FROM account WHERE username = ?";
        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("s", $username);
                if (!$stmt->execute()) {
                    return false;
                }

                $stmt->store_result();
                $stmt->bind_result($account_id, $fetched_password);
                $fetch = $stmt->fetch();
                $stmt->close();

                if (!$fetch) return false;
                if (password_verify($password, $fetched_password)) {
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['name'] = $username;
                    $_SESSION['id'] = $account_id;
                    self::resetTimeout();
                    return false;
                }
            } else {
                return false;
            }
        } finally {
            $conn->close();
        }

        return false;
    }

    /**
     * Checks whether a user is logged in or not and if the user's session is still active.
     * @param string $username The username to check if they are logged in
     * @return bool True if the user is logged in
     */
    static function isLoggedIn(string $username)
    {
        try {
            return self::isSessionUser($username) && self::isSessionActive();
        } catch (AuthenticationException $e) {
            return false;
        }
    }

    /**
     * Checks whether the passed user is the session user.
     * IMPORTANT: This does not check if the user's session is still valid.
     * For that see @isLoggedIn
     * @param string $username The username to check if they are logged in
     * @return bool True if the user is logged in
     */
    static function isSessionUser(string $username)
    {
        return isset($_SESSION['loggedIn'])
            && isset($_SESSION['username'])
            && $_SESSION['loggedIn'] === true
            && $_SESSION['username'] === $username;
    }

    /**
     * Checks if the session for a user is still active or if it timed out.
     * @return bool True if the users session is still active
     * @throws AuthenticationException If the user was not logged in
     */
    static function isSessionActive()
    {
        if (!isset($_SESSION['loginTime'])) {
            throw new AuthenticationException("User is logged in with invalid session");
        }

        return time() - $_SESSION['loginTime'] < self::Timeout;
    }

    /**
     * Logs the user out if the session expired. Otherwise resets the timout
     */
    static function updateSession() {
        try {
            if (self::isSessionActive()) {
                self::resetTimeout();
            } else {
                self::logout();
            }
        } catch (AuthenticationException $e) {}
    }

    /**
     * Resets the login time for the session.
     */
    static function resetTimeout()
    {
        $_SESSION['loginTime'] = time();
    }

    /**
     * Logs the currently logged in user out
     */
    static function logout()
    {
        $_SESSION['loggedIn'] = false;
        unset($_SESSION['loginTime']);
        unset($_SESSION['username']);
        unset($_SESSION['userId']);
    }

    // TODO: Implement Register function
    static function register()
    {

    }

}
