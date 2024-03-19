<?php
session_start();
$host = $_SERVER['HTTP_HOST'];
if ($host == 'localhost') {
    $dirPath = 'professional_costs';
} else {
    $dirPath = 'professional_costs';
}
$data = new stdClass();
$username = '';
$email = '';
$contact = '';
$designation = '';
$status = '';
$role = '';
$avatar = '';
$lang = '';
require_once $_SERVER['DOCUMENT_ROOT'].'/'.$dirPath.'/config.php';
require_once 'functions.php';
$db = mysqli_connect(HOST,USER,PWD,DB);
if(isset($_SESSION['user'])) {
    $id = $_SESSION['user'];
    $sql = $db->query("SELECT * FROM `employees` WHERE `id`='$id'");
    $data = mysqli_fetch_object($sql);
    $username = $data->name;
    $email = $data->email;
    $contact = $data->contact;
    $designation = $data->designation;
    $status = $data->status;
    $role = $data->role;
    $avatar = $data->avatar;
}

if (isset($_POST['lang_changer'])) {
    $_SESSION['lang'] = $_POST['lang_changer'];
}

if(isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
    if ($lang == 'ar_AR') {
        $path_ = $_SERVER['DOCUMENT_ROOT'] . '/professional_costs/language/';
        include ($path_ . "ar.php");
    }
}