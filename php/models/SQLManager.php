<?php


class SQLManager
{
//region SQL Statements

    /**
     * @param $conn mysqli The Mysqli Connection
     * @param $id int The excursion id to check if it exists
     * @return bool True if the excursion exists. False otherwise
     */
    public static function doesExcursionExist($conn, $id)
    {
        $sql = "SELECT excursion_id FROM excursion WHERE excursion_id=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $stmt->store_result();

                $excursion_check = -1;
                $stmt->bind_result($excursion_check);
                $stmt->fetch();

                if ($stmt->num_rows == 1) {
                    return true;
                }
            } else {
                die("Failed to execute select statement");
            }
        } else {
            die("Invalid SQL Syntax");
        }
        return false;
    }

    /**
     * @param $conn mysqli The Mysqli Connection
     * @param $id int The excursion id which should be updated
     * @param $title string The new excursion title
     * @param $type string The new excursion type
     * @param $thumbnail string The new excursion thumbnail url
     * @return bool True if the update succeeded
     */
    public static function updateExcursion($conn, $id, $title, $type, $thumbnail)
    {
        $sql = "UPDATE excursion SET title=?, type=?, thumbnail_url=? WHERE excursion_id=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $title, $type, $thumbnail, $id);

            return $stmt->execute();
        } else {
            die("Invalid SQL Syntax");
        }
    }

    /**
     * @param $conn mysqli Mysqli Connection
     * @param $id int The excursion id for which the descriptions should be cleared
     * @return bool True if the Deletion succeeded
     */
    public static function clearExcursionDescriptions($conn, $id)
    {
        $sql = "DELETE FROM excursion_description WHERE excursion_id=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } else {
            die("Invalid SQL Syntax");
        }
    }

    /**
     * @param $conn mysqli Mysqli Connection
     * @param $id int The id of the excursion
     * @param $header string The Description header
     * @param $description string The value for the description
     * @return bool True if the insertion succeeded
     */
    public static function insertExcursionDescription($conn, $id, $header, $description)
    {
        $sql = "INSERT INTO excursion_description (excursion_id, header, description) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iss", $id, $header, $description);
            return $stmt->execute();
        } else {
            die("Invalid SQL Syntax");
        }
    }

    /**
     * @param $conn mysqli The Mysqli Connection
     * @param $id int The id of the excursion the details should be cleared for.
     * @return bool True if all details where successfully cleared.
     */
    public static function clearExcursionDetails($conn, $id)
    {
        $sql = "DELETE FROM excursion_detail WHERE excursion_id=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } else {
            die("Invalid SQL Syntax");
        }
    }

    /**
     * @param $conn mysqli The Mysqli Connection
     * @param $id int The id of the excursion that the new detail should be created for.
     * @param $name string The name of the Detail
     * @param $value string The value of the Detail
     * @return bool True if the insertion succeeded
     */
    public static function insertExcursionDetail($conn, $id, $name, $value)
    {
        $sql = "INSERT INTO excursion_detail (excursion_id, detail_key, detail_value) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iss", $id, $name, $value);
            return $stmt->execute();
        } else {
            die("Invalid SQL Syntax");
        }
    }

    /**
     * @param $conn mysqli The Mysqli connection
     * @param $id int The id of the excursion the images should be cleared for.
     * @return bool True if the deletion succeeded
     */
    public static function clearExcursionImages($conn, $id)
    {
        $sql = "DELETE FROM excursion_image WHERE excursion_id=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } else {
            die("Invalid SQL Syntax");
        }
    }

    /**
     * @param $conn mysqli The Mysqli connection
     * @param $id int The id of the excursion the new image should be inserted for.
     * @param $url string The image url
     * @param $description string the Image description
     * @return bool True if the Insertion succeeded.
     */
    public static function insertExcursionImage($conn, $id, $url, $description)
    {
        $sql = "INSERT INTO excursion_image (excursion_id, image_url, description) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iss", $id, $url, $description);
            return $stmt->execute();
        } else {
            die("Invalid SQL Syntax");
        }
    }

    /**
     * @param $conn mysqli The Mysqli Connection
     * @param $title string The title of the new excursion
     * @param $type string The type of the new excursion
     * @param $thumbnail string The type of the new thumbnail
     * @return int The id of the created excursion
     */
    public static function createExcursion($conn, $title, $type, $thumbnail)
    {
        $sql = "INSERT INTO excursion (title, type, thumbnail_url) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $title, $type, $thumbnail);
            $result = $stmt->execute();
            if (!$result) return -1;
            return $stmt->insert_id;
        } else {
            die("Invalid SQL Syntax");
        }
    }

    /**
     * @param $conn mysqli The Mysqli Connection
     * @param $id string The id of the excursion which should be removed
     * @return bool True if the deletion succeeded
     */
    public static function removeExcursion($conn, $id) {
        $sql = "DELETE FROM excursion WHERE excursion_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } else {
            die("Invalid SQL Syntax");
        }
    }

//endregion
}