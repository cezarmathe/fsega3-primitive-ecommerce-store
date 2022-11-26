<?php

namespace ECommerce\App\Service;

use ECommerce\App\Entity\User;
use ECommerce\App\Repository\UsersRepository;

class UsersService {
    private UsersRepository $repository;

    // Constructor creates a Repository object.
    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    // Load loads the user from the session and returns it.
    //
    // If not logged in it redirects to the login page
    public function assert(): User {
        if (UsersService::isLoggedIn()) {
            return $this->repository->findByID($_SESSION['user_id']);
        } else {
            header('Location: /login.php');
            exit;
        }
    }

    // Login attempts to log in the user.
    //
    // Throws an exception if the user is not found or the password is
    // incorrect.
    //
    // If successful it sets the user_id in the session.
    public function login($email, $password) {
        // Load the user from the repository.
        $user = $this->repository->findByEmail($email);

        // Check if the user exists.
        if ($user == null) {
            throw new \Exception('User not found.');
        }

        // Check if the password is correct.
        // if ($password != $user->password) {
            // throw new Exception('Incorrect password.');
        // }
        if (!password_verify($password, $user->password)) {
            throw new \Exception('Invalid password.');
        }

        $_SESSION['user_id'] = $user->id;

        return;
    }

    // Create creates a new user.
    //
    // Throws an exception if the user already exists.
    //
    // If successful it will run the login function.
    public function create($first_name, $last_name, $email, $password) {
        $user = new User();

        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);

        $this->repository->save($user);

        return $this->login($email, $password);
    }

    // Returns true if the user is logged in.
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

