<?php

namespace App\User;

class Model extends \Core\Database\Model {

    public function __construct(\Core\Database\Connection $conn) {
        parent::__construct($conn, 'balance', [
            [
                'name' => 'email',
                'type' => self::TEXT_SHORT,
                'flags' => [self::FLAG_NOT_NULL, self::FLAG_PRIMARY]
            ],
            [
                'name' => 'balance',
                'type' => self::NUMBER_MED
            ]
        ]);
    }

}
