<?php
    class Users extends Controller {

        public function __construct(){
            $this->userModel = $this->model('User');
        }

        public function register(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // Proccess form
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];

                if (empty($data['name'])) {
                    $data['name_err'] = 'Please enter a name';
                }

                if (empty($data['email'])) {
                    $data['email_err'] = 'Please enter an email';
                } else {
                    if($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_err'] = 'Email already in system';
                    }
                }

                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter a password';
                } elseif (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be greater than 6 characters';
                }

                if (empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please enter a password';
                } elseif ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Confirm password must match password';
                }

                if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                    // Validated
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    if($this->userModel->registerUser($data)){
                        flash('register_success', 'You are registered and can log in');
                        redirect('users/login');
                    } else {
                        die('Something went wrong');
                    }

                } else {
                    // Error, stay on view
                    $this->view('users/register', $data);
                }

            } else {
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];

                $this->view('users/register', $data);
            }
        }

        public function login(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // Proccess form
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];

                if (empty($data['email'])) {
                    $data['email_err'] = 'Please enter an email';
                }
                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter a password';
                }
                if (empty($data['email_err']) && empty($data['password_err'])) {
                    // Validated
                    die('SUCCESS');
                } else {
                    $this->view('users/login', $data);
                }


            } else {
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];

                $this->view('users/login', $data);
            }
        }
    }