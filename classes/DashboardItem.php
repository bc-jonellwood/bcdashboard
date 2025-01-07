<?php

class DashboardItem
{
    private $db;

    public function __construct()
    {
        include_once(dirname(__FILE__) . '/../data/appConfig.php');
        $this->db = new appConfig();
    }

    public function getDashboardItems()
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT sCardId, sCardName FROM data_cards";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $dashboardItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $dashboardItems;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
