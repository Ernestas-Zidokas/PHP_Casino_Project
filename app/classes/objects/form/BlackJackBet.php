<?php

namespace App\Objects\Form;

class BlackJackBet extends \Core\Page\Objects\Form {

    public function __construct() {
        parent::__construct([
            'fields' => [                
                'bet' => [
                    'label' => 'bet',
                    'type' => 'number',
                    'placeholder' => '0',
                    'validate' => [
                        'validate_not_empty',
                        'validate_is_number',
                        'validate_min_bet',
                        'validate_user_balance'
                    ]
                ]
            ],
            'validate' => [],
            'buttons' => [
                'submit' => [
                    'text' => 'Bet!'
                ]
            ]
        ]);
    }

}
