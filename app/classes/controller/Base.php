<?php

namespace App\Controller;

class Base extends \Core\Page\Controller {

    public function __construct() {
        parent::__construct();

        $this->page['stylesheets'][] = 'css/style.css';

        if (!\App\App::$session->isLoggedIn() === true) {
            $nav_view = new \App\View\Navigation([
                [
                    'link' => 'register',
                    'title' => 'Register'
                ],
                [
                    'link' => 'login',
                    'title' => 'Login'
                ]
            ]);
        } else {
            $nav_view = new \App\View\Navigation([
                [
                    'link' => 'cash-in',
                    'title' => 'Cash-in'
                ],
                [
                    'link' => 'dice',
                    'title' => 'Play Dice'
                ],
                [
                    'link' => 'slotMachine3x3',
                    'title' => 'Slot Machine 3x3'
                ],
                [
                    'link' => 'slotMachine5x3',
                    'title' => 'Slot Machine 5x3'
                ],
                [
                    'link' => 'blackjack',
                    'title' => 'BlackJack'
                ],
                [
                    'link' => 'logout',
                    'title' => 'Logout'
                ]
            ]);
        }
        $this->page['header'] = $nav_view->render();
    }

}
