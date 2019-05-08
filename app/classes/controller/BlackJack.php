<?php

namespace App\Controller;

class BlackJack extends Base {

    /** @var \App\Objects\Form\BlackJack */
    protected $form;

    public function __construct() {
        if (!\App\App::$session->isLoggedIn() === true) {
            header('Location: /home');
            exit();
        }

        parent::__construct();

        $this->form = new \App\Objects\Form\BlackJack();

        $view = new \Core\Page\View([
            'title' => 'Choose your destiny'
        ]);
        $this->page['content'] = $view->render(ROOT_DIR . '/app/views/content.tpl.php');
        $deck = new \App\Objects\BlackJack\Deck();
        $blackjack = new \App\Objects\BlackJack\BlackJack($deck);
        
        switch ($this->form->process()) {
            case \App\Objects\Form\BlackJack::STATUS_SUCCESS:

                break;
        }

        $this->page['content'] .= $this->form->render();
    }

}
