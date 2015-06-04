<?php

include ('../bootstrap.php');

$authentication_helper = \MyBlog\Security\Factory::getAuthenticationHelper();
$authentication_helper->logoutCurrentUser();

$navigation_helper = new \MyBlog\Utils\NavigationHelper();
$navigation_helper->redirectClient('index.php');
