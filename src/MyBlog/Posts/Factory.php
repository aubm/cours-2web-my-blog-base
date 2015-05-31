<?php

namespace MyBlog\Posts;

class Factory
{
    private static $posts_manager;

    /**
     * @return PostsManagerInterface
     */
    public static function getPostsManager()
    {
        $posts_original_images_dir = __DIR__ . '/../../../public/images/originals';
        $posts_original_thumbnails_dir = __DIR__ . '/../../../public/images/thumbnails';

        if (self::$posts_manager === null) {
            self::$posts_manager = new PostsManagerMySql($posts_original_images_dir, $posts_original_thumbnails_dir);
        }

        return self::$posts_manager;
    }
}