<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	Class Usermanagement extends CI_Controller {

		public function __construct(){
	        parent::__construct();
	        $this -> load -> model("usermodel");
            $this->load->library('session');
	    }

	    public function editUser(){//Checked
	    	if(empty($_POST)){
	    	    
            	$this -> load -> view("login_form");//TODO: change to edit_form
            	
	        }else{
             
	            $name = $this -> input -> post("name");
	            $bday = $this -> input -> post("bday");
	            $bmonth = $this -> input -> post("bmonth");
	            $byear = $this -> input -> post("byear");
	            $bdate = "$byear/"."$bmonth"."/$bday";
                $nickname = $this->session->userdata('nickname');
	            $checkNickname = $this -> usermodel -> editProfile($nickname, $name, $bdate);
	            
	            if($checkNickname){
	                
	                echo "Editing user was a success";
                    
	            }else{
	                
	                echo "Edit user failed!";
                    
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