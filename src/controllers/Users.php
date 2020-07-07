<?php
    class Users extends Controller {
        public function __construct(){

        }

        public function register(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Proccess form
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
                // Proccess form
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