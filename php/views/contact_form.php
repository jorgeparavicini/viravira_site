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

if (isset($_SESSION['querySubmitted']) && $_SESSION['querySubmitted']) {
    displayError("Query already submitted, please wait before submitting your next query.");
    return;
}

$conn = SQLManager::createSession();
$conn->begin_transaction();
if (SQLManager::writeQuestion($conn, $firstName, $lastName, $email, $phone, $subject, $query)) {
    ?>
    <h1>Successfully submitted your query.</h1>
    <?php
    $_SESSION['querySubmitted'] = true;
    $conn->commit();
} else {
    $conn->rollback();
}

$conn->close();


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
    if (preg_match("/^([a-zA-Z' ]+)$/", $name, $match)) {
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
    if (preg_match("/^([a-zA-Z' ]+)$/", $name, $match)) {
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
    $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    $phone = str_replace("-", "", $phone);
    return 10 <= strlen($phone) && strlen($phone) <= 14 ? $phone : null;
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