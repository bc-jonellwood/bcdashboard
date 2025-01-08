<?php

class UserAuth
{
    private $ldapHost;
    private $ldapDomain;
    private $db;

    public function __construct()
    {
        include_once 'config.php';
        $this->ldapHost = $GLOBALS['ldapServer'];
        $this->ldapDomain = $GLOBALS['ldapDomain'];
        include_once "dbconfig.php";
        $this->db = new bcdashConfig();
    }

    public function validateCredentials($username, $password)
    {
        if (trim($password) == "") return false;

        putenv('LDAPTLS_REQCERT=never');

        $ldapConn = ldap_connect($this->ldapHost) or die("Could not connect to LDAP");
        ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);

        if (@ldap_bind($ldapConn, $username . $this->ldapDomain, $password)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUser($username)
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;

        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM app_users WHERE sUserName = :username AND bIsActive = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;
                $_SESSION['employeeID'] = $row['sEmployeeNumber'] ? $row['sEmployeeNumber'] : '007';
                $_SESSION['userID'] = $row['id'] ? $row['id'] : 0;
                $_SESSION['FirstName'] = $row['sFirstName'] ? $row['sFirstName'] : 'First Name Confidential';
                $_SESSION['LastName'] = $row['sLastName'] ? $row['sLastName'] : 'Last Name Redacted';
                $_SESSION['PreferredName'] = $row['sPreferredName'] ? $row['sPreferredName'] : $row['sFirstName'];
                $_SESSION['DepartmentNumber'] = $row['iDepartmentNumber'] ? $row['iDepartmentNumber'] : 'Department is TOP SECRET';
                $_SESSION['isAdmin'] = $row['bIsAdmin'] ? $row['bIsAdmin'] : 'No Info';
                $_SESSION['isLDAP'] = $row['bIsLDAP'] ? $row['bIsLDAP'] : 'No info';
                logError("User data set in session: " . json_encode($_SESSION));
                $user_id = json_encode([
                    'userID' => $_SESSION['userID']
                ]);
                setcookie('bcdash_user', $user_id, time() + (30 * 24 * 60 * 60), "/");
                if (isset($_POST['rememberme'])) {
                    $cookie_data = json_encode([
                        'username' => $username
                    ]);
                    setcookie('rememberme', $cookie_data, time() + (30 * 24 * 60 * 60), "/"); // 30 days
                }
                $this->logLogIn();
                $this->checkEntryCount();
                return $row; // Return user data instead of true
            } else {
                $loginfailure = true;
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error in checkUser function: " . $e->getMessage());
            header("Location: 401.html");
            exit;
        } finally {
            if ($conn) {
                $conn = null;
            }
        }
    }

    public function logLogIn()
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
        }
        $UserId = $_SESSION['userID'];
        $loginTime = date('Y-m-d H:i:s');
        $sql = "UPDATE app_users SET dtLastLogin = '$loginTime', dtLastActivity = '$loginTime' WHERE id = '$UserId'";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute()) {
            logError("Login time and last activity updated successfully for user ID: $UserId");
            return true;
        } else {
            logError("Failed to update login time and last activity for user ID: $UserId");
            return false;
        }
    }

    public function checkEntryCount()
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            logError("Error in checkEntryCount function Connection: " . $e->getMessage());
        }
        $UserId = $_SESSION['userID'];
        $sql = "SELECT count(*) FROM bcg_intranet.dbo.app_user_component_order WHERE sUserId = :UserId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        logError("Count: $count");

        if ($count == 0) {
            $sql = "SELECT sCardId FROM data_cards";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $displayOrder = 0;
            foreach ($cards as $card) {
                $sql = "INSERT INTO app_user_component_order (sUserId, sComponentId, iDisplayOrder) VALUES (:UserId, :ComponentId, :DisplayOrder)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':UserId', $UserId, PDO::PARAM_STR);
                $stmt->bindParam(':ComponentId', $card['sCardId'], PDO::PARAM_STR);
                $stmt->bindParam(':DisplayOrder', $displayOrder, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    logError("Inserted component order for user ID: $UserId, Component ID: " . $card['sCardId']);
                } else {
                    logError("Failed to insert component order for user ID: $UserId, Component ID: " . $card['sCardId']);
                }
                $displayOrder++;
            }
            return true;
        } else {
            return true;
        }
        // return false;
    }

    public function checkCardAccessCount()
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            logError("Error in checkCardAccessCount function Connection: " . $e->getMessage());
        }
        $UserId = $_SESSION['userID'];
        $sql = "SELECT count(*) FROM bcg_intranet.dbo.data_cards_users WHERE sUserId = :UserId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        logError("CardAccessCount: $count");

        if ($count == 0) {
            $sql = "SELECT sCardId from data_cards where bForAll = 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($cards as $card) {
                $sql = "INSERT INTO data_cards_users (sUserId, sCardId) VALUES (:UserId, :CardId)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':UserId', $UserId, PDO::PARAM_STR);
                $stmt->bindParam(':CardId', $card['sCardId'], PDO::PARAM_STR);
                if ($stmt->execute()) {
                    logError("Inserted card access record for User ID: $UserId, Card ID:" . $card['sCardId']);
                } else {
                    logError("Failed to insert Card Access Record for user ID: $UserId, Card ID:" . $card['sCardId']);
                }
            }
            return true;
        } else {
            return true;
        }
    }

    public function checkSidenavItemCount()
    {
        $serverName = $this->db->serverName;
        $database = $this->db->database;
        $uid = $this->db->uid;
        $pwd = $this->db->pwd;
        try {
            $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            logError("Error in checkSidenavItemCount function Connection: " . $e->getMessage());
        }
        $UserId = $_SESSION['userID'];
        $sql = "SELECT count(*) FROM data_sidenav_users WHERE sUserId = :UserId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        logError("SidenavItemCount: $count");
        // return $count;
        if ($count == 0) {
            $sql = "SELECT sItemId from app_sidenav_items where bForAll = 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($items as $item) {
                $sql = "INSERT INTO data_sidenav_users (sUserId, sItemId) VALUES (:UserId, :ItemId)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':UserId', $UserId, PDO::PARAM_STR);
                $stmt->bindParam(':ItemId', $item['sItemId'], PDO::PARAM_STR);
                if ($stmt->execute()) {
                    logError("Inserted Sidenav Access Record for User ID: $UserId, Card ID:" . $item['sItemId']);
                } else {
                    logError("Failed to insert Sidenav Access Record for user ID: $UserId, Card ID:" . $item['sItemId']);
                }
            }
            return true;
        } else {
            return true;
        }
    }
}
