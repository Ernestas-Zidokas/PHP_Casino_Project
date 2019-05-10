<?php

namespace App\Objects\BlackJack\Game;

class Model extends \Core\Database\Model {

    public function __construct(\Core\Database\Connection $conn) {
        parent::__construct($conn, 'deck', [
            [
                'name' => 'id',
                'type' => self::NUMBER_MED,
                'flags' => [self::FLAG_NOT_NULL, self::FLAG_AUTO_INCREMENT, self::FLAG_PRIMARY]
            ],
            [
                'name' => 'suit',
                'type' => self::TEXT_SHORT,
                'flags' => [self::FLAG_NOT_NULL]
            ],
            [
                'name' => 'number',
                'type' => self::NUMBER_SHORT,
                'flags' => [self::FLAG_NOT_NULL]
            ],
            [
                'name' => 'value',
                'type' => self::NUMBER_SHORT,
                'flags' => [self::FLAG_NOT_NULL]
            ],
            [
                'name' => 'owner',
                'type' => self::TEXT_SHORT
            ],
        ]);
    }

}
