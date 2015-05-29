<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model("newsmodel");
        $this->load->library('session');
    }


    public function getNews(){
        $nickname = $this-> session-> userdata('nickname');
    	if($this-> session-> userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else {

	    	$data = $model = $this -> newsmodel -> getNews($nickname);
	    	echo json_encode($data);
	    }
    }

    public function setNews(){
    	$nickname = $this-> session-> userdata('nickname');
    	if( $_SERVER['REQUEST_METHOD'] != 'POST'){

    		echo json_encode(array('result' => '20')); // errorCode : Method should be POST

    	}else if($nickname == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else if($this -> usermodel -> isAdmin($nickname) == 0 ){

			echo json_encode(array("result" => "60")); // You are not admin

        }else if(!isset($_POST['title']) || !isset($_POST['body']) ){

    		echo json_encode(array("result" => "27")); // Post Parameters are invalid

    	}else {

    		$success = $this-> newsmodel -> setNews($_POST['title'], $_POST['body'], $nickname);
    		
    		if(!$success)
    		
    			echo json_encode(array("result" => "59")); // Add news Unsuccessful
    		else		
				echo json_encode(array("result" => "30")); // Success

    	}
    }
    
}
?>