<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/SQLManager.php";

if (!isset($_GET['id'])) {
    displayFailure("Failed to delete excursion as no id was passed.");
    return;
}

$conn = Excursion::createSession();
$conn->begin_transaction();

$sql = "DELETE FROM excursion_description WHERE excursion_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['id']);
$result = $stmt->execute();
$stmt->close();

if (!$result) {
    displayFailure("Failed to remove descriptions");
    $conn->rollback();
    return;
}

$sql = "DELETE FROM excursion_detail WHERE excursion_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['id']);
$result = $stmt->execute();
$stmt->close();

if (!$result) {
    displayFailure("Failed to remove details");
    $conn->rollback();
    return;
}

$sql = "DELETE FROM excursion_image WHERE excursion_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['id']);
$result = $stmt->execute();
$stmt->close();

if (!$result) {
    displayFailure("Failed to remove images");
    $conn->rollback();
    return;
}

$sql = "DELETE FROM excursion WHERE excursion_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['id']);
$result = $stmt->execute();
$stmt->close();

if (!$result) {
    displayFailure("Failed to remove excursion");
    $conn->rollback();
    return;
}

$conn->commit();

displaySuccess("Successfully deleted excursion: {$_GET['id']}");


function displayFailure($message) {
    ?>
    <h1>Failure</h1>
    <p class="error"><?php echo $message ?></p>
    <?php
}

function displaySuccess($message) {
    ?>
    <h1>Success</h1>
    <p class="success"><?php echo $message ?></p>
    <?php
}

?>

<a href="edit">Go back</a>
