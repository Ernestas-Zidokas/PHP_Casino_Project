<?php

namespace App\Objects\Form;

class Register extends \Core\Page\Objects\Form {

    public function __construct() {
        parent::__construct([
            'fields' => [
                'email' => [
                    'label' => 'Email',
                    'type' => 'text',
                    'placeholder' => 'email@gmail.com',
                    'validate' => [
                        'validate_not_empty',
                        'validate_email',
                        'validate_user_exists'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'type' => 'password',
                    'placeholder' => '********',
                    'validate' => [
                        'validate_not_empty',
                        'validate_more_8_chars'
                    ]
                ],
                'password_again' => [
                    'label' => 'Password again',
                    'type' => 'password',
                    'placeholder' => '********',
                    'validate' => [
                        'validate_not_empty',
                        'validate_more_8_chars'
                    ]
                ],
                'full_name' => [
                    'label' => 'Full Name',
                    'type' => 'text',
                    'placeholder' => 'Ernestas Zidokas',
                    'validate' => [
                        'validate_not_empty',
                        'validate_contains_space',
                        'validate_no_numbers'
                    ]
                ],
                'age' => [
                    'label' => 'Age',
                    'placeholder' => '26',
                    'type' => 'number',
                    'min' => 0,
                    'max' => 999,
                    'validate' => [
                        'validate_not_empty',
                        'validate_is_number',
                        'validate_age'
                    ]
                ],
                'gender' => [
                    'label' => 'Gender',
                    'type' => 'select',
                    'placeholder' => '',
                    'options' => \Core\User\User::getGenderOptions(),
                    'validate' => [
                        'validate_not_empty',
                        'validate_field_select'
                    ]
                ],
                'orientation' => [
                    'label' => 'Orientation',
                    'type' => 'select',
                    'placeholder' => '',
                    'options' => \Core\User\User::getOrientationOptions(),
                    'validate' => [
                        'validate_field_select'
                    ],
                ],
                'photo' => [
                    'label' => 'Photo',
                    'placeholder' => 'file',
                    'type' => 'file',
                    'not_required' => true,
                    'validate' => [
                        'validate_file'
                    ]
                ],
            ],
            'validate' => [
                'validate_password',
                'validate_form_file'
            ],
            'buttons' => [
                'submit' => [
                    'text' => 'Paduoti!'
                ]
            ]
        ]);
    }

}
