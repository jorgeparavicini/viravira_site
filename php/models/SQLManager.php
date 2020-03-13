<?php


class SQLManager
{
    //TODO: add login statements

//region Fields

    private const servername = "localhost";
    private const username = "root";
    private const password = "1234";
    private const db = "viravira";

//endregion Fields

//region Connections
    // TODO: typed

    /**
     * @param int $type The type of connection to create.
     * Depending on the type, different users will be used to connect.
     * @return mysqli The created connection to the database with the corresponding user.
     */
    public static function createConnection(int $type)
    {
        $conn = new mysqli(self::servername, self::username, self::password, self::db);
        if ($conn->connect_error) {
            die("Connection failed: {$conn->connect_error}");
        }
        return $conn;
    }

//endregion Connections

//region Excursion Statements

    /**
     * @param int $id The excursion id to check if it exists
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return bool True if the excursion exists. False otherwise
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function excursionExists(int $id, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Selection) : $conn;
        $query = "SELECT excursion_id FROM excursion WHERE excursion_id=?";

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $id);

                if (!$stmt->execute()) {
                    throw new SQLException("Failed to execute select statement");
                }

                $stmt->store_result();
                $stmt->bind_result($excursion_check);
                $fetch = $stmt->fetch();
                $stmt->close();

                if ($fetch) {
                    return $excursion_check === $id;
                } else {
                    return false;
                }
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn === null) $internalConn->close();
        }
        return false;
    }

    /**
     * @param int $id The excursion id which should be updated
     * @param string $title The new excursion title
     * @param string $type The new excursion type
     * @param string $thumbnail The new excursion thumbnail url
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return bool True if the update succeeded
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function updateExcursion(int $id, string $title, string $type, string $thumbnail, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Update) : $conn;
        $query = "UPDATE excursion SET title=?, type=?, thumbnail_url=? WHERE excursion_id=?";
        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("sssi", $title, $type, $thumbnail, $id);

                return $stmt->execute();
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn === null) $internalConn->close();
        }
        return false;
    }

    /**
     * @param int $id The excursion id for which the descriptions should be cleared
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return bool True if the Deletion succeeded
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function clearExcursionDescriptions(int $id, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Deletion) : $conn;
        $query = "DELETE FROM excursion_description WHERE excursion_id=?";
        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $id);
                return $stmt->execute();
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn === null) $internalConn->close();
        }
        return false;
    }

    /**
     * @param int $id The id of the excursion
     * @param string $header The Description header
     * @param string $description The value for the description
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return bool True if the insertion succeeded
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function insertExcursionDescription(int $id, string $header, string $description, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Insertion) : $conn;
        $query = "INSERT INTO excursion_description (excursion_id, header, description) VALUES (?, ?, ?)";

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("iss", $id, $header, $description);
                return $stmt->execute();
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn === null) $internalConn->close();
        }
        return false;
    }

    /**
     * @param int $id The id of the excursion the details should be cleared for.
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return bool True if all details where successfully cleared.
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function clearExcursionDetails(int $id, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Deletion) : $conn;
        $query = "DELETE FROM excursion_detail WHERE excursion_id=?";

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $id);
                return $stmt->execute();
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn === null) $internalConn->close();
        }
        return false;
    }

    /**
     * @param int $id int The id of the excursion that the new detail should be created for.
     * @param string $name The name of the Detail
     * @param string $value The value of the Detail
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return bool True if the insertion succeeded
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function insertExcursionDetail(int $id, string $name, string $value, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Insertion) : $conn;
        $query = "INSERT INTO excursion_detail (excursion_id, detail_key, detail_value) VALUES (?, ?, ?)";

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("iss", $id, $name, $value);
                return $stmt->execute();
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn === null) $internalConn->close();
        }
        return false;
    }

    /**
     * @param int $id The id of the excursion the images should be cleared for.
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return bool True if the deletion succeeded
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function clearExcursionImages(int $id, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Deletion) : $conn;
        $query = "DELETE FROM excursion_image WHERE excursion_id=?";

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $id);
                return $stmt->execute();
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn === null) $internalConn->close();
        }
        return false;
    }

    /**
     * @param int $id The id of the excursion the new image should be inserted for.
     * @param string $url The image url
     * @param string $description The Image description
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return bool True if the Insertion succeeded.
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function insertExcursionImage(int $id, string $url, string $description, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Insertion) : $conn;
        $query = "INSERT INTO excursion_image (excursion_id, image_url, description) VALUES (?, ?, ?)";

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("iss", $id, $url, $description);
                return $stmt->execute();
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn === null) $internalConn->close();
        }
        return false;
    }

    /**
     * @param string $title The title of the new excursion
     * @param string $type The type of the new excursion
     * @param string $thumbnail The type of the new thumbnail
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return int The id of the created excursion
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function createExcursion(string $title, string $type, string $thumbnail, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Selection) : $conn;
        $query = "INSERT INTO excursion (title, type, thumbnail_url) VALUES (?, ?, ?)";

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("sss", $title, $type, $thumbnail);
                $result = $stmt->execute();
                if (!$result) return -1;
                return $stmt->insert_id;
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn == null) $internalConn->close();
        }
        return false;
    }

    /**
     * @param string $id The id of the excursion which should be removed
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return bool True if the deletion succeeded
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function removeExcursion(string $id, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Insertion) : $conn;
        $query = "DELETE FROM excursion WHERE excursion_id = ?";

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $id);
                return $stmt->execute();
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn == null) $internalConn->close();
        }
        return false;
    }

//endregion

//region User Questions Statements

    /**
     * Writes a user question to the query table.
     * @param string $name The name of the guest asking the question
     * @param string $surname The last name of the guest asking the question
     * @param string $email The email of the guest asking the question
     * @param string $phone The phone number of the guest asking the question
     * @param string $subject The subject of the query
     * @param string $question The asked question
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @return bool True if the insertion succeeded.
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function writeQuestion(string $name, string $surname, string $email, string $phone,
                                         string $subject, string $question, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Insertion) : $conn;
        $query = "INSERT INTO query (first_name, last_name, email, phone, subject, query) VALUES (?, ?, ?, ?, ?, ?)";

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("ssssss", $name, $surname, $email, $phone, $subject, $question);
                return $stmt->execute();
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn == null) $internalConn->close();
        }
        return false;
    }

//endregion

//region User Account Statements

    /**
     * @param string $username The name of the user to be created
     * @param string $password The password for the user.
     * @param string $email An optional email for the account to be created.
     * @param mysqli $conn An optional existing Connection. If none is passed a new one will be created.
     * @param bool $isHashed Set to true if the password is already hashed. Defaults to false.
     * @return bool True if the user successfully registered. False if an unknown error occurred.
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     * @throws RegistrationException If the user could not be registered.
     */
    public static function register(string $username, string $password, string $email = null,
                                    mysqli $conn = null, bool $isHashed = false)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Insertion) : $conn;
        // Hash the password if it hasn't been hashed before.
        $hashedPassword = $isHashed ? $password : password_hash($password, PASSWORD_DEFAULT);

        if (self::userExists($username, $internalConn)) {
            throw new RegistrationException("User already registered");
        }

        $query = "INSERT INTO account(username, password, email) VALUES (?,?,?)";

        try {
            if ($stmt = $internalConn->prepare($query)) {
                $stmt->bind_param("ssss", $username, $hashedPassword, $email);
                return $stmt->execute();
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn == null) $internalConn->close();
        }
        return false;
    }

    /**
     * @param string $username The username to check if it exists.
     * @param mysqli $conn An optional connection. If none is provided a corresponding connection will be created and closed.
     * @return bool True if the username exists in the account table.
     * @throws SQLException If there was a fatal error in the sql execution. Should never be thrown in deployment.
     */
    public static function userExists(string $username, mysqli $conn = null)
    {
        $internalConn = $conn == null ? self::createConnection(ConnectionType::Selection) : $conn;
        $query = "SELECT username FROM account WHERE username = ?";

        try {
            if ($stmt = $internalConn->prepare($query)) {
                $stmt->bind_param("s", $username);
                if (!$stmt->execute()) {
                    throw new SQLException("Failed to fetch user");
                }

                $stmt->store_result();
                $stmt->bind_result($fetchedUsername);
                $fetch = $stmt->fetch();
                $stmt->close();
                if ($fetch) {
                    return $fetchedUsername === $username;
                } else {
                    return false;
                }
            } else {
                throw new SQLException("Invalid SQL Syntax");
            }
        } finally {
            if ($conn === null) $internalConn->close();
        }
        return false;
    }

//endregion
}