<?php
// Created: 2025/01/13 10:50:11
// Last modified: 2025/01/13 11:11:57

include_once "dbheader.php";
include(dirname(__FILE__) . '/../classes/User.php');
// $username = $_POST['username'];
$table = $_GET['table'];
$field = $_GET['field'];
$value = $_GET['value'];


$user = new User();

// echo $user->checkUserNameExists($username);

echo $user->checkIfExists($table, $field, $value);
