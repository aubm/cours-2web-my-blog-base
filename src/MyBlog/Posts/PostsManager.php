<?php

namespace MyBlog\Posts;

class PostsManager implements PostsManagerInterface
{
    private $_mock_file_path_name;

    public function __construct($mock_file_path_name)
    {
        $this->_mock_file_path_name = $mock_file_path_name;
    }

    public function getAllPosts()
    {
        $json_data = file_get_contents($this->_mock_file_path_name);
        $posts_data = json_decode($json_data, true);
        $posts = [];
        foreach ($posts_data as $data) {
            $posts[] = new Post($data);
        }
        return $posts;
    }

    public function getOnePostBySlug($post_slug)
    {
        $posts = $this->getAllPosts();

        $post = null;

        if ($post_slug !== null) {
            foreach ($posts as $p) {
                if ($p->getSlug() === $post_slug) {
                    $post = $p;
                    break;
                }
            }
        }

        return $post;
    }

    public function savePost(Post $post)
    {
        // TODO: implement method
    }
}
