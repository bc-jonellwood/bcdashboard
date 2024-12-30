<?php
// Created: 2024/12/09 10:49:52
// Last modified: 2024/12/30 15:25:03
session_start();
include_once "dbheader.php";

$userID = $_SESSION["userID"];
// get a list of card ID's the user wants to hide as a POST
// for each id in the list update the database
if (isset($_POST['cards'])) {
    $cards = $_POST['cards'];
    foreach ($cards as $cardId => $isVisible) {
        $sql = "UPDATE app_user_component_order uco SET uco.bIsVisible = 0
                where sUserId = :userID and sComponentId = :cardId";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':cardId', $cardId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $response = $e->getMessage();
        }
    }
} else {
    echo "no cards in the list";
}



// $componentList = json_decode(file_get_contents('php://input'), true);
// $sql = "UPDATE app_user_component_order uco SET uco.bIsVisible = 0
//         where sUserId = :userID and sComponentId in $componentList";

// try {
//     $stmt = $conn->prepare($sql);
//     $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
//     $stmt->execute();
//     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     header('Content-Type: application/json');
//     echo json_encode($result);
// } catch (PDOException $e) {
//     $response = $e->getMessage();
// }
