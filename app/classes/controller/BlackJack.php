<?php

namespace App\Controller;

class BlackJack extends Base {

    /** @var \App\Objects\Form\BlackJack */
    protected $player;
    protected $player_repo;
    protected $blackjack;
    protected $game_repo;
    protected $user_repo;
    protected $user;
    protected $balance;
    protected $form_bet;
    protected $form_play;
    protected $player_input_bet;
    protected $player_input_play;

    public function __construct() {
        if (!\App\App::$session->isLoggedIn() === true) {
            header('Location: /home');
            exit();
        }
        parent::__construct();

        $this->player_repo = new \App\Objects\BlackJack\Player\Repository(\App\App::$db_conn);
        $this->player = $this->player_repo->load(\App\App::$session->getUser()->getEmail());
        $this->game_repo = new \App\Objects\BlackJack\Game\Repository(\App\App::$db_conn);
        $this->user_repo = new \App\User\Repository(\App\App::$db_conn);
        $this->user = $this->user_repo->load(\App\App::$session->getUser()->getEmail());
        $this->balance = $this->user->getBalance();
        $this->form_bet = new \App\Objects\Form\BlackJackBet();
        $this->form_play = new \App\Objects\Form\BlackJackPlay();

        if (!$this->player) {
            $this->player = new \App\Objects\BlackJack\Player\Player([
                'email' => \App\App::$session->getUser()->getEmail(),
                'in_game' => 0,
                'bet_size' => 0
            ]);
            $this->player_repo->insert($this->player);
        }

        if (!$this->player->getInGame()) {
            $status_bet = $this->form_bet->process();

            $view = new \Core\Page\View([
                'title' => 'Place your bet'
            ]);
            $this->page['content'] = $view->render(ROOT_DIR . '/app/views/content.tpl.php');

            switch ($status_bet) {
                case \App\Objects\Form\BlackJackBet::STATUS_SUCCESS:
                    $this->player_input_bet = $this->form_bet->getInput();

                    $deck = new \App\Objects\BlackJack\Game\Deck();
                    $blackjack = new \App\Objects\BlackJack\BlackJack();
                    $blackjack->setDeck($deck->create());
                    $blackjack->save();

                    $this->player = new \App\Objects\BlackJack\Player\Player([
                        'email' => \App\App::$session->getUser()->getEmail(),
                        'in_game' => 1,
                        'bet_size' => $this->player_input_bet['bet']
                    ]);
                    $this->player_repo->update($this->player);
                    break;
            }

            $this->page['content'] .= $this->form_bet->render();
        }

        if ($this->player->getInGame()) {
            $view = new \Core\Page\View([
                'title' => 'This is your night!'
            ]);
            $this->page['content'] = $view->render(ROOT_DIR . '/app/views/content.tpl.php');
            $status_play = $this->form_play->process();

            $blackjack = new \App\Objects\BlackJack\BlackJack();
            $blackjack->setDeck($this->game_repo->loadAll());
            $blackjack->setDealerCards($this->game_repo->loadDealersCards());
            $blackjack->setPlayerCards($this->game_repo->loadPlayersCards());

            switch ($status_play) {
                case \App\Objects\Form\BlackJackPlay::STATUS_SUCCESS:
                    $player_input_play = $this->form_play->getInput();

                    if ($player_input_play['action'] == 'hit') {
                        $blackjack->hit();
                    }
                    if ($player_input_play['action'] == 'stand') {
                        $stand = $blackjack->stand();
                        if ($stand == $blackjack::OUTCOME_WIN) {
                            $view = new \Core\Page\View([
                                'status' => 'You won!',
                                'amount' => 'Win amount: ' . $this->winAmount()
                            ]);

                            $this->page['content'] .= $view->render(ROOT_DIR . '/app/views/blackJack.tpl.php');
                        } elseif ($stand == $blackjack::OUTCOME_TIE) {
                            $view = new \Core\Page\View([
                                'status' => 'Its a tie!',
                            ]);

                            $this->page['content'] .= $view->render(ROOT_DIR . '/app/views/blackJack.tpl.php');
                        } else {

                            $view = new \Core\Page\View([
                                'status' => 'Try again!',
                                'amount' => 'Lose amount: ' . $this->loseAmount()
                            ]);

                            $this->page['content'] .= $view->render(ROOT_DIR . '/app/views/blackJack.tpl.php');
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
                'player' => $blackjack->getPlayerCards()
            ]);

            $this->page['content'] .= $cards->render(ROOT_DIR . '/app/views/blackJack.tpl.php');

            $this->page['content'] .= $this->form_play->render();
        }
    }

    public function winAmount() {
        $balance = ($this->balance - $this->player->getBetSize()) + $this->player->getBetSize() * 2;

        $users_balance = new \App\User\User([
            'email' => \App\App::$session->getUser()->getEmail(),
            'balance' => $balance
        ]);

        $this->user_repo->update($users_balance);
        return $this->player->getBetSize() * 2;
    }

    public function loseAmount() {
        $balance = $this->balance - $this->player->getBetSize();

        $users_balance = new \App\User\User([
            'email' => \App\App::$session->getUser()->getEmail(),
            'balance' => $balance
        ]);

        $this->user_repo->update($users_balance);

        return $this->player->getBetSize();
    }

}
