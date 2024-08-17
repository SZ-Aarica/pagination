<?php

class comment
{
    private int $post_id;
    private int $user_id;
    public string $comment;

    public function __construct($post_id , $user_id , $comment)
    {
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->comment = $comment;
    }


    public function getPost_id(): int
    {
        return $this->post_id;
    }
    public function getUser_id(): int
    {
        return $this->user_id;
    }
    public function getComment(): string
    {
        return $this->comment;
    }
    public function setPostId(int $post_id): void
    {
        if ($post_id > 0) { 
            $this->post_id = $post_id;
        } else {
            throw new InvalidArgumentException("Invalid post ID.");
        }
    }

    public function setUserId(int $user_id): void
    {
        if ($user_id > 0) { 
            $this->user_id = $user_id;
        } else {
            throw new InvalidArgumentException("Invalid user ID.");
        }
    }

    public function setComment(string $comment): void
    {
        if (!empty($comment)) {
            $this->comment = trim($comment);
        } else {
            throw new InvalidArgumentException("Comment cannot be empty.");
        }
    }
}
