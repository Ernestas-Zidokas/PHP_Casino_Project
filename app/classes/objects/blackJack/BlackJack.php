<?php

namespace App\Objects\BlackJack;

class BlackJack {

    /** @var \App\Objects\BlackJack\Deck */
    protected $deck;

    /** @var Array of Card objects */
    protected $deck_of_cards;
    protected $model;
    protected $dealers_cards = [];
    protected $your_cards = [];

    public function __construct(\App\Objects\BlackJack\Deck $deck) {
        $this->model = new \App\Objects\BlackJack\Model(\App\App::$db_conn);
        $this->deck = $deck;
        $this->deck_of_cards = $this->deck->getDeck();
        $this->shuffle();
        $this->deleteAll();
        $this->save();
        $this->play();
    }

    public function play() {
        $this->your_cards[] = $this->drawCard();
        $this->dealers_cards[] = $this->drawCard();
        $this->your_cards[] = $this->drawCard();
        $this->dealers_cards[] = $this->drawCard();

        var_dump('dealerio kortos');
        var_dump($this->dealers_cards);
        var_dump($this->countScore($this->dealers_cards));
        var_dump('tavo kortos');
        var_dump($this->your_cards);
        var_dump($this->countScore($this->your_cards));
    }

    public function countScore($hand) {
        $score = 0;
        foreach ($hand as $card) {
            $score += $card->getValue();
        }
        return $score;
    }

    public function save() {
        foreach ($this->deck_of_cards as $card) {
            $this->insertCard($card);
        }
    }

    public function shuffle() {
        shuffle($this->deck_of_cards);
    }

    public function drawCard() {
        $next_card = array_pop($this->deck_of_cards);
        $next_card_index = array_search($next_card, $this->deck_of_cards);
        unset($this->deck_of_cards[$next_card_index]);
        return $next_card;
    }

    public function insertCard(\App\Objects\BlackJack\Card $card) {
        return $this->model->insert($card->getData());
    }

    public function deleteAll() {
        return $this->model->delete();
    }

    public function loadAll() {
        $rows = $this->model->load();
        $cards = [];

        foreach ($rows as $row) {
            $cards[] = new \App\Objects\BlackJack\Card($row);
        }

        return $cards;
    }

}
