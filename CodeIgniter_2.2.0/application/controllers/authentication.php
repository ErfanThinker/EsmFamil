<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model("usermodel");
        $this -> load -> library("email");
        $emailConfig = $this->config->load('email');
        ;
    }
    
    public function sendEmail($from,$to,$msg,$subject,$senderName){
        
        $this->load->library('email');
        $this->email->initialize(array(
          'protocol' => 'smtp',
          'smtp_host' => 'in-v3.mailjet.com',
          'smtp_user' => '9b3aab1bb2696a707c2de45d963b4434',
          'smtp_pass' => '4303ef1ebff24bf7955280bcea271426',
          'smtp_timeout' => '7',
          'smtp_port' => 587,
          'crlf' => "\r\n",
          'newline' => "\r\n"
        ));
        
        $this->email->from($from, $senderName);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($msg);  
        $emailResult = $this->email->send();
        
        return $emailResult;
    }
    
    public function registerUser(){
        
        if(empty($_POST)){
            $this -> load -> view("login_form");
        }else{
            $name = $this -> input -> post("name");
            $email = $this -> input -> post("email");
            //check email format $valid = filter_var($Email, FILTER_VALIDATE_EMAIL);
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
                        
                        $hash = $this -> generateValidationToken($email,$nickname);
                        $saveHash = $this -> saveVerificationLink($email, $hash);
                        
                        $from = "abdoli.mh@gmail.com";
                        $to = $email;
                        $message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: '.$email.'
Password: '.$password.'
------------------------
 
Please click this link to activate your account:
http://localhost/EsmFamil/CodeIgniter_2.2.0/index.php/authentication/verifyUser?email='.$email.'&hash='.$hash.'
 
'; // Our message above including the link
                        //move email message to an html file and load it here;
                        $subject = "EsmFamil - Confirm Your Registration";
                        $senderName = "EsmFamil";
                        $emailResult = $this -> sendEmail($from, $to, $message, $subject, $senderName);
                        if($emailResult){
                            echo "Email sent successfuly";
                        }else{
                            echo "Email sending problem but user added successfully";
                        }
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

    public function generateValidationToken(){
        //return  crypt(round(microtime(true) * 1000)."".$username.rand());
        return md5( rand(0,1000) );//Generate random 32 character hash and assign it to a local variable.
        // Example output: f4552671f8909587cf485ea990207f3b
    }

    public function saveVerificationLink($email,$hash){
        $result = $this -> usermodel -> addVerificationToken($hash,$email);
        
        if($result == TRUE){
            return $hash;
        }else{
            return false;
        }
    }
    
    public function verifyUser(){
        $url = parse_url($_SERVER['REQUEST_URI']);
        parse_str($url['query'], $params);
        
        $email = $params["email"];
        $hash = $params["hash"];
        $validationResult = $this -> usermodel -> confirmValidation($hash,$email);
        
        if($validationResult == TRUE){
            echo "Your Email Activated";
        }else{
            echo "There was a problem in activation please try again";
        }
    }
    
    public function createCaptcha(){
        $this->load->helper('captcha');
        
        $this ->usermodel -> removeOldCaptcha();
        
        //it should work properly $this->deleteExpiredImages();
        
        // font missed
        $vals = array(  'img_path' => '../../css/captcha',
                'img_url' => 'localhost/Esmfamil/CodeIgniter_2.2.0/css/captcha/',
                'captcha_word_length' => 5,
                'font_path' => '',
                'img_width' => '120',
                'expiration' => 7200);

        $cap = create_captcha($vals);
        $this -> usermodel -> addNewCaptcha($cap['time'],$this -> input -> ip_address() , $cap['word']);

        echo json_encode($data);
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */