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
     * @throw \MyBlog\Validation\HasValidationErrorsException
     * @param Post $post
     */
    public function validatePost(Post $post);

    /**
     * @param Post $post
     */
    public function savePost(Post $post);
}