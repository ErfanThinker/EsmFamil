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
        $result = NULL;
        if(!isset($creatorNickname)){
            echo "Please first attemp to signin before you can create a game.";
            header("Location: http://localhost/EsmFamil/CodeIgniter_2.2.0/index.php/login");
        }
        
        if(!isset($gname)){
            echo "Game must have a name";

        }else if(!isset($maxPlayer)){
            echo "Game must have maximum number of players";
        }
        
        else if(!isset($rounds)){
            echo "Game must have number of rounds";
        }

        else if(($this -> gamemodel -> checkIfUserIsSomeoneElseGame($creatorNickname)) || 
            ($this -> gamemodel -> checkIfUserHasGame($creatorNickname))){
            echo "You should leave your current game in order to create a new one!";
        }
        
        else $result = $this -> gamemodel -> createNewGame($gname,$maxPlayer,$rounds,$creatorNickname);
        
        if($result)
            echo "Game Created Successfully";
        else {
            echo "There was an error in creating game.";
        }
    }

    public function addPlayerToGame(){//Checked
        
        if(!isset($_POST)){
            $this->load->view('index');
            return;
        }
        
        $gid = $this->input->post('gid');
        $pnickname = $this->session->userdata('nickname');
        $result = NULL;
        if(!isset($pnickname)){
            echo "Please first attemp to signin before you can join a game.";
            header("Location: http://localhost/EsmFamil/CodeIgniter_2.2.0/index.php/login");
        }
        
        if(!isset($gid)){
            echo "Game doesn't exist";
        }
        
        else if(($this -> gamemodel -> checkIfUserIsSomeoneElseGame($pnickname)) || 
            ($this -> gamemodel -> checkIfUserHasGame($pnickname))){
            echo "You should leave your current game in order to join another one!";
        }
        
        else $result = $this -> gamemodel -> addPlayerToGame($gid, $pnickname);
        
        if($result){
            echo "Game Joined Successfully";
        }
        else {
            echo "There was an error joining the game.";
        }
    }

    public function removePlayerFromGame(){
        if(!isset($_POST)){
            $this->load->view('index');
            return;
        }
        $gid = $this->input->post('gid');
        $pnickname = $this->session->userdata('nickname');
        $result = NULL;
        if(!isset($pnickname)){
            echo "Please first attemp to signin before you can join a game.";
            header("Location: http://localhost/EsmFamil/CodeIgniter_2.2.0/index.php/login");
        }
        if(!isset($gid)){
            echo "Game doesn't exist";
        }
        $result = $this -> gamemodel -> removePlayerFromGame($gid, $pnickname);
        if($result){
            echo "Left the game Successfully";
        }
        else {
            echo "There was an error leaving the game.";
        }
    }

    public function removeGame(){//checked
        if(!isset($_POST)){
            $this->load->view('index');
            return;
        }
        $gid = $this->input->post('gid');
        $pnickname = $this->session->userdata('nickname');
        $result = NULL;
        if(!isset($pnickname)){
            echo "Error: You are not signed in.";
            header("Location: http://localhost/EsmFamil/CodeIgniter_2.2.0/index.php/login");
        }
        if(!isset($gid)){
            echo "Game doesn't exist";
        }
        if(!($this -> gamemodel -> ownsTheGame($pnickname, $gid))){
            echo "Error: Unauthorized access tried to remove a game";
        }
        $result = $this -> gamemodel -> removeGame($gid);
        if($result){
            echo "Removed the game Successfully";
        }
        else {
            echo "There was an error removing the game.";
        }
    }
}
?>