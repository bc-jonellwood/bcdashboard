<?php
ini_set('post_max_size', '100M');
ini_set('upload_max_filesize', '100M');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $uploadDir = '../uploads/docs/connection/';
    $currentYear = date('Y');
    $currentMonth = date('m');
    $uploadFile = $uploadDir . 'Connection_' . $currentYear . '_' . $currentMonth . '.pdf';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0700, true);
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        echo "File successfully uploaded.";
    } else {
        echo "File upload failed.";
    }
} else {
    echo "No file uploaded.";
}
