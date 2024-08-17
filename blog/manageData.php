<?php

declare(strict_types=1);
include("header.html");
include("addDataFor.html");
include("database.php");
require_once("posts.php");

$db = new database();
$newPost = new post(0 , $_POST['key'] , $_POST['value']);
$db->addposts($newPost);

?>