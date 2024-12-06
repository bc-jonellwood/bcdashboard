<?php
// ini_set('post_max_size', '100M');
// ini_set('upload_max_filesize', '100M');
include_once '../data/appConfig.php';
$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;


try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileName = $_FILES['file']['name'];
    $uploadDir = '../uploads/docs/connection/';
    $chunkDir = $uploadDir . 'chunks/';
    $currentYear = date('Y');
    $currentMonth = date('m');
    $currentDay = date('d');
    $currentTime = date('H:i:s');
    // $uploadFile = $uploadDir . 'Connection_' . $currentYear . '_' . $currentMonth . '_' . $currentDay . '_' . $currentTime . '.pdf'; 
    $uploadFile = $uploadDir . $fileName;

    if (!file_exists($chunkDir)) {
        mkdir($chunkDir, 0700, true);
    }

    $chunkIndex = isset($_POST['dzchunkindex']) ? $_POST['dzchunkindex'] : 0;
    $totalChunks = isset($_POST['dztotalchunkcount']) ? $_POST['dztotalchunkcount'] : 0;
    $chunkFile = $chunkDir . basename($_FILES['file']['name']) . '.part' . $chunkIndex;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $chunkFile)) {
        if ($chunkIndex == $totalChunks - 1) {
            $outFile = fopen($uploadFile, 'wb');
            for ($i = 0; $i < $totalChunks; $i++) {
                $partFile = $chunkDir . basename($_FILES['file']['name']) . '.part' . $i;
                $inFile = fopen($partFile, 'rb');
                while ($buff = fread($inFile, 4096)) {
                    fwrite($outFile, $buff);
                }
                fclose($inFile);
                unlink($partFile);
            }
            fclose($outFile);

            // Database connection
            $sFileName = $uploadFile;
            $sUploadedBy = $_SESSION['employeeID'];
            $sql = "INSERT INTO data_connect_uploads (sFileName, sUploadedBy) VALUES ('$sFileName', '$sUploadedBy')";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(['message' => 'File successfully uploaded and database updated.']);
                header("Location: ../countyconnectionadmin.php");
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'File uploaded but database update failed.']);
                return;
            }
        } else {
            http_response_code(200);
            echo json_encode(['message' => 'Chunk uploaded successfully.']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Chunk upload failed.']);
        return;
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Bad Request']);
    return;
}
