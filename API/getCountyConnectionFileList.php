<?php
// Created: 2024/12/05 14:29:19
// Last Modified: 2024/12/05 15:30:12

include_once "dbheader.php";

$sql = "SELECT id, sUploadId, dtUploadSubmitted, sFileName, sUploadedBy
FROM (
    SELECT id, sUploadId, dtUploadSubmitted, sFileName, sUploadedBy,
           ROW_NUMBER() OVER (PARTITION BY YEAR(dtUploadSubmitted), MONTH(dtUploadSubmitted) ORDER BY dtUploadSubmitted DESC) AS rn
    FROM data_connect_uploads
) AS LatestUploads
WHERE rn = 1";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    echo $e->getMessage();
}
