<?php

namespace App\Objects\BlackJack\Player;

class Repository {

    public function __construct(\Core\Database\Connection $c) {
        $this->model = new \App\Objects\BlackJack\Player\Model($c);
    }

    public function insert(\App\Objects\BlackJack\Player\Player $player) {
        return $this->model->insertIfNotExists(
                        $player->getData(), ['email']
        );
    }

    public function load($email) {
        $rows = $this->model->load([
            'email' => $email
        ]);

        foreach ($rows as $row) {
            return new \App\Objects\BlackJack\Player\Player($row);
        }
    }

    public function update(\App\Objects\BlackJack\Player\Player $player) {
        return $this->model->update($player->getData(), [
                    'email' => $player->getEmail()
        ]);
    }

    public function delete(\App\Objects\BlackJack\Player\Player $player) {
        return $this->model->delete([
                    'email' => $player->getEmail()
        ]);
    }

    public function deleteAll() {
        return $this->model->delete();
    }

    public function loadAll() {
        $rows = $this->model->load();
        $players = [];

        foreach ($rows as $row) {
            $players[] = new \App\Objects\BlackJack\Player\Player($row);
        }

        return $players;
    }

    public function exists($email) {
        return $this->model->exists([
            'email' => $email
        ]);
    }

}
