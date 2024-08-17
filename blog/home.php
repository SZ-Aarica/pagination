<?php
include("header.html");
include_once("pagination.php");
include_once("database.php");


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    $db = new database();
    $posts = $db->storeData();
    $pagination = new pagination(count($posts), 4);

    echo $pagination->buttonLinks($posts);
} else {
    header('Location: index.php');
}




//$hi = array_slice($posts , 8 , 12);
/*
foreach ($hi as $post) {
    echo "ID: " . $post->id . ", Country: " . $post->key . ", Capital: " . $post->value . "<br>";
    
}
*/
