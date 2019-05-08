<?php

namespace App\Objects\Form;

class SlotMachine5x3 extends \Core\Page\Objects\Form {

    public function __construct() {
        parent::__construct([
            'fields' => [
            ],
            'buttons' => [
                'submit' => [
                    'text' => 'SPIN & WIN!'
                ]
            ],
            'validate' => [
                'validate_user_balance_slot5x3'
            ],
            'callbacks' => [
                'success' => [
                ],
                'fail' => []
            ]
        ]);
    }

}
