<?php
// Created: 2024/11/05 13:47:18
// Last modified: 2024/11/05 16:33:27
if (!isset($_SESSION)) {
    session_start();
}
$data = [];
$showAll = $_GET['showAll'];
// echo $showAll;
$_SESSION['showAll'] = $showAll;

// add succes message to object and return to requstor
array_push($data, ['success' => 'true']);
array_push($data, ['showAll' => $showAll]);
echo json_encode($data);
