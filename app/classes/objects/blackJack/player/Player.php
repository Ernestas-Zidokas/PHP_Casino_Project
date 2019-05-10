<?php

namespace App\Objects\BlackJack\Player;

class Player {

    public function __construct($data = null) {
        if (!$data) {
            $this->data = [
                'email' => null,
                'in_game' => null,
                'bet_size' => null
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

    public function getInGame(): int {
        return $this->data['in_game'];
    }

    public function setInGame(int $ingame) {
        $this->data['in_game'] = $ingame;
    }

    public function getBetSize(): int {
        return $this->data['bet_size'];
    }

    public function setBetSize(int $bet_size) {
        $this->data['bet_size'] = $bet_size;
    }

    public function setData(array $data) {
        $this->setEmail($data['email'] ?? '');
        $this->setInGame($data['in_game'] ?? null);
        $this->setBetSize($data['bet_size'] ?? null);
    }

    public function getData() {
        return $this->data;
    }

}
