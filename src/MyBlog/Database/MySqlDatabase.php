<?php

namespace MyBlog\Database;

class MySqlDatabase extends \PDO
{
    private static $_instance;

    public function __construct()
    {
        $data_source_name = 'mysql:dbname=2web_2015_blog;host=127.0.0.1';
        $username = 'root';
        $password = 'root';

        try {
            parent::__construct($data_source_name, $username, $password);
        } catch (\PDOException $e) {
            echo 'Failed to connect to database : ' . $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}