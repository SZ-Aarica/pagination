<?php

declare(strict_types=1);
include('header.html');
include("database.php");
include('logInAdmin.html');
include("user.php");
session_start();
$db = new database();
if (isset(($_SESSION['user_id'])) && isset($_SESSION['is_admin'])) {

    header('Location: manageData.php');
} 
$admin = new user();
if (isset($_POST['username']) && isset($_POST['password'])) {
    $admin->setUsername($_POST['username']);
    $admin->setPassword($_POST['password']);
}
if($db->userExistance($admin, true)){
    header('Location: manageData.php');
}

