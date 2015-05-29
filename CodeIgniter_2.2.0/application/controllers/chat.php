<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model("chatmodel");
        $this -> load -> model("gamemodel");
        $this -> load -> model("usermodel");
        $this->load->library('session');

    }

    public function addMessage(){
    	
    	$nickname = $this-> session-> userdata('nickname');
    	
    	if( $_SERVER['REQUEST_METHOD'] != 'POST'){

    		echo json_encode(array('result' => '20')); // errorCode : Method should be POST

    	}else if($nickname == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else if(!isset($_POST['text'])){

    		echo json_encode(array("result" => "27")); // Post Parameters are invalid

    	}else {

    		$uid = $this -> usermodel -> getUserIdByNickname($nickname);
    		
    		$success = 0;
    		if( $this -> gamemodel -> checkActiveGame( $nickname ) ){
    			$gid = $this -> gamemodel -> getActiveGame( $nickname )[0]['gid'];
    			$success = $this -> chatmodel -> addMessage($gid, $uid, $_POST['text']);
    		}

    		if( !$success )
    			echo json_encode(array("result" => "61")); // add message Unsuccessful
    		else		
				echo json_encode(array("result" => "30")); // Success

    	}
    }

}
?>