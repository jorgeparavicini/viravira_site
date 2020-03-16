<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/exceptions/AuthenticationException.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/exceptions/LoginException.php";

public

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

    // TODO: Update
    /**
     * @param $username string The username to try to login
     * @param $password string The password for the user
     * @throws LoginException Thrown when the login failed.
     */
    static function login($username, $password)
    {
        $conn = SQLManager::createSession();
        $sql = "SELECT account_id, password FROM account WHERE username = '{$username}'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $fetched = $result->fetch_assoc();
            $storedPassword = $fetched['password'];

            if (password_verify($password, $storedPassword)) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['name'] = $username;
                $_SESSION['id'] = $fetched['account_id'];
                try {
                    resetTimeout();
                } catch (AuthenticationException $e) {
                    throw new LoginException("Could not reset the login time");
                }

            } else {
                throw new LoginException("Incorrect Password");
            }
        } else {
            throw new LoginException("Username not found");
        }

        $conn->close();
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
