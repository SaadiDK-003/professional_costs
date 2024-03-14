<?php
session_start();
$host = $_SERVER['HTTP_HOST'];
if ($host == 'localhost') {
    $dirPath = 'professional_costs';
} else {
    $dirPath = 'panel';
}
require_once $_SERVER['DOCUMENT_ROOT'].'/'.$dirPath.'/config.php';
require_once 'functions.php';
$db = mysqli_connect(HOST,USER,PWD,DB);
if(isset($_SESSION['user'])) {
    $id = $_SESSION['user'];
    $sql = $db->query("SELECT * FROM `employees` WHERE `id`='$id'");
    $data = mysqli_fetch_object($sql);
    $username = $data->name;
    $status = $data->status;
    $role = $data->role;
    $avatar = $data->avatar;
}