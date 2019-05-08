<?php

namespace App\Objects\Form;

class CashIn extends \Core\Page\Objects\Form {

    public function __construct() {
        parent::__construct([
            'fields' => [
                'balance' => [
                    'label' => 'Inesti pinigu',
                    'type' => 'number',
                    'placeholder' => '',
                    'validate' => [
                        'validate_not_empty',
                        'validate_is_number',
                        'validate_positive_number',
                        'validate_input_more_than_5'
                    ]
                ],
            ],
            'buttons' => [
                'submit' => [
                    'text' => 'Inesti!'
                ]
            ]
        ]);
    }

}
