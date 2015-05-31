<?php

namespace MyBlog\Posts;

interface PostsManagerInterface
{
    /**
     * @return Post[]
     */
    public function getAllPosts();

    /**
     * @return Post
     */
    public function getOnePostBySlug($post_slug);

    /**
     * @param Post $post
     */
    public function savePost(Post $post);
}