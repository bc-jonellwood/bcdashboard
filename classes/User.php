<?php

class User
{
    private $db;

    public function __construct()
    {
        include_once(dirname(__FILE__) . '/../data/appConfig.php');
        $this->db = new appConfig();
    }

    public function getUsers($limit, $offset, $aciveFilterEnabled = false, $tempFilterEnabled = false, $lastNameStartsWith = '')
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;


        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT au.id, au.sUserName, au.sHashedPass, au.sEmployeeNumber, au.sFirstName, au.sPreferredName, au.sMiddleName
                ,au.sLastName, au.dtDateOfBirth, au.iDepartmentNumber, au.sEmail, au.sMainPhoneNumber
                ,au.sMainPhoneNumberLabel, au.sSecondaryPhoneNumber, au.sSecondaryPhoneNumberLabel, au.bIsActive
                ,au.bIsLDAP, au.bIsAdmin, au.bHideBirthday, au.dtLastLogin, au.dtLastSystemUpdate
                ,au.dtStartDate, au.dtSeparationDate, au.iStatus, au.bShowStatus, au.sJobTitle ,au.sADStatus
                ,dd.sDepartmentName
                ,mvd.id as iDriverId, mvd.dtFleetTestPassed, mvd.dtFuelCardTestPassed, mvd.dtAcknowledge, mvd.dtDlExpires
                ,mvd.dtFleetTestAttempt, mvd.iFleetTestAttemptCount
                FROM app_users au
                LEFT JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
                LEFT join data_mp_vehicle_drivers mvd on mvd.sUserId = au.id";

            $whereClauseAdded = false;

            if ($aciveFilterEnabled) {
                $sql .= $whereClauseAdded ? " AND au.sADStatus = 1" : " WHERE au.sADStatus = 1";
                $whereClauseAdded = true;
            }

            if ($tempFilterEnabled) {
                $sql .= $whereClauseAdded ? " AND au.sEmployeeNumber NOT like '%P%'" : " WHERE au.sEmployeeNumber NOT like '%P%'";
                $whereClauseAdded = true;
            }
            if (!empty($lastNameStartsWith)) {
                $sql .= $whereClauseAdded ? " AND au.sLastName LIKE :lastNameStart" : " WHERE au.sLastName LIKE :lastNameStart";
                $whereClauseAdded = true;
            }

            $sql .= " ORDER BY au.sLastName, au.sFirstName
            OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY
        ";
            $stmt = $conn->prepare($sql);
            if (!empty($lastNameStartsWith)) {
                $stmt->bindValue(':lastNameStart', $lastNameStartsWith . '%');
            }
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getUserCount($aciveFilterEnabled = false)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT COUNT(*) as count FROM app_users";
            if ($aciveFilterEnabled) {
                $sql .= " WHERE sADStatus = 1";
            }
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            return $count['count'];
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getUser($id)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT au.id, au.sUserName, au.sHashedPass, au.sEmployeeNumber, au.sFirstName, au.sPreferredName, au.sMiddleName
                ,au.sLastName, au.dtDateOfBirth, au.iDepartmentNumber, au.sEmail, au.sMainPhoneNumber
                ,au.sMainPhoneNumberLabel, au.sSecondaryPhoneNumber, au.sSecondaryPhoneNumberLabel, au.bIsActive
                ,au.bIsLDAP, au.bIsAdmin, au.bHideBirthday, au.dtLastLogin, au.dtLastSystemUpdate
                ,au.dtStartDate, au.dtSeparationDate, au.iStatus, au.bShowStatus, au.sJobTitle ,au.sADStatus, au.sProfileImgPath
                ,dd.sDepartmentName
                ,mvd.id as iDriverId, mvd.dtFleetTestPassed, mvd.dtFuelCardTestPassed, mvd.dtAcknowledge, mvd.dtDlExpires
                ,mvd.dtFleetTestAttempt, mvd.iFleetTestAttemptCount
                FROM app_users au
                LEFT JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
                LEFT join data_mp_vehicle_drivers mvd on mvd.sUserId = au.id where au.id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getUserByUserName($username)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT au.id, au.sUserName, au.sHashedPass, au.sEmployeeNumber, au.sFirstName, au.sPreferredName, au.sMiddleName
                ,au.sLastName, au.dtDateOfBirth, au.iDepartmentNumber, au.sEmail, au.sMainPhoneNumber
                ,au.sMainPhoneNumberLabel, au.sSecondaryPhoneNumber, au.sSecondaryPhoneNumberLabel, au.bIsActive
                ,au.bIsLDAP, au.bIsAdmin, au.bHideBirthday, au.dtLastLogin, au.dtLastSystemUpdate
                ,au.dtStartDate, au.dtSeparationDate, au.iStatus, au.bShowStatus, au.sJobTitle ,au.sADStatus
                ,dd.sDepartmentName
                ,mvd.id as iDriverId, mvd.dtFleetTestPassed, mvd.dtFuelCardTestPassed, mvd.dtAcknowledge, mvd.dtDlExpires
                ,mvd.dtFleetTestAttempt, mvd.iFleetTestAttemptCount
                FROM app_users au
                LEFT JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber                
                LEFT join data_mp_vehicle_drivers mvd on mvd.sUserId = au.id where au.sUserName = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function updateUser($id, $field, $val)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE app_users SET $field = :val WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':val', $val, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function updateUserDepartments($id, $departments)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;

        try {
            $conn = new PDO(
                "sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true",
                $uid,
                $pwd
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "
            IF NOT EXISTS (
                SELECT 1 FROM data_emp_departments 
                WHERE sUserId = :id AND iDepartmentId = :departmentId
            )
            BEGIN
                INSERT INTO data_emp_departments (sUserId, iDepartmentId)
                VALUES (:id, :departmentId)
            END
        ";

            $stmt = $conn->prepare($sql);

            // Loop over de IDs
            foreach ($departments as $departmentId) {
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
                $stmt->execute();
            }

            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getUserAdditionalDepartments($id)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT ed.iDepartmentNumber, dd.sDepartmentName 
                from data_emp_departments ed
                LEFT JOIN data_departments dd on dd.iDepartmentNumber = ed.iDepartmentNumber
                where ed.sUserId = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $userDepartments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $userDepartments;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getUserDashboardItems($id)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM data_cards_users WHERE sUserId = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $dashboardItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $dashboardItems;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getUserSidenavItems($id)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM data_sidenav_users WHERE sUserId = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $sidenavItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $sidenavItems;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    public function updateLastActivity($id)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE app_users set dtLastActivity = getdate() where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function addUser()
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO app_users (sUsername, sPassword, sEmail, sFirstName, sLastName, bIsActive, bIsLDAP) VALUES (:username, :password, :email, :fname, :lname, 1, 0)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function checkUserNameExists($username)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT COUNT(*) as count FROM app_users WHERE sUsername = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            return $count['count'];
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function checkIfExists($table, $field, $value)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT COUNT(*) as count FROM $table WHERE $field = :value";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':value', $value);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            return $count['count'];
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // public function validateUserPassword($username, $password)
    // {
    //     $serverName = $this->db->serverName;
    //     $database = $this->db->database;
    //     $uid = $this->db->uid;
    //     $pwd = $this->db->pwd;
    //     try {
    //         $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
    //         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //         $sql = "SELECT COUNT(*) as count FROM app_users WHERE sUsername = :username AND sPassword = :password";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bindParam(':username', $username);
    //         $stmt->bindParam(':password', $password);
    //         $stmt->execute();
    //         $count = $stmt->fetch(PDO::FETCH_ASSOC);
    //         return $count['count'];
    //     } catch (PDOException $e) {
    //         echo "Connection failed: " . $e->getMessage();
    //     }
    // }
}
