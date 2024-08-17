
<?php
include("connection.html");
include_once("saveComment.php");

$db = new database();
class pagination
{
    private int $totalPages;
    private int $dataAmount;
    private readonly int $data_per_page;
    private int $start;
    private array $posts;


    public function getPosts(): array
    {
        return $this->posts;
    }
    public function setPosts(array $posts): void
    {
        $this->posts = $posts;
    }

    public function __construct(int $dataAmount, int $data_per_page)
    {
        $this->start = 0;
        $this->data_per_page = $data_per_page;
        $this->dataAmount = $dataAmount;
        $this->totalPages = ceil($dataAmount / $data_per_page);
    }
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }


    public function buttonLinks(array $data): void
    {
        $page_number = null;
        include_once("database.php");
        $db = new database();

        if (isset($_GET["page"])) {
            $this->start = (int)$_GET['page'];
            $this->start = $this->start - 1;

            if ($this->start == 0) {
                $this->posts = array_slice($data, 0, 4);
            } else {
                $this->posts = array_slice($data, $this->start * 4, 4);
            }
        } else {
            $this->posts = array_slice($data, 0, 4);
        }

        //  $i = ($this->start * 4) + 1;
        foreach ($this->posts as $post) {

            echo '<div class = "pagination container">';
            echo  $post->id . ", Country: " . $post->key . ", Capital: " . $post->value . "<br>";
            echo '</div>';

            //button to display

            echo '<div class="container">';
            echo  '<button class="btn btn-secondary" style="margin-top: 10px" onclick="toggleCommentForm(' . $post->id . ')">Add Comment</button>';

            echo '<div id="comment-form-' . $post->id . '" style="display:none;">';
            $db->loadComment($post->id);
            echo '<form action="saveComment.php" class="saveComment" method="post">';
            echo '<input type="hidden" name="post_id" value="' . $post->id . '">';

            echo '<textarea name="comment" class="form-control" style="margin-bottom: 10px;" placeholder="Enter your comment"></textarea><br>';

            echo '<button type="submit" class="btn btn-info" name="submit_comment">Submit Comment</button>';

            echo '</form>';
            echo '</div>';
            echo '</div>';


            //$i++;
        }

        echo '<ul class="pagination container"">';
        for ($page_number = 1; $page_number <= $this->totalPages; $page_number++) {
            echo '<li><a href="home.php?page=' . $page_number . '">' . $page_number . '</a></li>';
        }
        echo '</ul>';
    }
}



?>