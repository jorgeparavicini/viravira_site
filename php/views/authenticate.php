<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (!isset($_POST['username'], $_POST['password'])) {
	die("Please fill both username and password");
}

session_start();
$username = $_POST['username'];
$password = $_POST['password'];

$conn = Excursion::createSession();
$sql = "SELECT account_id, password FROM account WHERE username = '{$username}'";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    echo "No account with that username found.";
} else {
    $fetched = $result->fetch_assoc();
    $storedPassword = $fetched['password'];

    if (password_verify($password, $storedPassword)) {
        session_regenerate_id();
        $_SESSION['loggedIn'] = true;
        $_SESSION['name'] = $username;
        $_SESSION['id'] = $fetched['account_id'];
        echo "welcome" . $username;
    } else {
        echo "Wrong Password";
    }
}

$conn->close();