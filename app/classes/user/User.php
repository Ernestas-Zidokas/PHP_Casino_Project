<?php

namespace App\User;

class User {

    public function __construct($data = null) {
        if (!$data) {
            $this->data = [
                'email' => null,
                'balance' => null
            ];
        } else {
            $this->setData($data);
        }
    }

    public function getEmail(): string {
        return $this->data['email'];
    }

    public function setEmail(string $email) {
        $this->data['email'] = $email;
    }

    public function getBalance(): int {
        return $this->data['balance'];
    }

    public function setBalance(int $balance) {
        $this->data['balance'] = $balance;
    }

    public function setData(array $data) {
        $this->setEmail($data['email'] ?? '');
        $this->setBalance($data['balance'] ?? null);
    }

    public function getData() {
        return $this->data;
    }

}
