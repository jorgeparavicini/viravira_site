<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/SQLManager.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/exceptions/AuthenticationException.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/exceptions/LoginException.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/exceptions/SessionExpiredException.php";
require_once "${_SERVER['DOCUMENT_ROOT']}/php/models/ConnectionType.php";

class Authenticator
{
    // Number of seconds before the user gets logged out.
    private const Timeout = 10;

    /**
     * @return bool True if the user could authenticate correctly.
     * @throws LoginException If the user could not authenticate.
     * @throws SessionExpiredException If the users session has expired.
     */
    public static function authenticate()
    {
        $username = htmlspecialchars($_POST['username'] ?? null);
        $password = htmlspecialchars($_POST['password'] ?? null);

        if (self::isLoggedIn()) {
            return true;
        }

        if (isset($_SESSION['expired']) && $_SESSION['expired'] === true) {
            throw new SessionExpiredException("Session has expired");
        }

        // Do not throw login exceptions when the user did not even try to log in.
        if (empty($username) || empty($password)) {
            return false;
        }

        // We do not want to show error messages if then error in our sql syntax.
        try {
            return self::login($username, $password);
        } catch (SQLException $e) {
            return false;
        }

    }

    /**
     * @param string $username The username to try to login
     * @param string $password The password for the user
     * @return bool True if the user could authenticate with the given password , false otherwise
     * @throws LoginException Thrown when the username or password do not match the database entries
     * @throws SQLException Thrown if the SQL Syntax is invalid, should never be thrown in deployment.
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

                if (!$fetch) {
                    throw new LoginException("Username not found");
                }
                if (password_verify($password, $fetched_password)) {
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['name'] = $username;
                    $_SESSION['id'] = $account_id;
                    self::resetTimeout();
                    return true;
                } else {
                    throw new LoginException("Password does not match");
                }
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            $conn->close();
        }

        return false;
    }

    /**
     * Checks whether the passed user is the session user.
     * @return bool True if the user is logged in
     */
    static function isLoggedIn()
    {
        return isset($_SESSION['loggedIn'])
            && isset($_SESSION['name'])
            && $_SESSION['loggedIn'] === true
            && !empty($_SESSION['name']);
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
    static function updateSession()
    {
        try {
            if (self::isSessionActive()) {
                self::resetTimeout();
            } else {
                self::logout();
            }
        } catch (AuthenticationException $e) {
        }
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
        $_SESSION['expired'] = true;
        unset($_SESSION['loginTime']);
        unset($_SESSION['username']);
        unset($_SESSION['userId']);
    }

    // TODO: Implement Register function
    static function register()
    {

    }

}
