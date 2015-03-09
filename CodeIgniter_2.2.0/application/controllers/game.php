<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model("gamemodel");
        $this->load->library('session');
    }
    
    public function createNewGame(){//Checked
        
        if(!isset($_POST)){
            $this->load->view('index');
            return;
        }
        
        $gname = $this->input->post('gname');
        $maxPlayer = intval($this->input->post('maxPlayer'));
        $rounds = intval($this->input->post('rounds'));
        $creatorNickname = $this->session->userdata('nickname');
        
        if(!isset($creatorNickname))
            echo "Please first attemp to signin so you can create a game.";
        
        if(!isset($gname)){
            echo "Game must have a name";
        }
        
        if(!isset($maxPlayer))
            echo "Game must have maximum number of players";
        
        if(!isset($rounds))
            echo "Game must have number of rounds";
        
        $result = $this -> gamemodel -> createNewGame($gname,$maxPlayer,$rounds,$creatorNickname);
        
        if($result)
            echo "Game Created Successfully";
        else {
            echo "There was an error in creating game.";
        }
    }
}
?>