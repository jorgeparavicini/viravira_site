<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/SQLManager.php";

validateQuery();

if (isset($_POST["id"])) {
    updateExistingRecord();
} else {
    createNewRecord();
}

function updateExistingRecord()
{
    if (!areCriticalValuesSet()) return;
    if (!isset($_POST['id'])) {
        displayFailure("Id has not been set");
        return;
    }

    $id = $_POST['id'];
    $title = $_POST['title'];
    $type = $_POST['type'];
    $thumbnail = $_POST['thumbnail'];

    // Start up the connection
    $conn = Excursion::createSession();
    // We want to rollback everything if an error occurs
    $conn->begin_transaction();

    // Update the excursion values for the passed excursion id.
    if (!SQLManager::updateExcursion($conn, $id, $title, $type, $thumbnail)) {
        displayFailure("Failed to update the excursion");
        $conn->rollback();
        return;
    }

    // Clear all existing excursion descriptions for this excursion
    if (!SQLManager::clearExcursionDescriptions($conn, $id)) {
        displayFailure("Failed to clear existing descriptions");
        $conn->rollback();
        return;
    }

    // Insert all the excursion descriptions from the post
    if (!insertExcursionDescriptions($conn)) {
        $conn->rollback();
        return;
    }

    // Clear all existing excursion details
    if (!SQLManager::clearExcursionDetails($conn, $id)) {
        displayFailure("Failed to clear existing details");
        $conn->rollback();
        return;
    }

    // Insert all the new excursion details
    if (!insertExcursionDetails($conn)) {
        $conn->rollback();
        return;
    }

    // Clear all existing excursion images
    if (!SQLManager::clearExcursionImages($conn, $id)) {
        displayFailure("Failed to clear existing images");
        $conn->rollback();
        return;
    }

    // Insert all new excursion images
    if (!insertExcursionImages($conn)) {
        $conn->rollback();
        return;
    }

    $conn->commit();
    $conn->close();

    displaySuccess("Successfully updated excursion: {$_POST['title']}");
}

function createNewRecord()
{
    if (!areCriticalValuesSet()) return;

    $title = $_POST['title'];
    $type = $_POST['type'];
    $thumbnail = $_POST['thumbnail'];

    // Start up the connection
    $conn = Excursion::createSession();
    // We want to rollback everything if an error occurs
    $conn->begin_transaction();

    $id = SQLManager::createExcursion($conn, $title, $type, $thumbnail);
    if ($id <= 0) {
        displayFailure("Failed to create excursion");
        $conn->rollback();
        return;
    }

    if (!insertExcursionDescriptions($conn)) {
        $conn->rollback();
        return;
    }

    if (!insertExcursionDetails($conn)) {
        $conn->rollback();
        return;
    }

    if (!insertExcursionImages($conn)) {
        $conn->rollback();
        return;
    }

    $conn->commit();
    $conn->close();

    displaySuccess("Successfully created excursion: {$_POST['title']}");
}

function areCriticalValuesSet()
{
    if (!isset($_POST['title'])) {
        displayFailure("Title has not been set");
        return false;
    }
    if (!isset($_POST['type'])) {
        displayFailure("Type has not been set");
        return false;
    }
    if (!isset($_POST['thumbnail'])) {
        displayFailure("Thumbnail has not been set");
        return false;
    }

    return true;
}

//region SQL Statements

function insertExcursionDescriptions($conn)
{
    $descriptionIndex = 0;
    while (isset($_POST["description{$descriptionIndex}Header"])) {
        if (!isset($_POST["description{$descriptionIndex}Value"])) {
            displayFailure("Discrepancy between Description Headers and Values");
            return false;
        }

        if (!SQLManager::insertExcursionDescription($conn,
            $_POST['id'],
            $_POST["description{$descriptionIndex}Header"],
            $_POST["description{$descriptionIndex}Value"])) {
            displayFailure("Failed to insert description");
            return false;
        }

        $descriptionIndex++;
    }

    return true;
}

function insertExcursionDetails($conn)
{
    $detailIndex = 0;
    while (isset($_POST["detail{$detailIndex}Name"])) {
        if (!isset($_POST["detail{$detailIndex}Value"])) {
            displayFailure("Discrepancy between detail Names and Values");
            return false;
        }

        if (!SQLManager::insertExcursionDetail($conn,
            $_POST['id'],
            $_POST["detail{$detailIndex}Name"],
            $_POST["detail{$detailIndex}Value"])) {
            displayFailure("Failed to insert detail");
            return false;
        }

        $detailIndex++;
    }

    return true;
}

function insertExcursionImages($conn)
{
    $imageIndex = 0;
    while (isset($_POST["image{$imageIndex}Url"])) {
        if (!isset($_POST["image{$imageIndex}Description"])) {
            displayFailure("Discrepancy between Image Url and Description");
            return false;
        }

        if (!SQLManager::insertExcursionImage($conn, $_POST["id"], $_POST["image{$imageIndex}Url"], $_POST["image{$imageIndex}Description"])) {
            displayFailure("Failed to insert image");
            return false;
        }

        $imageIndex++;
    }

    return true;
}

function validateQuery()
{
    return true;
}

//endregion

//region HTML Generators

function displayFailure($message)
{
    ?>
	<h1>Failure</h1>
	<p class="error"><?php echo $message ?></p>
    <?php
}

function displaySuccess($message)
{
    ?>
	<h1>Success</h1>
	<p class="success"><?php echo $message ?></p>
    <?php
}

//endregion

?>

<a href="edit">Go back</a>
