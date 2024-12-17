<?php
// include "../classes/Vehicle.php";
include "dbheader.php";

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$field = $data['field'];
$value = $data['value'];

$sql = "UPDATE data_mp_vehicles SET $field = :val WHERE sVehUid = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':val', $value, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$res = $stmt->execute();

if ($res === false) {
    echo json_encode(['success' => false, 'message' => $stmt->errorInfo()]);
    exit;
} else {
    echo json_encode(['success' => true]);
    exit;
}






// $vehicle = new Vehicle();
// $result = $vehicle->updateVehicle($id, $field, $value);

// if ($result === true) {
//     echo json_encode(['success' => true]);
// } else {
//     echo json_encode(['success' => false, 'message' => $result]);
// }
