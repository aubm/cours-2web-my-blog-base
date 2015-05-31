<?php

namespace MyBlog\Posts;

use MyBlog\Database\MySqlDatabase;

class PostsManagerMySql implements PostsManagerInterface
{
    /**
     * @var MySqlDatabase
     */
    private $db;

    public function __construct()
    {
        $this->db = MySqlDatabase::getInstance();
    }

    public function getAllPosts()
    {
        $posts = [];
        $statement = $this->db->prepare('SELECT * FROM posts');
        $statement->execute();
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $posts[] = new Post($row);
        }
        return $posts;
    }

    public function getOnePostBySlug($post_slug)
    {
        $post = null;
        $statement = $this->db->prepare('SELECT * FROM posts WHERE slug = :slug');
        $statement->bindParam('slug', $post_slug);
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $post = new Post($row);
        }
        return $post;
    }
}
