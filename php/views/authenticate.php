<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/exceptions/AuthenticationException.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/exceptions/LoginException.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function authenticate()
{
    if (isLoggedIn()) {
        if (isSessionActive()) {
            // Already logged in.
            return true;
        } else {
            logout();
            $GLOBALS['loginError'] = "Session Expired";
            build("login.php");
            return false;
        }
    }

    // Not already logged in.
    try {
        login($_POST['username'] ?? null, $_POST['password'] ?? null);
        // Successfully logged in
        return true;
    } catch (LoginException $e) {
        if (isset($_POST['username'], $_POST['password'])) {
            $GLOBALS['loginError'] = $e->getMessage();
        }
        build("login.php");
        return false;
    }
}

/**
 * @param $username string The username to try to login
 * @param $password string The password for the user
 * @throws LoginException Thrown when the login failed.
 */
function login($username, $password)
{
    $conn = Excursion::createSession();
    $sql = "SELECT account_id, password FROM account WHERE username = '{$username}'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $fetched = $result->fetch_assoc();
        $storedPassword = $fetched['password'];

        if (password_verify($password, $storedPassword)) {
            //session_regenerate_id();
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

function isLoggedIn() {
    return isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;
}

function isSessionActive()
{
    // The number of seconds the user can be logged in.
    $timeout = 20;
    if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false) return false;
    if (!isset($_SESSION['loginTime'])) return false;

    return time() - $_SESSION['loginTime'] < $timeout;
}

/**
 * @throws AuthenticationException If the user is not logged in.
 */
function resetTimeout()
{
    if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false) {
        throw new AuthenticationException("No user is logged in");
    }

    $_SESSION['loginTime'] = time();
}

function logout() {
    $_SESSION['loggedIn'] = false;
}