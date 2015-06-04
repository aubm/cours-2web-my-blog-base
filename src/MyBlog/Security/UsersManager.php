<?php

namespace MyBlog\Security;

use MyBlog\Database\MySqlDatabase;

class UsersManager
{
    /**
     * @var MySqlDatabase
     */
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getOneUserByUsername($username)
    {
        $query = 'SELECT * FROM users WHERE username = :username';
        $statement = $this->db->prepare($query);
        $statement->bindValue('username', $username);
        $statement->execute();
        if ($user_data = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $user = new User();
            $this->hydrateUser($user, $user_data);
            return $user;
        } else {
            return null;
        }
    }

    private function hydrateUser(User $user, array $user_data)
    {
        if (isset($user_data['username'])) {
            $user->setUsername($user_data['username']);
        }

        if (isset($user_data['password'])) {
            $user->setPassword($user_data['password']);
        }

        if (isset($user_data['password_confirmation'])) {
            $user->setPasswordConfirmation($user_data['password_confirmation']);
        }
    }
}