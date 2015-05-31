<?php

require_once(__DIR__ . '/../../bootstrap.php');

use MyBlog\Utils\NavigationHelper;
use MyBlog\Posts\Factory;

$navigation_helper = new NavigationHelper();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['post_id'])) {
    $navigation_helper->redirectClient('/admin');
}

$posts_manager = Factory::getPostsManager();
$posts_manager->findAndDeletePostById($_POST['post_id']);

$navigation_helper->redirectClient('/admin');
