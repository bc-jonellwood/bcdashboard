<?php

class Driver
{
    private $db;

    public function __construct()
    {
        include(dirname(__FILE__) . '/../data/appConfig.php');
        $this->db = new appConfig();
    }

    public function getDrivers()
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;

        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT dvp.id, dvp.sBcgiId, dvp.sEmployeeNumber, dvp.sUserId, dvp.dtDlExpires, dvp.dtFleetTestAttempt, dvp.iFleetTestAttemptCount, dvp.         dtFleetTestPassed, dvp.dtFuelCardTestPassed, dvp.dtAcknowledge, dvp.dlFront, dvp.dlBack, dvp.sNotes, au.sFirstName, au.sLastName
                    FROM data_mp_vehicle_drivers dvp
                    JOIN app_users au on dvp.sUserId = au.id
                    where au.sADStatus = 'Enabled'
                    order by au.sLastName, au.sFirstName";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $drivers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $drivers;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateDriver($id, $field, $val)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE data_mp_vehicle_drivers SET $field = :val WHERE id = :id";
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
