<?php

namespace ECommerce\App\Entity;

use ECommerce\App\Entity\Entity;

class User implements Entity {
    public $id;

    public $first_name;
    public $last_name;

    public $email;
    public $password;

    public static function fromArray(array $row, string $qualifier = ''): User {
        $qualifier = $qualifier ? $qualifier . '.' : '';

        $user = new User();

        $user->id = $row[$qualifier . 'id'];

        $user->first_name = $row[$qualifier . 'first_name'];
        $user->last_name = $row[$qualifier . 'last_name'];

        $user->email = $row[$qualifier . 'email'];
        $user->password = $row[$qualifier . 'password'];

        return $user;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,

            'first_name' => $this->first_name,
            'last_name' => $this->last_name,

            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
