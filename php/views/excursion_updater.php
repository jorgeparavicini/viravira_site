<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/SQLManager.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/ConnectionType.php";

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

    $id = htmlspecialchars($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $type = htmlspecialchars($_POST['type']);
    $thumbnail = htmlspecialchars($_POST['thumbnail']);

    // Start up the connection
    $conn = SQLManager::createConnection(ConnectionType::Update);
    // We want to rollback everything if an error occurs
    $conn->begin_transaction();

    // Update the excursion values for the passed excursion id.
    try {
        if (!SQLManager::updateExcursion($id, $title, $type, $thumbnail, $conn)) {
            displayFailure("Failed to update the excursion");
            $conn->rollback();
            return;
        }
    } catch (SQLException $e) {
        displayFailure($e->getMessage());
        return;
    }

    // Clear all existing excursion descriptions for this excursion
    try {
        if (!SQLManager::clearExcursionDescriptions($id, $conn)) {
            displayFailure("Failed to clear existing descriptions");
            $conn->rollback();
            return;
        }
    } catch (SQLException $e) {
        displayFailure($e->getMessage());
        return;
    }

    // Insert all the excursion descriptions from the post
    if (!insertExcursionDescriptions($conn)) {
        $conn->rollback();
        return;
    }

    // Clear all existing excursion details
    try {
        if (!SQLManager::clearExcursionDetails($id, $conn)) {
            displayFailure("Failed to clear existing details");
            $conn->rollback();
            return;
        }
    } catch (SQLException $e) {
        displayFailure($e->getMessage());
        return;
    }

    // Insert all the new excursion details
    if (!insertExcursionDetails($conn)) {
        $conn->rollback();
        return;
    }

    // Clear all existing excursion images
    try {
        if (!SQLManager::clearExcursionImages($id, $conn)) {
            displayFailure("Failed to clear existing images");
            $conn->rollback();
            return;
        }
    } catch (SQLException $e) {
        displayFailure($e->getMessage());
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

    $title = htmlspecialchars($_POST['title']);
    $type = htmlspecialchars($_POST['type']);
    $thumbnail = htmlspecialchars($_POST['thumbnail']);

    // Start up the connection
    $conn = SQLManager::createConnection(ConnectionType::Insertion);
    // We want to rollback everything if an error occurs
    $conn->begin_transaction();

    try {
        $id = SQLManager::createExcursion($title, $type, $thumbnail, $conn);
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
    } catch (SQLException $e) {
        displayFailure($e->getMessage());
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

        try {
            if (!SQLManager::insertExcursionDescription(
                htmlspecialchars($_POST['id']),
                htmlspecialchars($_POST["description{$descriptionIndex}Header"]),
                htmlspecialchars($_POST["description{$descriptionIndex}Value"]),
                $conn)) {
                displayFailure("Failed to insert description");
                return false;
            }
        } catch (SQLException $e) {
            displayFailure($e->getMessage());
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

        try {
            if (!SQLManager::insertExcursionDetail(
                htmlspecialchars($_POST['id']),
                htmlspecialchars($_POST["detail{$detailIndex}Name"]),
                htmlspecialchars($_POST["detail{$detailIndex}Value"]),
                $conn)) {
                displayFailure("Failed to insert detail");
                return false;
            }
        } catch (SQLException $e) {
            displayFailure($e->getMessage());
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

        try {
            if (!SQLManager::insertExcursionImage(
                htmlspecialchars($_POST["id"]),
                htmlspecialchars($_POST["image{$imageIndex}Url"]),
                htmlspecialchars($_POST["image{$imageIndex}Description"]),
                $conn)) {
                displayFailure("Failed to insert image");
                return false;
            }
        } catch (SQLException $e) {
            displayFailure($e->getMessage());
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

<a class="button" href="edit">Go back</a>
