<?php

namespace MyBlog\Http;

class SessionHelper
{
    public function get($key_name)
    {
        return (isset($_SESSION[$key_name])) ? unserialize($_SESSION[$key_name]) : null;
    }

    public function set($key_name, $value)
    {
        $_SESSION[$key_name] = serialize($value);
    }

    public function remove($key_name)
    {
        unset($_SESSION[$key_name]);
    }

    public function removeAll()
    {
        session_unset();
    }
}