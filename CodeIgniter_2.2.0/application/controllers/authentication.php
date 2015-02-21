<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model("usermodel");
    }
    
    public function registerUser(){
        
        if(empty($_POST)){
            $this -> load -> view("login_form");
        }else{
            $name = $this -> input -> post("name");
            $email = $this -> input -> post("email");
            //check email format
            $bday = $this -> input -> post("bday");
            $bmonth = $this -> input -> post("bmonth");
            $byear = $this -> input -> post("byear");
            $bdate = "$byear/"."$bmonth"."/$bday";
            $captcha = $this -> input -> post("captcha");
            $nickname = $this -> input -> post("nickname");
            //check email uniqeness
            $password = $this -> input -> post("password");
            $checkUser = $this -> usermodel -> userExists($email);
            $checkNickname = $this -> usermodel -> nicknameExists($nickname);
            
            if(!$checkUser){
                if(!$checkNickname){
                    $registerResult = $this -> usermodel -> addUser($name, $bdate, $email, $nickname, $password);
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