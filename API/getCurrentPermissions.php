<?php
// Created: 2020/10/09 11:33:11
// Last modified: 2024/10/14 14:31:54

include_once "../data/appConfig.php";

$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;


try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}

$sUserId = $_GET['userId'];
// echo $sUserId;
$data = [];

$sql = "SELECT id, sNameAndAccess from data_features_and_access";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $all_permissions = [];
    while ($row = $stmt->fetch()) {
        $all_permissions[] = $row;
    }
    array_push($data,  ['permissions' => $all_permissions]);
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}

$userSql = "SELECT dfu.id
      ,dfu.sUserId
      ,dfu.sFeatureAccessId
      ,dfa.sNameAndAccess 
  FROM data_features_access_users dfu
  JOIN data_features_and_access dfa on dfa.id = dfu.sFeatureAccessId
  WHERE dfu.sUserId = '" . $sUserId . "'";

try {
    $stmt = $conn->prepare($userSql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $user_permissions = $stmt->fetchAll();

    if (empty($user_permissions)) {
        array_push($data, ['current_permissions' => 'No Permissions Found']);
    } else {
        array_push($data, ['current_permissions' => $user_permissions]);
    }
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}


echo json_encode($data, JSON_PRETTY_PRINT);
