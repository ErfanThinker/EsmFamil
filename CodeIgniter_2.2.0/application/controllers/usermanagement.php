<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	Class Usermanagement extends CI_Controller {

		public function __construct(){
	        parent::__construct();
	        $this -> load -> model("usermodel");
            $this->load->library('session');
	    }

	    public function editUser(){//Checked
	    	if(!isset($_POST)){
	    	    
            	echo json_encode(array("result" => "20")); // errorCode : Method should be POST
            	
	        }else if(!isset($_POST['name']) || count($_POST) != 1 ){

            	echo json_encode(array("result" => "27")); // Post Parameters are invalid.

        	}else if(NULL  == ($this->session->userdata('nickname'))){
                echo json_encode(array("result" => "34")); // cookie missing!
            }else {
	            $name = $this -> input -> post("name");
                $nickname = $this->session->userdata('nickname');

	            $checkNickname = $this -> usermodel -> editProfile($nickname, $name, $bdate);
	            
	            if($checkNickname){
	                
	                echo json_encode(array("result" => "32")); // Edit was a success
                    
	            }else{
	                
	                echo json_encode(array("result" => "33")); // Edit was a Failure
                    
	            }
	        }
        }

	    public function changePassword(){//Checked
	    	if(empty($_POST)){
	    	    
            	$this -> load -> view("login_form");//TODO: change to change_password
            	
	        }else{
	            
	        	$nickname = $this->session->userdata('nickname');
	            $oldPassword = $this -> input -> post("oldPassword");
	            $newPassword = $this -> input -> post("newPassword");
	            $changePassResult = $this -> usermodel -> changePassword($nickname, $oldPassword, $newPassword);
	            
	            if($changePassResult){
	                echo "Change password was a success";
	            }else{
	                echo "Change password failed!";
	            }
	        }
	    }
	    
	}