<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller {
    //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function __construct()
    {
        parent::__construct();
        $this -> load -> model("usermodel");
        $this -> load -> model('gamemodel');
        $this -> load -> library("email");
        $this -> load -> library('session');
        $this -> load -> helper('file');

        $emailConfig = $this-> config -> load("email");
    }
    //
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function registerUser(){
        
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            
            echo json_encode(array("result" => "20")); // errorCode : Method should be POST

        }else if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['bday'])
                    || !isset($_POST['bmonth']) || !isset($_POST['byear']) || !isset($_POST['nickname'])
                    || !isset($_POST['password']) || count($_POST) != 7 ){

            echo json_encode(array("result" => "27")); // Post Parameters are invalid.

        }else{
            
            $name   = $this -> input -> post("name");
            $email  = $this -> input -> post("email");
            
            
            $valid = filter_var($email, FILTER_VALIDATE_EMAIL);
            if(!$valid){

                echo json_encode(array("result" => "21"));// errorCode : Email syntax is invalid

            }
            else{
                
                
                $bday   = $this -> input -> post("bday");
                $bmonth = $this -> input -> post("bmonth");
                $byear  = $this -> input -> post("byear");
                $bdate  = "$byear/"."$bmonth"."/$bday";
                
                
                //$captcha = $this -> input -> post("captcha");
                $nickname = $this -> input -> post("nickname");
                $password = $this -> input -> post("password");
                
                
                $checkUser     = $this -> usermodel -> userExists($email);
                $checkNickname = $this -> usermodel -> nicknameExists($nickname);
                
                if($checkUser == 0){

                    if(!$checkNickname){

                        $registerResult = $this -> usermodel -> addUser($name, $bdate, $email, $nickname, $password);

                        if($registerResult){                        
                            
                            $hash     = $this -> generateValidationToken();
                            $saveHash = $this -> saveVerificationLink($email, $hash);

                            $activationLink = "http://www.namefamily.ir/EsmFamil/CodeIgniter_2.2.0/index.php/authentication/verifyUser?email=".$email."&hash="
                            .$hash;

                            $activationMail = read_file("./application/views/pages/mail/activationMail.html");

                            $message = vsprintf( $activationMail, array($email,$password,$activationLink) ); 

                            $subject = "EsmFamil - Confirm Your Registration";
                            $senderName = "EsmFamil";
                            $from = "abdoli.mh@gmail.com";
                            $to = $email;

                            $emailResult = $this -> sendEmail($from, $to, $message, $subject, $senderName);

                            if($emailResult){
                                echo json_encode(array("result" => "30")); // Email sent successfuly

                            }else{
                                echo json_encode(array("result" => "23"));  // Email sending problem but user added successfully

                            }
                        }else{
                            echo json_encode(array("result" => "24")); // error in adding User

                        }
                    }else{
                        echo json_encode(array("result" => "25")); // nickname Exists

                    }
                }else{
                    echo json_encode(array("result" => "26")); // Email Exists

                }
            }
        }
    }
    //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function signOut() {

		// Removing session data
        if($this->session->userdata('nickname') != NULL){

            $nickname = $this->session->userdata('nickname');

            if($this -> gamemodel -> userHasAnActiveGame($nickname)){

                $gid    = $this -> gamemodel -> getUsersUnfinishedGameGid($nickname);
                $result = $this -> gamemodel -> removeGame($gid);

            }

            $array_items = array('nickname' => '');

            $this-> session ->unset_userdata($array_items);

            $this-> session -> sess_destroy();

            echo json_encode(array("result" => "30")); // Signout sucessfully
        }

	}
    //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function signIn(){

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            echo json_encode(array("result" => "20")); // Method should be POST

        }else if(!isset($_POST['nickname']) || !isset($_POST['password']) || count($_POST) != 2 ){

            echo json_encode(array("result" => "27")); // Post Parameters are invalid.

        }else{

            $nickname = $this -> input -> post("nickname");
            $password = $this -> input -> post("password");

            $checkPass   = $this -> usermodel -> checkPassword($nickname,$password);
            $checkActive = $this -> usermodel -> checkVerified($nickname);
            
            if(!$checkPass){

                echo json_encode(array("result" => "28")); // invalid nickname or password

            }else if(!$checkActive){

                echo json_encode(array("result" => "29")); // email is not active
                
            }else{

            	$name = $this -> usermodel -> getName($nickname);	
                session_start(); //we need to start session in order to access it through CI                   
                $sess_array = array(
                    'nickname' => $nickname
                    );
                // Add user data in session
                $this->session->set_userdata('nickname', $nickname);

                $isAdmin = $this -> usermodel -> isAdmin($nickname);
                echo json_encode(array("result" => "30", "name" => $name, "isAdmin" => $isAdmin)); // Login Sucessfully

            }
        }

    }
    //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function test(){
        
        $name = $this -> usermodel -> getName("erfan");	       

        echo json_encode(array("result" => "30", "name" => $name)); // Login Sucessfully

    }
    //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function verifyUser(){

        $url = parse_url($_SERVER['REQUEST_URI']);
        parse_str($url['query'], $params);
        
        $email  = $params["email"];
        $hash   = $params["hash"];
        $validationResult = $this -> usermodel -> confirmValidation($hash,$email);
        
        if($validationResult == TRUE){
            echo "Your account verfied secessfully.";
        }else{
            echo "There was a problem in verfing your email, please try again.";
        }
    }
    //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    private function sendEmail($from,$to,$msg,$subject,$senderName){
        
        $this-> email ->from($from, $senderName);
        $this-> email ->to($to);
        $this-> email ->subject($subject);
        $this-> email ->message($msg);  
        $emailResult = $this-> email ->send();
        
        return $emailResult;

    }
    //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    private function generateValidationToken(){
        
        return md5( rand(0,1000) );//Generate random 32 character hash and assign it to a local variable.
        // Example output: f4552671f8909587cf485ea990207f3b
        
    }
    //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    private function saveVerificationLink($email,$hash){

        $result = $this -> usermodel -> addVerificationToken($hash,$email);
        
        if($result == TRUE){
            return $hash;
        }else{
            return false;
        }
    }
    //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    /*private function createCaptcha(){
        
        $this->load->helper('captcha');
        
        $this ->usermodel -> removeOldCaptcha();
        
        $vals = array(
            'img_path'  => './css/captcha/',
            'img_url'   => 'localhost/EsmFamil/CodeIgniter_2.2.0/css/captcha/'
            );

        $cap = create_captcha($vals);
        $cid = $this -> usermodel -> addNewCaptcha($cap['time'],$this -> input -> ip_address() , $cap['word']);

        //echo json_encode($data);
    }*/
    //
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    
}
?>
