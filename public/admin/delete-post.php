<?php

require_once(__DIR__ . '/../../bootstrap.php');

use MyBlog\Posts\Factory;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['post_id'])) {
    http_response_code(400);
    exit();
}

$posts_manager = Factory::getPostsManager();
$posts_manager->findAndDeletePostById($_POST['post_id']);

http_response_code(204);
