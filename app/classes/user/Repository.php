<?php

namespace App\User;

class Repository {

    const REGISTER_SUCCESS = 1;
    const REGISTER_ERR_EXISTS = -1;

    public function __construct(\Core\Database\Connection $c) {
        $this->model = new \App\User\Model($c);
    }

    public function insert(\App\User\User $user) {
        return $this->model->insertIfNotExists(
                        $user->getData(), ['email']
        );
    }

    public function load($email) {
        $rows = $this->model->load([
            'email' => $email
        ]);

        foreach ($rows as $row) {
            return new \App\User\User($row);
        }
    }

    public function update(\App\User\User $user) {
        return $this->model->update($user->getData(), [
                    'email' => $user->getEmail()
        ]);
    }

    public function delete(\App\User\User $user) {
        return $this->model->delete([
                    'email' => $user->getEmail()
        ]);
    }

    public function deleteAll() {
        return $this->model->delete();
    }

    public function loadAll() {
        $rows = $this->model->load();
        $users = [];

        foreach ($rows as $row) {
            $users[] = new \App\User\User($row);
        }

        return $users;
    }

    public function exists($email) {
        return $this->model->exists([
            'email' => $email
        ]);
    }

}
