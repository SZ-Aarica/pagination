<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="script.js"></script>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous" />
</head>

<body>
</body>

</html>

<?php


include("database.php");
include_once('comment.php');

$db = new database();
session_start();
if (isset($_POST['submit_comment'])) {
    if (!empty($_POST['comment'])) {
        $newComment = new comment(intval($_POST['post_id']), $_SESSION['user_id'], $_POST['comment']);
        $db->saveComments($newComment);
    } else {
        echo '<div style="color: red; font-size: 16px; font-weight: bold;">comments cant be empty</div>';
    }

    // $newComment->setPostId(intval($_POST['post_id']));
    //$newComment->setUserId($_SESSION['user_id']);
    // $newComment->setComment($_POST['comment']);
    
}
?>