<?php
// include "../classes/Vehicle.php";
include "dbheader.php";

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$field = $data['field'];
$val = $data['val'];

$sql = "UPDATE data_mp_vehicle_drivers SET $field = :val WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':val', $val, PDO::PARAM_STR);
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
