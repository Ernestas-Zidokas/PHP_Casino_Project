<?php

namespace App\Objects\Form;

class Dice extends \Core\Page\Objects\Form {

    public function __construct() {
        parent::__construct([
            'fields' => [
                'dice' => [
                    'type' => 'radio',
                    'options' => [
                        [
                            'label' => 'dice',
                            'type' => 'radio',
                            'value' => 1,
                            'img' => 'images/one.png',
                            'validate' => []
                        ],
                        [
                            'label' => 'dice',
                            'type' => 'radio',
                            'value' => 2,
                            'img' => 'images/two.png',
                            'validate' => []
                        ],
                        [
                            'label' => 'dice',
                            'type' => 'radio',
                            'value' => 3,
                            'img' => 'images/three.png',
                            'validate' => []
                        ],
                        [
                            'label' => 'dice',
                            'type' => 'radio',
                            'value' => 4,
                            'img' => 'images/four.png',
                            'validate' => []
                        ],
                        [
                            'label' => 'dice',
                            'type' => 'radio',
                            'value' => 5,
                            'img' => 'images/five.png',
                            'validate' => []
                        ],
                        [
                            'label' => 'dice',
                            'type' => 'radio',
                            'value' => 6,
                            'img' => 'images/six.png',
                            'validate' => []
                        ]
                    ],
                    'validate' => [
                        'validate_radio_not_empty'
                    ]
                ],
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
