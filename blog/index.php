<?php

declare(strict_types=1);
include("database.php");
include("user.php");
include("logInUser.html");
session_start();
if (isset($_SESSION['user_id'])) {
     header('Location: home.php');
     exit();
}
if (isset($_POST['email']) && isset($_POST['password'])) {
     $user = new user();
     $user->setEmail($_POST['email']);
     $user->setPassword($_POST['password']);
}
$db = new database();
if ($db->userExistance($user, false)) {

     header('Location: home.php');
     exit();
} else {
     echo "false";
}
