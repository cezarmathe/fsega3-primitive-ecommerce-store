<?php

namespace ECommerce\App\Repository;

use ECommerce\App\Repository\BaseRepository;

use ECommerce\App\Entity\User;

// Create a Repository class that connects to PostgreSQL.
class UsersRepository extends BaseRepository {
    // Save saves a user in the database.
    public function save(User $user) {
        // Check if the user exists.
        try {
            $this->findByEmail($user->email);

            throw new \Exception('User already exists.');
        } catch (\Exception $e) {
            // Ignore the exception.
        }

        $q = <<<EOF
        insert into users (first_name, last_name, email, password)
        values ($1, $2, $3, $4)
        EOF;
        $result = $this->query($q, [
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->password
        ]);

        if (pg_affected_rows($result) != 1) {
            throw new \Exception('Failed to save user: ' . pg_last_error());
        }

        return;
    }

    // FindByID finds a user by ID.
    public function findByID($id): User {
        $result = $this->query('select * from users WHERE id = $1', [$id]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('User not found.');
        }

        return User::fromArray($row);
    }

    // FindByEmail finds a user by email.
    public function findByEmail($email): User {
        $result = $this->query('select * from users WHERE email = $1', [$email]);

        $row = pg_fetch_assoc($result);
        if (!$row) {
            throw new \Exception('User not found.');
        }

        return User::fromArray($row);
    }
}
