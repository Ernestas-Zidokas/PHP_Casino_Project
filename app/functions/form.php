<?php

require_once '../bootloader.php';

function validate_user_exists($field_input, &$field, &$safe_input) {

    if (!\App\App::$user_repo->exists($field_input)) {
        return true;
    } else {
        $field['error_msg'] = 'Tokiu emailu useris jau yra!';
    }
}

function validate_string_lenght_10_chars($field_input, &$field, &$safe_input) {
    if (strlen($field_input) > 10) {
        return true;
    } else {
        $field['error_msg'] = strtr('Jobans/a tu buhurs/gazele, '
                . 'nes @field privalo buti ilgesnis nei 10 simboliu', ['@field' => $field['label']
        ]);
    }
}

function validate_string_lenght_60_chars($field_input, &$field, &$safe_input) {
    if (strlen($field_input) < 60) {
        return true;
    } else {
        $field['error_msg'] = strtr('Jobans/a tu buhurs/gazele, '
                . 'nes @field privalo buti trumpesnis nei 60 simboliu', ['@field' => $field['label']
        ]);
    }
}

function validate_login(&$safe_input, &$form) {
    $status = \App\App::$session->login($safe_input['email'], $safe_input['password']);
    switch ($status) {
        case Core\User\Session::LOGIN_SUCCESS:
            return true;
    }

    $form['error_msg'] = 'Blogas Email/Password!';
}

function validate_password(&$safe_input, &$form) {
    if ($safe_input['password'] === $safe_input['password_again']) {
        return true;
    } else {
        $form['error_msg'] = 'Jobans/a tu buhurs/gazele passwordai nesutampa!';
    }
}

function validate_form_file(&$safe_input, &$form) {
    if ($safe_input['photo']) {
        $file_saved_url = save_file($safe_input['photo']);
        if ($file_saved_url) {
            $safe_input['photo'] = 'uploads/' . $file_saved_url;
            return true;
        } else {
            $form['error_msg'] = 'Jobans/a tu buhurs/gazele nes failas supistas!';
        }

        return false;
    }

    return true;
}

function save_file($file, $dir = 'uploads', $allowed_types = ['image/png', 'image/jpeg', 'image/gif']) {
    if ($file['error'] == 0 && in_array($file['type'], $allowed_types)) {
        $target_file_name = microtime() . '-' . strtolower($file['name']);
        $target_path = $dir . '/' . $target_file_name;
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            return $target_file_name;
        }
    }
    return false;
}

function validate_logout(&$safe_input, &$form) {
    if (\App\App::$session->isLoggedIn() === true) {
        \App\App::$session->logout();

        return true;
    }
}

function validate_positive_number($field_input, &$field, &$safe_input) {
    if ($safe_input['balance'] > 0) {
        return true;
    } else {
        $field['error_msg'] = strtr('Jobans/a tu buhurs/gazele, '
                . 'nes @field negali but mazesnis uz 0!', ['@field' => $field['label']
        ]);
    }
}

function validate_input_more_than_5($field_input, &$field, &$safe_input) {
    if ($safe_input['balance'] >= 5) {
        return true;
    } else {
        $field['error_msg'] = strtr('Jobans/a tu buhurs/gazele, '
                . 'nes @field negali but mazesnis uz 5!', ['@field' => $field['label']
        ]);
    }
}

function validate_user_balance($field_input, &$field, &$safe_input) {
    $repo = new \App\User\Repository(\App\App::$db_conn);
    $email = $repo->load(\App\App::$session->getUser()->getEmail());

    if ($email) {
        if ($email->getBalance() >= $safe_input['bet']) {
            return true;
        } else {
            $field['error_msg'] = 'Jobans/a tu buhurs/gazele nes tau truksta pinigu!';
        }
    } else {
        $field['error_msg'] = 'Neisidejai pinigu!';
    }
}

function validate_user_balance_slot3x3(&$safe_input, &$form) {
    $repo = new \App\User\Repository(\App\App::$db_conn);
    $email = $repo->load(\App\App::$session->getUser()->getEmail());

    if ($email) {
        if ($email->getBalance() >= 2) {
            return true;
        } else {
            $form['error_msg'] = 'Jobans/a tu buhurs/gazele nes tau truksta pinigu!';
        }
    } else {
        $form['error_msg'] = 'Neisidejai pinigu!';
    }
}

function validate_user_balance_slot5x3(&$safe_input, &$form) {
    $repo = new \App\User\Repository(\App\App::$db_conn);
    $email = $repo->load(\App\App::$session->getUser()->getEmail());

    if ($email) {
        if ($email->getBalance() >= 1) {
            return true;
        } else {
            $form['error_msg'] = 'Jobans/a tu buhurs/gazele nes tau truksta pinigu!';
        }
    } else {
        $form['error_msg'] = 'Neisidejai pinigu!';
    }
}

function validate_min_bet($field_input, &$field, &$safe_input) {
    if ($safe_input['bet'] >= 1) {
        return true;
    } else {
        $field['error_msg'] = 'Jobans/a tu buhurs/gazele nes minimali suma 1$!';
    }
}

function validate_radio_not_empty($field_input, &$field, $safe_input) {
    if (strlen($field_input) == 0) {
        $field['error_msg'] = 'Privalai pasirinkti Dice!';
    } else {
        return true;
    }
}
