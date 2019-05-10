<?php

namespace App\Objects\BlackJack\Game;

class Card {

    const SUIT_CLUB = 'club';
    const SUIT_SPADE = 'spade';
    const SUIT_HEART = 'heart';
    const SUIT_DIAMOND = 'diamond';

    public function __construct($data = null) {
        if (!$data) {
            $this->data = [
                'id' => null,
                'suit' => null,
                'number' => null,
                'value' => null,
                'owner' => null
            ];
        } else {
            $this->setData($data);
        }
    }

    public function getId() {
        return $this->data['id'];
    }
    
    public function setId($id) {
        $this->data['id'] = $id;
    }
    
    public function getSuit() {
        return $this->data['suit'];
    }
    

    public function setSuit(string $suit) {
        if (in_array($suit, [
                    self::SUIT_CLUB,
                    self::SUIT_SPADE,
                    self::SUIT_HEART,
                    self::SUIT_DIAMOND])) {
            $this->data['suit'] = $suit;

            return true;
        }
    }

    public static function getSuitOptions() {
        return [
            self::SUIT_CLUB,
            self::SUIT_SPADE,
            self::SUIT_HEART,
            self::SUIT_DIAMOND
        ];
    }

    public function getOwner() {
        return $this->data['owner'];
    }

    public function setOwner(string $owner) {
        $this->data['owner'] = $owner;
    }

    public function getNumber() {
        return $this->data['number'];
    }

    public function setNumber(int $number) {
        $this->data['number'] = $number;
    }

    public function setValue(int $value) {
        $this->data['value'] = $value;
    }

    public function getValue() {
        return $this->data['value'];
    }

    public function setData(array $data) {
        $this->setId($data['id'] ?? null);
        $this->setNumber($data['number'] ?? null);
        $this->setValue($data['value'] ?? null);
        $this->setSuit($data['suit'] ?? '');
        $this->setOwner($data['owner'] ?? '');
    }

    public function getData() {
        return $this->data;
    }

}
