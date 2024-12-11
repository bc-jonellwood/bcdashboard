<?php
// Created: 2024/12/11 12:10:50
// Last modified: 2024/12/11 14:35:49
session_start();
require_once 'dbheader.php';
$user_id = $_SESSION['userID'];
// echo json_encode($_POST);
$cardOrder = $_POST['cards'];
foreach ($cardOrder as $key => $value) {
    $cardId = $value;
    // $order is the index of the card in the cardOrder array
    $order = $key;
    // $order = $value['order'];
    $sql = "UPDATE app_user_component_order SET iDisplayOrder = $order WHERE sComponentId = '$cardId' and sUserId = '$user_id'";
    // echo $sql;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt) {
        echo json_encode(array("statusCode" => 200));
        header("Location: ../index.php");
    } else {
        echo json_encode(array("statusCode" => 201));
        header("Location: ../index.php");
    }
}
