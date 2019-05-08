<?php

namespace App\Objects\SlotMachine;

class SlotMachine3x3 extends SlotMachine {

    public function __construct() {
        parent::__construct(2, 3, 3, 3, 0.5);
    }

}
