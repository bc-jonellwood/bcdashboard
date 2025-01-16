<?php
// Created: 2025/01/07 14:17:56
// Last modified: 2025/01/16 15:44:10
// class Config
// {
//     public static $dbConfig = [
//         'serverName' => '192.168.182.210\\INTWWW',
//         'database' => 'bcg_intranet',
//         'uid' => 'bcg_intranet',
//         'pwd' => '*0*JsK&Ax7kdAYciyf7JbYP7ZF'
//     ];
// }

class SidenavItem
{
    private $db;

    public function __construct()
    {
        include_once(dirname(__FILE__) . '/../data/appConfig.php');
        $this->db = new appConfig();
    }

    // public function getUserSidenavItems($id)
    // {
    //     $serverName = $this->db->serverName;
    //     $database = $this->db->database;
    //     $uid = $this->db->uid;
    //     $pwd = $this->db->pwd;

    //     try {
    //         $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
    //         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //         $sql = "SELECT asi.Id, asi.sItemId, asi.sItemHref, asi.sItemSvgPath, asi.sItemText
    //         FROM app_sidenav_items asi
    //         JOIN data_sidenav_users dsu on dsu.sItemId = asi.sItemId
    //         where dsu.sUserId = :id
    //         order by asi.Id
    //         ";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    //         $stmt->execute();
    //         $sidenavItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         return $sidenavItems;
    //     } catch (PDOException $e) {
    //         echo 'Connection failed: ' . $e->getMessage();
    //     }
    // }
    public function getAllSidenavItems()
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;

        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT asi.Id, asi.sItemId, asi.sItemHref, asi.sItemSvgPath, asi.sItemText
            FROM app_sidenav_items asi
            order by asi.Id
            ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $allSidenavItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $allSidenavItems;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function getUserAllowedSidenavItems($userRoleId)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT sni.Id, sni.sItemId, sni.sItemHref
                ,sni.sItemSvgPath, sni.sItemText, sni.bForAll, sni.sPageId, f.iAppRoleId
                FROM app_sidenav_items AS sni
                JOIN app_pages AS p ON sni.sPageId  = p.sPageId
                JOIN app_features AS f ON p.sFeatureId  = f.id
                WHERE f.iAppRoleId >= :userRoleId
                ORDER BY sni.Id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userRoleId', $userRoleId, PDO::PARAM_INT);
            $stmt->execute();
            $userAllowedSidenavItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $userAllowedSidenavItems;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}
