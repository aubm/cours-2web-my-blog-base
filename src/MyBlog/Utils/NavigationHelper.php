<?php

namespace MyBlog\Utils;

class NavigationHelper
{
    public function redirectClient($location)
    {
        header("Location: " . $location);
        exit();
    }
}