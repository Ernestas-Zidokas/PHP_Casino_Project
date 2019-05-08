<?php

namespace App\Controller;

class SlotMachine3x3 extends Base {

    /** @var \App\Objects\Form\SlotMachine3x3 */
    protected $form;
    protected $slot3x3;
    protected $repo;
    protected $user_balance_table;

    public function __construct() {
        if (!\App\App::$session->isLoggedIn() === true) {
            header('Location: /home');
            exit();
        }

        parent::__construct();
        $this->slot3x3 = new \App\Objects\SlotMachine\SlotMachine3x3();
        $this->form = new \App\Objects\Form\SlotMachine3x3();
        $this->repo = new \App\User\Repository(\App\App::$db_conn);
        $this->user_balance_table = $this->repo->load(\App\App::$session->getUser()->getEmail());

        $this->slot3x3->Shuffle();

        $view = new \Core\Page\View([
            'state' => $this->slot3x3->getState()
        ]);
        $this->page['content'] = $view->render(ROOT_DIR . '/app/views/slotMachine3x3.tpl.php');

        switch ($this->form->process()) {
            case \App\Objects\Form\SlotMachine3x3::STATUS_SUCCESS:
                $users_balance = new \App\User\User([
                    'email' => \App\App::$session->getUser()->getEmail(),
                    'balance' => $this->user_balance_table->getBalance() + $this->slot3x3->Outcome()
                ]);

                if ($this->slot3x3->isWin()) {
                    $this->page['content'] .= 'Tu laimejai!';
                } else {
                    $this->page['content'] .= 'Bandyk dar kartą!';
                }

                $this->repo->update($users_balance);
                break;
        }
        if ($this->user_balance_table->getBalance() > 0) {
            $this->page['content'] .= $this->form->render();
        } else {
            $this->page['content'] .= 'Tau reikia isideti pinigu!';
        }
    }

}
