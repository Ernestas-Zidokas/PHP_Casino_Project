<?php

namespace App\Objects\Form;

class BlackJackPlay extends \Core\Page\Objects\Form {

    public function __construct() {
        parent::__construct([
            'fields' => [],
            'validate' => [],
            'buttons' => [
                'hit' => [
                    'text' => 'Hit!'
                ],
                'stand' => [
                    'text' => 'Stand!'
                ],
                'play_again' => [
                    'text' => 'Play again!'
                ]
            ]
        ]);
    }

}
