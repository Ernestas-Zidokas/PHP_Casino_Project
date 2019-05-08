<?php

namespace App\Controller;

class Logout extends Base {

    /** @var \App\Objects\Form\Logout */
    protected $form;

    public function __construct() {
        parent::__construct();

        $this->form = new \App\Objects\Form\Logout();

        switch ($this->form->process()) {
            case \App\Objects\Form\Logout::STATUS_SUCCESS:
                $this->redirect();
                break;
            default:
                $this->page['content'] = $this->form->render();
        }
    }

    public function redirect() {
        if (!\App\App::$session->isLoggedIn() === true) {
            header('Location: login');
            exit();
        }
    }

}
