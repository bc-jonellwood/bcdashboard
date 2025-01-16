<?php
// Created: 2025/01/15 11:36:46
// Last modified: 2025/01/16 15:34:29

class Config
{
    public static $dbConfig = [
        'serverName' => '192.168.182.210\\INTWWW',
        'database' => 'bcg_intranet',
        'uid' => 'bcg_intranet',
        'pwd' => '*0*JsK&Ax7kdAYciyf7JbYP7ZF'
    ];
}

class Page
{
    // private $pageId;
    private $db;

    // Constructor for instance-based functionality
    public function __construct()
    {
        // $this->pageId = $pageId;
        include_once(dirname(__FILE__) . '/../data/appConfig.php');
        $this->db = new appConfig();
    }

    // Regular (instance) method
    public function getDetails($pageId)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM pages WHERE id = :pageId");
            $stmt->bindParam(':pageId', $pageId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public static function addPage($sPageName, $sPageLoc, $iMinRoleId, $sPageFeatureGroup)
    {
        $dbConfig = Config::$dbConfig;
        try {
            $conn = new PDO(
                "sqlsrv:Server={$dbConfig['serverName']};Database={$dbConfig['database']};ConnectionPooling=0;TrustServerCertificate=true",
                $dbConfig['uid'],
                $dbConfig['pwd']
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("INSERT INTO app_pages (sPageName, sPageLoc, iMinRoleId, sPageFeatureGroup) VALUES ( :sPageName, :sPageLoc, :iMinRoleId, :sPageFeatureGroup)");
            $stmt->bindParam(':sPageName', $sPageName, PDO::PARAM_STR);
            $stmt->bindParam(':sPageLoc', $sPageLoc, PDO::PARAM_STR);
            $stmt->bindParam(':iMinRoleId', $iMinRoleId, PDO::PARAM_INT);
            $stmt->bindParam(':sPageFeatureGroup', $sPageFeatureGroup, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Static method for generic utility
    public static function getAccessRequired($pageId)
    {
        $dbConfig = Config::$dbConfig;
        try {
            $conn = new PDO(
                "sqlsrv:Server={$dbConfig['serverName']};Database={$dbConfig['database']};ConnectionPooling=0;TrustServerCertificate=true",
                $dbConfig['uid'],
                $dbConfig['pwd']
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT af.iAppRoleId FROM app_features af 
            JOIN app_pages ap on ap.sFeatureId = af.id
            WHERE ap.sPageId = :pageId");
            $stmt->execute([':pageId' => $pageId]);
            // return $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getPages()
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM app_pages order by sPageFeatureGroup, sPageName");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
