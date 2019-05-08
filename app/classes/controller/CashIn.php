<?php

namespace App\Controller;

class CashIn extends Base {

    /** @var \App\Objects\Form\CashIn */
    protected $form;
    protected $user;
    protected $repo;

    public function __construct() {
        if (!\App\App::$session->isLoggedIn() === true) {
            header('Location: /home');
            exit();
        }
        
        parent::__construct();
        
        $this->form = new \App\Objects\Form\CashIn();
        $this->repo = new \App\User\Repository(\App\App::$db_conn);
        $this->user = $this->repo->load(\App\App::$session->getUser()->getEmail());

        $content = [
            'title' => 'CASH-IN',
            'balance' => '-'
        ];

        switch ($this->form->process()) {
            case \App\Objects\Form\CashIn::STATUS_SUCCESS:
                $this->putInMoney();
                $this->page['message'] = 'Sekmingai inesei pinigu';
                break;
        }

        if ($this->user) {
            $content['balance'] = $this->user->getBalance();
        } else {
            $content['balance'] = 0;
        }
        
        $content['content'] = $this->form->render();
        
        $this->view = new \Core\Page\View($content);
        $this->page['content'] = $this->view->render(ROOT_DIR . '/app/views/cashIn.tpl.php');
    }

    public function putInMoney() {
        $safe_input = $this->form->getInput();

        if ($this->user) {
            $money = $this->user->getBalance();
            $this->user->setBalance($money + $safe_input['balance']);
            $this->repo->update($this->user);
        } else {
            $this->user = new \App\User\User([
                'email' => \App\App::$session->getUser()->getEmail(),
                'balance' => $safe_input['balance']
            ]);
            
            $this->repo->insert($this->user);
        }
    }

}
