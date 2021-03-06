<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	Class Usermanagement extends CI_Controller {

		public function __construct(){
	        parent::__construct();
	        $this -> load -> model("usermodel");
            $this -> load -> library('session');
	    }
	    //
	    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    //
	    public function editUser(){

	    	if(!isset($_POST)){
	    	    
            	echo json_encode(array("result" => "20")); // errorCode : Method should be POST
            	
	        }else if(!isset($_POST['name']) || count($_POST) != 1 ){

            	echo json_encode(array("result" => "27")); // Post Parameters are invalid.

        	}else if(NULL  == ($this->session->userdata('nickname'))){

                echo json_encode(array("result" => "34")); // cookie missing!

            }else {

	            $name = $this -> input -> post("name");
                $nickname = $this->session->userdata('nickname');

	            $checkNickname = $this -> usermodel -> editProfile($nickname, $name);
	            
	            if($checkNickname){
	                
	                echo json_encode(array("result" => "30")); // Edit was a success
                    
	            }else{
	                
	                echo json_encode(array("result" => "33")); // Edit was a Failure
                    
	            }
	        }
        }
        //
	    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    //
        public function changePassword(){

	    	if(!isset($_POST)){

            	echo json_encode(array("result" => "20")); // errorCode : Method should be POST

            }else if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword']) || count($_POST) != 2){

            	echo json_encode(array("result" => "27")); // Post Parameters are invalid.

	        }else{    

	        	$nickname = $this -> session -> userdata('nickname');
	            $oldPassword = $this -> input -> post("oldPassword");
	            $newPassword = $this -> input -> post("newPassword");

	        	if($this -> usermodel -> checkPassword($nickname, $oldPassword) ){

		            $changePassResult = $this -> usermodel -> changePassword($nickname, $oldPassword, $newPassword);
		            
		            if($changePassResult){

		                echo json_encode(array("result" => "30")); // ChangePassword was a success

		            }else{

						echo json_encode(array("result" => "36")); // ChangePassword was a Failure

		            }
		        }else{

		        	echo json_encode(array("result" => "37")); // Wrong oldPassword
		        	
		        }
	        }
	    }
	    //
	    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    //
	    
	}