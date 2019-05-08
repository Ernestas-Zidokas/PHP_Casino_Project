<?php

namespace App\Controller;

class Login extends Base {

    /** @var \App\Objects\Form\Login */
    protected $form;

    public function __construct() {
        if (\App\App::$session->isLoggedIn() === true) {
            header('Location: /home');
            exit();
        }
        
        parent::__construct();

        $this->form = new \App\Objects\Form\Login();

        switch ($this->form->process()) {
            case \App\Objects\Form\Login::STATUS_SUCCESS:
                    header('Location: /dice');
                    exit();
                break;
            default:
                $this->page['content'] = $this->form->render();
        }
    }

}
