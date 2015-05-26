<?php

function getAllPosts()
{
    include __DIR__ . '/../posts_mocks.php';
    return $posts;
}

function getOnePostBySlug($post_slug)
{
    $posts = getAllPosts();

    $post = null;

    if ($post_slug !== null) {
        foreach ($posts as $p) {
            if ($p['slug'] === $post_slug) {
                $post = $p;
                break;
            }
        }
    }

    return $post;
}