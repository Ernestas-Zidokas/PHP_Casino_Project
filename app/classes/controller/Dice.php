<?php

namespace App\Controller;

class Dice extends Base {

    /** @var \App\Objects\Form\Login */
    protected $form;

    public function __construct() {
        if (!\App\App::$session->isLoggedIn() === true) {
            header('Location: /home');
            exit();
        }

        parent::__construct();

        $this->form = new \App\Objects\Form\Dice();

        $view = new \Core\Page\View([
            'title' => 'Mesk kailiuką'
        ]);
        $this->page['content'] = $view->render(ROOT_DIR . '/app/views/content.tpl.php');

        switch ($this->form->process()) {
            case \App\Objects\Form\Dice::STATUS_SUCCESS:
                if ($this->bet()) {
                    $this->page['content'] = 'Tu laimejai!';
                } else {
                    $this->page['content'] = 'Bandyk dar kartą!';
                }
                break;
        }

        $this->page['content'] .= $this->form->render();
    }

    private function bet() {
        $repo = new \App\User\Repository(\App\App::$db_conn);
        $user = $repo->load(\App\App::$session->getUser()->getEmail());
        $balance = $user->getBalance();
        $safe_input = $this->form->getInput();
        $bet = $safe_input['bet'];
        $balance -= $bet;
        $success = false;

        if (rand(0, 5) == $safe_input['dice']) {
            $success = true;
            $balance += $bet * 2.5;
        }

        $users_balance = new \App\User\User([
            'email' => \App\App::$session->getUser()->getEmail(),
            'balance' => $balance
        ]);

        $repo->update($users_balance);

        return $success;
    }

}
