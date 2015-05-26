<?php

function getAllPosts()
{
    $json_data = file_get_contents(__DIR__ . '/../posts_mocks.json');
    $posts = json_decode($json_data, true);
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
