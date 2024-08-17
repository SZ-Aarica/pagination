<?php
include('posts.php');
include('connection.html');

class database
{
    private $db_server = 'localhost';
    private $db_user = "root";
    private $db_password = "";
    private $db_name = "mydatabase";
    public $connection;

    public function __construct()
    {
        $this->connection = mysqli_connect($this->db_server, $this->db_user, $this->db_password, $this->db_name);
        /* if($this->connection){
        echo "connected <br>";
    }*/
    }
    //insert new users to the database
    public function insertUser(User $user): void
    {
        $email = $user->getEmail();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $repeatpass = $user->getRepeatpass();
        if ($password == $repeatpass) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        } else {

            echo '<div style="color: red; font-size: 16px; font-weight: bold;">Passwords do not match</div>';
            exit();
        }
        $sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password); // "sss" indicates three string parameters

        if (mysqli_stmt_execute($stmt)) {
            echo "User inserted successfully";
            header('Location: home.php');
        } elseif (mysqli_errno($this->connection) == 1062) {
            echo "This email is already registered. Please use a different email.";
        } else {
            echo "Error inserting user: " . mysqli_error($this->connection);
        }



        mysqli_stmt_close($stmt);
    }

    //check if a user is in a data base or not --> use in index and admin
    public function userExistance(User $user, bool $admin): bool
    {

        $password = $user->getPassword();
        $sql = "";
        $stmt = null;


        if ($admin) {
            $username = $user->getUsername();
            $sql = "SELECT * FROM `admin` WHERE username = ?";
            $stmt = mysqli_prepare($this->connection, $sql);
            mysqli_stmt_bind_param($stmt, "s", $username);
        } elseif (!$admin) {
            $email = $user->getEmail();
            $sql = "SELECT * FROM `users` WHERE email = ?";
            $stmt = mysqli_prepare($this->connection, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id']; // save the session
                $_SESSION['is_admin'] = $admin;


                return true;
            }
        }


        return false;
    }

    //function for admin to add new data
    public function addposts(post $post): void
    {
        $key = $post->getKey();
        $value = $post->getValue();
        $sql = "INSERT INTO `posts`(`country`, `capital`) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->connection, $sql);

        if ($stmt === false) {
            echo '<div style="color: red; font-size: 16px; font-weight: bold;">Error preparing the statement</div>';
            return;
        }

        mysqli_stmt_bind_param($stmt, "ss", $key, $value);

        if (mysqli_stmt_execute($stmt)) {
            echo '<div style="color: green; font-size: 16px; font-weight: bold;">New data added successfully</div>';
        } else {
            echo '<div style="color: red; font-size: 16px; font-weight: bold;">No data added</div>';
        }

        mysqli_stmt_close($stmt);
    }

    public function saveComments(comment $newComment): void
    {
        $post_id = $newComment->getPost_id();
        $user_id = $newComment->getUser_id();
        $comment = $newComment->getComment();
        $sql = "INSERT INTO `comments` (`id_post`, `user_id`, `comment`) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $post_id, $user_id, $comment);
        if (mysqli_stmt_execute($stmt)) {
            echo '<div style="color: green; font-size: 16px; font-weight: bold;">your comment was added successfully</div>';
            header('Location: home.php');
        } else {
            echo '<div style="color: red; font-size: 16px; font-weight: bold;">not able to add comment </div>';
        }

        mysqli_stmt_close($stmt);
    }

    public function storeData(): array
    {

        $postsArray = [];
        $sql = "SELECT * FROM `posts`";
        $result =  mysqli_query($this->connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $post = new post($row['id'], $row['country'], $row['capital']);
                $postsArray[] = $post;
            }
        }
        return $postsArray;
    }
    public function loadComment(int $post_id): void
    {
        // $commentsArray = [];

        $sql = "SELECT * FROM `comments` WHERE id_post = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        if ($stmt === false) {
            die('Prepare failed: ' . mysqli_error($this->connection));
        }
        mysqli_stmt_bind_param($stmt, "i", $post_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {

            $newComment =  new comment($row['id_post'], $row['user_id'], $row['comment']);
            echo '<div class="card" style="width: 18rem; text-center; margin-bottom: 10px;">';
            echo '<ul class="list-group list-group-flush" >';
            echo  '<li style="margin-left: 10px; list-style: none">' . $newComment->comment . "</li><br>";
            echo '</ul>';
            echo '</div>';



            // $commentsArray[] = $newComment;
        }
        mysqli_stmt_close($stmt);
        // return $commentsArray;
    }
}
/*
include("user.php");
$db = new database();
$user = new user();
$user->setUsername("aarica");
$user->setEmail("sabamovie.1380@gmail.com");
$user->setPassword("moneymoney");
$db->userExistance($user);*/
