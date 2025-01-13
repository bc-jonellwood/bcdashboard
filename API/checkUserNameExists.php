<?php
// Created: 2025/01/13 10:50:11
// Last modified: 2025/01/13 11:06:20

include_once "dbheader.php";
include(dirname(__FILE__) . '/../classes/User.php');
// $username = $_POST['username'];
$username = $_GET['username'];

$user = new User();

// echo $user->checkUserNameExists($username);

echo $user->checkIfExists('app_users', 'sUserName', $username);
