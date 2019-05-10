<?php

namespace App\Objects\BlackJack;

class BlackJack {

    /** @var Array of Card objects */
    protected $deck_of_cards;
    protected $model;
    protected $dealers_cards = [];
    protected $player_cards = [];
    protected $game_repo;

    const OWNER_PLAYER = 'player';
    const OWNER_DEALER = 'dealer';
    const OUTCOME_LOSE = 0;
    const OUTCOME_WIN = 1;
    const OUTCOME_TIE = 2;

    public function __construct() {
        $this->model = new \App\Objects\BlackJack\Game\Model(\App\App::$db_conn);
        $this->game_repo = new Game\Repository(\App\App::$db_conn);
    }

    public function getPlayerCards() {
        return $this->player_cards;
    }

    public function getDealersCards() {
        return $this->dealers_cards;
    }

    public function setDealerCards($dealer_cards) {
        $this->dealers_cards = $dealer_cards;
    }

    public function setPlayerCards($player_cards) {
        $this->player_cards = $player_cards;
    }

    public function setDeck($deck_of_cards) {
        $this->deck_of_cards = $deck_of_cards;
    }

    public function isNewRound() {
        if (empty($this->getDealersCards()) && empty($this->getPlayerCards())) {
            return true;
        }
    }

    public function drawDealerCard() {
        $this->dealers_cards[] = $this->drawCard(self::OWNER_DEALER);
    }

    public function drawPlayerCard() {
        $this->player_cards[] = $this->drawCard(self::OWNER_PLAYER);
    }

    public function stand() {
        if ($this->countScore($this->getPlayerCards()) > 21) {
            $success = self::OUTCOME_LOSE;
        } else {
            while ($this->countScore($this->getDealersCards()) < 17) {
                $this->drawDealerCard();
            }
            if ($this->countScore($this->getDealersCards()) > 21) {
                $success = self::OUTCOME_WIN;
            } else {
                $success = $this->outcome($this->countScore(
                                $this->getDealersCards()), $this->countScore($this->getPlayerCards()));
            }
        }

        return $success;
    }

    public function outcome($dealers_hand, $players_hand) {
        var_dump('Dealers hand ');
        var_dump($dealers_hand);
        var_dump('Players hand ');
        var_dump($players_hand);
        if ($players_hand == $dealers_hand) {
            return self::OUTCOME_TIE;
        } elseif ($players_hand > $dealers_hand) {
            return self::OUTCOME_WIN;
        } else {
            return self::OUTCOME_LOSE;
        }
    }

    public function play() {
        if ($this->isNewRound()) {
            $this->drawPlayerCard();
            $this->drawDealerCard();
            $this->drawPlayerCard();
            $this->drawDealerCard();
        }
    }

    public function hit() {
        $this->drawPlayerCard();
    }

    public function countScore($hand) {
        $score = 0;
        $aces = 0;
        foreach ($hand as $card) {
            if ($card->getNumber() == 14) {
                $aces++;
            }
            $score += $card->getValue();
            for ($i = 0; $i < $aces; $i++) {
                if($score > 21) {
                    $score -= 10;
                }
            }
        }

        return $score;
    }

    public function save() {
        foreach ($this->deck_of_cards as $card) {
            $this->game_repo->insertCard($card);
        }
    }

    public function getDeck() {
        return $this->deck_of_cards;
    }

    public function drawCard($owner) {
        $target_card = null;

        foreach ($this->deck_of_cards as &$card) {
            if (!$card->getOwner()) {
                $target_card = $card;
                $target_card->setOwner($owner);
                break;
            }
        }

        if (!$card) {
            var_dump($this->deck_of_cards);
            throw new Exception('Nebeliko kortu...');
        }

        $this->game_repo->update($target_card);

        return $target_card;
    }

}
