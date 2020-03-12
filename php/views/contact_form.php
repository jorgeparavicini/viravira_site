<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/SQLManager.php";

$firstName = getValidatedFirstName();
if (!$firstName) {
    displayError("Invalid First Name passed");
    return;
}

$lastName = getValidatedLastName();
if (!$lastName) {
    displayError("Invalid Last Name passed");
    return;
}

$email = getValidatedEmail();
if (!$email) {
    displayError("Invalid Email passed");
    return;
}

$phone = getValidatedPhone();
$subject = getValidatedSubject();
if (!$subject) {
    displayError("Invalid Subject passed");
    return;
}

$query = getValidatedQuery();
if (!$query) {
    displayError("Invalid query passed");
    return;
}

// Write to database
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['querySubmitted']) && $_SESSION['querySubmitted']) {
    displayError("Query already submitted, please wait before submitting your next query.");
    return;
}

if (SQLManager::writeQuery($firstName, $lastName, $email, $phone, $subject, $query)) {
    ?>
    <h1>Successfully submitted your query.</h1>
    <?php
    $_SESSION['querySubmitted'] = true;
}


function displayError($message)
{
    ?>
    <h1>Failed to submit your query</h1>
    <p class="error"><?php echo $message ?></p>
    <?php
}

//region Validation

function getValidatedFirstName()
{
    if (!isset($_POST['firstName'])) {
        return false;
    }
    $name = $_POST['firstName'];
    if (preg_match("/^[\w'\-,.][0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{1,}$/", $name, $match)) {
        return $name;
    }
    return false;
}

function getValidatedLastName()
{
    if (!isset($_POST['lastName'])) {
        return false;
    }
    $name = $_POST['firstName'];
    if (preg_match("^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{1,}$", $name, $match)) {
        return $name;
    }
    return false;
}

function getValidatedEmail()
{
    if (!isset($_POST['email'])) {
        return false;
    }
    $mail = $_POST['email'];
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return $mail;
}

function getValidatedPhone()
{
    if (!isset($_POST['phone'])) {
        return null;
    }
    $phone = $_POST['phone'];
    if (preg_match("(([+][(]?[0-9]{1,3}[)]?)|([(]?[0-9]{4}[)]?))\s*[)]?[-\s\.]?[(]?[0-9]{1,3}[)]?([-\s\.]?[0-9]{3})([-\s\.]?[0-9]{3,4})", $phone, $match)) {
        return $phone;
    }
    return null;
}

function getValidatedSubject()
{
    if (!isset($_POST['subject'])) {
        return false;
    }
    $subject = $_POST['subject'];
    if (5 <= strlen($subject) && strlen($subject) <= 100) {
        return $subject;
    }
    return false;
}

function getValidatedQuery()
{
    if (!isset($_POST['query'])) {
        return false;
    }
    $query = $_POST['query'];
    if (15 <= strlen($query) && strlen($query) <= 1000) {
        return $query;
    }
    return false;
}
//endregion

?>
<a href="home">Go back</a>