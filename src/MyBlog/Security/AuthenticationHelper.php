<?php

namespace MyBlog\Security;

use MyBlog\Http\SessionHelper;

class AuthenticationHelper
{
    /**
     * @var SessionHelper
     */
    private $session_helper;

    /**
     * @var UsersManager
     */
    private $users_manager;

    public function __construct($session_helper, $users_manager)
    {
        $this->session_helper = $session_helper;
        $this->users_manager = $users_manager;
    }

    public function authenticate($username, $password)
    {
        $user = $this->users_manager->getOneUserByUsername($username);
        if ($user !== null) {
            if ($user->getPassword() === $password) {
                $this->session_helper->set('current_user', $user);
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->session_helper->get('current_user');
    }

    public function logoutCurrentUser()
    {
        $this->session_helper->removeAll();
    }
}