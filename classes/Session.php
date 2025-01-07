<?php
// Created: 2025/01/07 12:30:17
// Last modified: 2025/01/07 12:57:34

class CustomSessionHandler implements SessionHandlerInterface
{
    private $db;

    public function __construct()
    {
        include_once(dirname(__FILE__) . '/../data/appConfig.php');
        $this->db = new appConfig();
    }
    // Open
    public function open($savePath, $sessionName): bool
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Close
    public function close(): bool
    {
        // Close the database connection
        $this->db = null; // Closing connection
        return true;
    }

    // Read
    public function read($sessionId): string
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * from data_sessions where sSessionId = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $sessionId);
            $stmt->execute();
            return $stmt->fetchColumn() ?: ''; // Return session data or empty string
        } catch (PDOException) {
            return '';
        }
    }

    // Write
    public function write($sessionId, $data): bool
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "REPLACE INTO data_sessions (sSessionId, sUserId, dtLastActive) VALUES (:id, :userId, :time)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $sessionId);
            $stmt->bindParam(":userId", $userId);
            $stmt->bindParam(":time", time());
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function writeData($sessionId, $userId): bool
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "REPLACE INTO data_sessions (sSessionId, sUserId, dtLastActive) VALUES (:id, :userId, :time)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $sessionId);
            $stmt->bindParam(":userId", $userId);
            $stmt->bindParam(":time", time());
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Destroy
    public function destroy($sessionId): bool
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM data_sessions WHERE sSessionId = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $sessionId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Garbage Collection
    public function gc($maxLifetime): int|false
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM data_sessions WHERE dtLastActive = :time";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':time', time());
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

// Register the custom session handler
$handler = new CustomSessionHandler();
session_set_save_handler($handler, true);
session_start(); // Start the session
