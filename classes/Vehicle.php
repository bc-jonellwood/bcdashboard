<?php

class Vehicle
{
    private $db;

    public function __construct()
    {
        // include_once "./data/appConfig.php";
        include(dirname(__FILE__) . "/../data/appConfig.php");
        $this->db = new appConfig();
    }

    public function getVehicles()
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;

        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT dmv.iLegacyId, dmv.sVehUid, dmv.sVehName, dmv.iVehMaxOccupancy, dmv.iVehOdometer, 
            dmv.bIsRetired, dmv.sVehUnitNum, dmv.sVehVin, dmv.bVehCargoSpace, dmv.iVehNextServiceOdometer, 
            dmv.bOutForService, dmv.bIsAvailable, dl.sLocName
            FROM data_mp_vehicles dmv
            JOIN data_locations dl on dl.sLocUid = dmv.sVehLocationId
            ORDER by dmv.bIsRetired ASC, dmv.sVehName ASC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $vehicles;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    // function to update a vehicle. Accepts the id of the vehicle, the field to update, and the new value
    public function updateVehicle($id, $field, $val)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;

        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE data_mp_vehicles SET $field = :val WHERE sVehUid = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':val', $val, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
