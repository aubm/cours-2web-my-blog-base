<?php

class Factory
{
    private static $posts_manager;

    public static function getPostsManager()
    {
        $mock_file_path_name = __DIR__ . '/../../posts_mocks.json';
        $posts_manager = new PostsManager($mock_file_path_name);
        return $posts_manager;
    }
}