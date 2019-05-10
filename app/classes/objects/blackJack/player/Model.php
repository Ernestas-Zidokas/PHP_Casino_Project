<?php

namespace App\Objects\BlackJack\Player;

class Model extends \Core\Database\Model {

    public function __construct(\Core\Database\Connection $conn) {
        parent::__construct($conn, 'player', [
            [
                'name' => 'email',
                'type' => self::TEXT_SHORT,
                'flags' => [self::FLAG_NOT_NULL, self::FLAG_PRIMARY]
            ],
            [
                'name' => 'in_game',
                'type' => self::NUMBER_SHORT
            ],
            [
                'name' => 'bet_size',
                'type' => self::NUMBER_LONG
            ]
        ]);
    }

}
