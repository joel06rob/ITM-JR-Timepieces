<?php

    class Auth {

        private $user;

        public function __construct($conn)
        {
            $this->user = new User($conn);
        }

        //Login User:
        //Check if user exists, if true check if users password is correct.
        //Create a new user session and return true.
        public function loginUser($email, $password){
            
            //Email
            $user_login = $this->user->getUsersByEmail($email);

            if(!$user_login){
                return false;
            }

            //Password
            if(!password_verify($password, $user_login['Password'])){
                return false;
            }

            //Generate new session ID - Prevent session hijacking
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user_login['ID'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_fname'] = $user_login['Fname'];
            $_SESSION['user_sname'] = $user_login['Sname'];
            $_SESSION['user_type'] = $user_login['UserType'];

            return true;
        }

        public function logoutUser(){
            session_destroy();
        }


        //Check User:
        //Check that the user session variable for user id has a value - Used in various pages to check if the user is logged in.
        public function checkUser(){
            return isset($_SESSION['user_id']);
        }

        public function checkAdmin(){
            if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === "Admin"){
                return true;
            }
        }

        public function registerUser(){
            
        }


    }


?>