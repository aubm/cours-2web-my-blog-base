<?php

namespace MyBlog\Security;

use MyBlog\Database\MySqlDatabase;
use MyBlog\Http\SessionHelper;

class Factory
{
    private static $users_manager;
    private static $authentication_helper;

    public static function getUsersManager()
    {
        if (self::$users_manager === null) {
            $db = MySqlDatabase::getInstance();
            self::$users_manager = new UsersManager($db);
        }
        return self::$users_manager;
    }

    public static function getAuthenticationHelper()
    {
        if (self::$authentication_helper === null) {
            $session_helper = new SessionHelper();
            self::$authentication_helper = new AuthenticationHelper($session_helper, self::getUsersManager());
        }
        return self::$authentication_helper;
    }
}