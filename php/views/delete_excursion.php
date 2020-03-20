<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/SQLManager.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/ConnectionType.php";

if (!isset($_GET['id'])) {
    displayFailure("Failed to delete excursion as no id was passed.");
    return;
}

deleteExcursion(htmlspecialchars($_GET['id']));

function deleteExcursion($id) {
    $conn = SQLManager::createConnection(ConnectionType::Deletion);
    $conn->begin_transaction();

    try {
        if (!SQLManager::clearExcursionDescriptions($id, $conn)) {
            displayFailure("Failed to remove descriptions");
            $conn->rollback();
            return;
        }
    } catch (SQLException $e) {
        displayFailure($e->getMessage());
        return;
    }

    try {
        if (!SQLManager::clearExcursionDetails($id, $conn)) {
            displayFailure("Failed to remove details");
            $conn->rollback();
            return;
        }
    } catch (SQLException $e) {
        displayFailure($e->getMessage());
        return;
    }

    try {
        if (!SQLManager::clearExcursionImages($id, $conn)) {
            displayFailure("Failed to remove images");
            $conn->rollback();
            return;
        }
    } catch (SQLException $e) {
        displayFailure($e->getMessage());
        return;
    }

    try {
        if (!SQLManager::removeExcursion($id, $conn)) {
            displayFailure("Failed to remove excursion");
            $conn->rollback();
            return;
        }
    } catch (SQLException $e) {
        displayFailure($e->getMessage());
        return;
    }

    $conn->commit();

    displaySuccess("Successfully deleted excursion: {$id}");
}


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

<a class="button" href="edit">Go back</a>
