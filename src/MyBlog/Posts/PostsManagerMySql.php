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

    public function savePost(Post $post)
    {
        if (!$post->getId()) {
            $this->_insertNewPost($post);
        }
    }

    private function _insertNewPost(Post $post)
    {
        $query = 'INSERT INTO posts (title, slug, published_at, illustration_original, illustration_preview, content_short, content)';
        $query .= 'VALUES (:title, :slug, :published_at, :illustration_original, :illustration_preview, :content_short, :content)';
        $statement = $this->db->prepare($query);
        $statement->bindValue('title', $post->getTitle());
        $statement->bindValue('slug', $post->getSlug());
        $statement->bindValue('published_at', $post->getPublishedAt('Y-m-d h:i:s'));
        $statement->bindValue('illustration_original', '');
        $statement->bindValue('illustration_preview', '');
        $statement->bindValue('content_short', $post->getContentShort());
        $statement->bindValue('content', $post->getContent());
        $statement->execute();
    }
}
