<?php
include("signUpUser.html");
include("database.php");
require_once("posts.php");
$db = new database();

$newUser = new user();
if(isset($_POST['username']) && isset($_POST['email'])){
    $newUser->setUsername($_POST['username']);
    $newUser->setEmail($_POST['email']);
    $newUser->setPassword($_POST['password']);
    $newUser->setRepeatpass($_POST['password2']);
}

$db->insertUser($newUser);