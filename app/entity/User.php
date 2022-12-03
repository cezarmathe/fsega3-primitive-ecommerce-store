<?php

namespace ECommerce\App\Entity;

use ECommerce\App\Entity\Entity;

class User implements Entity {
    public string $id;

    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;

    public bool $isAdmin;

    public static function fromArray(array $row, string $qualifier = ''): User {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        $user = new User();

        $user->id = $row[$qualifier . 'id'];

        $user->firstName = $row[$qualifier . 'first_name'];
        $user->lastName = $row[$qualifier . 'last_name'];
        $user->email = $row[$qualifier . 'email'];
        $user->password = $row[$qualifier . 'password'];

        if ($row[$qualifier . 'is_admin'] == 't') {
            $user->isAdmin = true;
        } else {
            $user->isAdmin = false;
        }

        return $user;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,

            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,

            'is_admin' => $this->isAdmin,
        ];
    }

    public static function columns(string $qualifier = ''): array {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        return [
            $qualifier . 'id',

            $qualifier . 'first_name',
            $qualifier . 'last_name',
            $qualifier . 'email',
            $qualifier . 'password',

            $qualifier . 'is_admin',
        ];
    }
}
