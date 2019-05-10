<?php

namespace App\Controller;

class BlackJack extends Base {

    /** @var \App\Objects\Form\BlackJack */
    protected $player;
    protected $player_repo;
    protected $blackjack;
    protected $game_repo;

    public function __construct() {
        if (!\App\App::$session->isLoggedIn() === true) {
            header('Location: /home');
            exit();
        }
        parent::__construct();

        $this->player_repo = new \App\Objects\BlackJack\Player\Repository(\App\App::$db_conn);
        $this->player = $this->player_repo->load(\App\App::$session->getUser()->getEmail());
        $this->game_repo = new \App\Objects\BlackJack\Game\Repository(\App\App::$db_conn);

        if (!$this->player) {
            $this->player = new \App\Objects\BlackJack\Player\Player([
                'email' => \App\App::$session->getUser()->getEmail(),
                'in_game' => 0,
                'bet_size' => 0
            ]);
            $this->player_repo->insert($this->player);
        }

        if (!$this->player->getInGame()) {
            $form_bet = new \App\Objects\Form\BlackJackBet();
            $status_bet = $form_bet->process();

            $view = new \Core\Page\View([
                'title' => 'Place your bet'
            ]);
            $this->page['content'] = $view->render(ROOT_DIR . '/app/views/content.tpl.php');

            switch ($status_bet) {
                case \App\Objects\Form\BlackJackBet::STATUS_SUCCESS:
                    $deck = new \App\Objects\BlackJack\Game\Deck();
                    $blackjack = new \App\Objects\BlackJack\BlackJack();
                    $blackjack->setDeck($deck->create());
                    $blackjack->save();

                    $player_input_bet = $form_bet->getInput();
                    $this->player = new \App\Objects\BlackJack\Player\Player([
                        'email' => \App\App::$session->getUser()->getEmail(),
                        'in_game' => 1,
                        'bet_size' => $player_input_bet['bet']
                    ]);
                    $this->player_repo->update($this->player);
                    break;
            }

            $this->page['content'] .= $form_bet->render();
        }

        if ($this->player->getInGame()) {
            $view = new \Core\Page\View([
                'title' => 'This is your night!'
            ]);
            $this->page['content'] = $view->render(ROOT_DIR . '/app/views/content.tpl.php');

            $form_play = new \App\Objects\Form\BlackJackPlay();
            $status_play = $form_play->process();

            $blackjack = new \App\Objects\BlackJack\BlackJack();
            $blackjack->setDeck($this->game_repo->loadAll());
            $blackjack->setDealerCards($this->game_repo->loadDealersCards());
            $blackjack->setPlayerCards($this->game_repo->loadPlayersCards());

            switch ($status_play) {
                case \App\Objects\Form\BlackJackPlay::STATUS_SUCCESS:
                    $player_input_play = $form_play->getInput();
                    if ($player_input_play['action'] == 'hit') {
                        $blackjack->hit();
                    }
                    if ($player_input_play['action'] == 'stand') {
                        $stand = $blackjack->stand();
                        if ($stand == $blackjack::OUTCOME_WIN) {
                            $this->page['content'] = 'You win!';
                        } elseif ($stand == $blackjack::OUTCOME_TIE) {
                            $this->page['content'] = 'Its a tie!';
                        } else {
                            $this->page['content'] = 'Try again!';
                        }
                    }
                    if ($player_input_play['action'] == 'play_again') {
                        $this->player = new \App\Objects\BlackJack\Player\Player([
                            'email' => \App\App::$session->getUser()->getEmail(),
                            'in_game' => 0,
                            'bet_size' => 0
                        ]);
                        $this->game_repo->deleteAll();
                        $this->player_repo->update($this->player);
                    }
                    break;
            }
            $blackjack->play();

            $cards = new \Core\Page\View([
                'title' => 'Blackjack',
                'dealer' => $blackjack->getDealersCards(),
                'your' => $blackjack->getPlayerCards()
            ]);

            $this->page['content'] .= $cards->render(ROOT_DIR . '/app/views/blackJack.tpl.php');

            $this->page['content'] .= $form_play->render();
        }
    }

}
