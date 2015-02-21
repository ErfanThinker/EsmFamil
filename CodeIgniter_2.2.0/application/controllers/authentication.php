<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller {

    public function __construct()
    {
        echo "alaki11";
        parent::__construct();
        $this -> load -> model("User");
    }
    
    public function registerUser(){
        
        if(empty($_POST)){
            echo "alaki";
            $this -> load -> view("login_form");
        }else{
            echo "Emad";
            $name = $this -> input -> post("name");
            $email = $this -> input -> post("email");
            //check email format
            $bdate = $this -> input -> post("date");
            $captcha = $this -> input -> post("captcha");
            $nickname = $this -> input -> post("nickname");
            //check email uniqeness
            $password = $this -> input -> post("pass");
            
            $checkUser = $this -> User -> userExists($email);
            $checkNickname = $this -> User -> nicknameExists($email);
            
            if(!$checkUser){
                if(!$checkNickname){
                    $registerResult = $this -> User -> addUser($name, $bdate, $email, $nickname, $password);
                    if($registerResult){
                        echo "user added sucessfully";
                    }else{
                        echo "error in adding User";
                    }
                }else{
                    echo "nickname Exists";
                }
            }else{
                echo "Email Exists";
            }
        }
        
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */