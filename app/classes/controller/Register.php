<?php

namespace App\Controller;

class Register extends Base {

    /** @var \App\Objects\Form\Register */
    protected $form;
    protected $input;
    protected $repo;

    public function __construct() {
        parent::__construct();
        
        $this->repo = new \App\User\Repository(\App\App::$db_conn);
        $this->form = new \App\Objects\Form\Register();
        $status = $this->form->process();
        $this->input = $this->form->getInput();

        switch ($status) {
            case \App\Objects\Form\Register::STATUS_SUCCESS:                
                $this->registerSuccess();

                $user = new \App\User\User([
                    'email' => $this->input['email'],
                    'balance' => rand(10, 50)
                ]);
                $this->repo->insert($user);
                
                header('Location: /login');
                exit();
                break;
            default:
                $this->page['content'] = $this->form->render();
        }
    }

    public function registerSuccess() {
        $user = new \Core\User\User([
            'email' => $this->input['email'],
            'password' => $this->input['password'],
            'full_name' => $this->input['full_name'],
            'age' => $this->input['age'],
            'gender' => $this->input['gender'],
            'orientation' => $this->input['orientation'],
            'account_type' => \Core\User\User::ACCOUNT_TYPE_USER,
            'photo' => $this->input['photo'],
            'is_active' => true
        ]);

        \App\App::$user_repo->insert($user);
    }

}
