<?php

namespace MyBlog\Posts;

class Factory
{
    private static $posts_manager;

    public static function getPostsManager()
    {
        $mock_file_path_name = __DIR__ . '/../../../posts_mocks.json';

        if (self::$posts_manager === null) {
            self::$posts_manager = new PostsManager($mock_file_path_name);
        }

        return self::$posts_manager;
    }
}