<?php

namespace App\Objects\BlackJack;

/* Like user repository */

class Deck {
    /* @var Array of objecsts \App\Objects\BlackJack\Card */

    protected $deck = [];
    protected $model;

    public function __construct() {
        $this->create();
    }

    public function getDeck() {
        return $this->deck;
    }

    public function create() {
        $value = 0;

        foreach (\App\Objects\BlackJack\Card::getSuitOptions() as $suit) {
            for ($i = 2; $i < 15; $i++) {
                if ($i == 14) {
                    $value = 11;
                } elseif ($i > 10) {
                    $value = 10;
                } else {
                    $value = $i;
                }
                $card = new Card(['suit' => $suit, 'number' => $i, 'value' => $value]);
                $this->deck[] = $card;
            }
        }
    }

}
