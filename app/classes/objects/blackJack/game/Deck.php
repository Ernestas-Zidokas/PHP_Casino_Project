<?php

namespace App\Objects\BlackJack\Game;

/* Like user repository */

class Deck {
    /* @var Array of objecsts \App\Objects\BlackJack\Card */

    protected $deck = [];
    protected $model;

    public function create() {
        $value = 0;
        $deck = [];
        foreach (\App\Objects\BlackJack\Game\Card::getSuitOptions() as $suit) {
            for ($i = 2; $i < 15; $i++) {
                if ($i == 14) {
                    $value = 11;
                } elseif ($i > 10) {
                    $value = 10;
                } else {
                    $value = $i;
                }
                $card = new Card(['suit' => $suit, 'number' => $i, 'value' => $value]);
                $deck[] = $card;
            }
        }
        shuffle($deck);
        return $deck;
    }

}
