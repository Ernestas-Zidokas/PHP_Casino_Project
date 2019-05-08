<?php

namespace App\Controller;

class Home extends Base {

    protected $view;

    public function __construct() {
        if (!\App\App::$session->isLoggedIn() === true) {
            header('Location: /login');
            exit();
        } else {
            header('Location: /dice');
            exit();
        }

        parent::__construct();
    }

}
