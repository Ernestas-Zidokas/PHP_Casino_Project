<?php

namespace App\Objects\BlackJack\Game;

class Repository {

    const OWNER_PLAYER = 'player';
    const OWNER_DEALER = 'dealer';

    public function __construct(\Core\Database\Connection $c) {
        $this->model = new \App\Objects\BlackJack\Game\Model($c);
    }

    public function insertCard(\App\Objects\BlackJack\Game\Card $card) {
        return $this->model->insert($card->getData());
    }

    public function deleteAll() {
        return $this->model->delete();
    }

    public function update(\App\Objects\BlackJack\Game\Card $card) {
        return $this->model->update(['owner' => $card->getOwner()], [
                    'id' => $card->getId(),
        ]);
    }

    public function delete(\App\Objects\BlackJack\Game\Card $card) {
        return $this->model->delete([
                    'number' => $card->getNumber(),
                    'value' => $card->getValue()
        ]);
    }

    public function loadAll() {
        $rows = $this->model->load();
        $cards = [];

        foreach ($rows as $row) {
            $cards[] = new \App\Objects\BlackJack\Game\Card($row);
        }

        return $cards;
    }

    public function loadDealersCards() {
        $dealer_cards = [];
        $rows = $this->model->load([
            'owner' => self::OWNER_DEALER
        ]);

        foreach ($rows as $row) {
            $dealer_cards[] = new \App\Objects\BlackJack\Game\Card($row);
        }

        return $dealer_cards;
    }

    public function loadPlayersCards() {
        $player_cards = [];
        $rows = $this->model->load([
            'owner' => self::OWNER_PLAYER
        ]);

        foreach ($rows as $row) {
            $player_cards[] = new \App\Objects\BlackJack\Game\Card($row);
        }

        return $player_cards;
    }

}
