<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model("gamemodel");
        $this -> load -> model("namesmodel");
        $this -> load -> model("usermodel");
        $this -> load -> library('session');
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function createNewGame(){ //Checked
        
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            
            echo json_encode(array("result" => "20")); // errorCode : Method should be POST

        }else if(!isset($_POST['maxPlayer']) || !isset($_POST['rounds']) || !isset($_POST['gname']) || count($_POST) != 3){

            echo json_encode(array("result" => "27")); // Post Parameters are invalid.

        }else if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else{

            $gname = $this -> input -> post('gname');
            $maxPlayer = intval($this->input->post('maxPlayer'));
            $rounds = intval($this->input->post('rounds'));
            $creatorNickname = $this->session->userdata('nickname');

            if($this -> gamemodel -> userIsParticipatingAnotherGame($creatorNickname)){

                echo json_encode(array("result" => "38")); // Player can not creat new game while he is playing another game!

            }else if($this -> gamemodel -> checkIfUserHasAnUnfinishedGame($creatorNickname)){

                echo json_encode(array("result" => "39")); // Each player could be owner of at most 1 game.

            }else{

                $result = $this -> gamemodel -> createNewGame($maxPlayer,$rounds,$creatorNickname, $gname);
                
                if($result){

                    echo json_encode(array("result" => "30")); // Game Created Successfully.

                }
                else {
                    
                    echo json_encode(array("result" => "41")); // There was an error in creating game

                }

            }
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getListOfGames(){//checked

        $data = array('gameList' => $this -> gamemodel ->getListOfGames());

        echo json_encode($data);

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function removeGame(){
        if($this->session->userdata('nickname') == NULL){

            echo json_encode(array("result" => "34")); // cookie missing , Session do not have valid values!

        }else{

            $nickname = $this->session->userdata('nickname');

            if(!$this -> gamemodel -> userHasAnActiveGame($nickname)){

                echo json_encode(array("result" => "42")); // User Do not have a Game

            }else{

                $gid    = $this -> gamemodel -> getUsersUnfinishedGameGid($nickname);
                $result = $this -> gamemodel -> removeGame($gid);

                if($result){

                    echo json_encode(array("result" => "30")); // Sucsses

                }else{

                    echo json_encode(array("result" => "43")); // There was an error in removing Game

                }

            }
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function addPlayerToGame(){//Checked
        
        if(!isset($_POST)){
            $this->load->view('index');//TODO: change to related view
            return;
        }
        
        $gid = $this->input->post('gid');
        $pnickname = $this->session->userdata('nickname');
        $result = NULL;
        if(!isset($pnickname)){
            echo "Please first attemp to signin before you can join a game.";
            header("Location: http://namefamily.ir/EsmFamil/CodeIgniter_2.2.0/index.php/login");
        }
        
        if(!isset($gid)){
            echo "Game doesn't exist";
        }
        
        else if(($this -> gamemodel -> userIsParticipatingAnotherGame($pnickname)) || 
            ($this -> gamemodel -> checkIfUserHasAnUnfinishedGame($pnickname))){
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
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function removePlayerFromGame(){//checked
        if(!isset($_POST)){
            $this->load->view('index');//TODO: change to related view
            return;
        }
        $gid = $this->input->post('gid');
        $pnickname = $this->session->userdata('nickname');
        $result = NULL;
        if(!isset($pnickname)){
            echo "Please first attemp to signin before you can join a game.";
            header("Location: http://namefamily.ir/EsmFamil/CodeIgniter_2.2.0/index.php/login");
        }
        if(!isset($gid)){
            echo "Game doesn't exist";
            header("Location: http://namefamily.ir/EsmFamil/CodeIgniter_2.2.0/index.php/loader/loadDashbord");
        }
        $result = $this -> gamemodel -> removePlayerFromGame($gid, $pnickname);
        if($result){
            echo "Left the game Successfully";
            header("Location: http://namefamily.ir/EsmFamil/CodeIgniter_2.2.0/index.php/loader/loadDashbord");
        }
        else {
            echo "There was an error leaving the game.";
            header("Location: http://namefamily.ir/EsmFamil/CodeIgniter_2.2.0/index.php/loader/loadDashbord");
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function createNewTurn($gid){

        if(!$this -> gamemodel -> isGameRoundsCompleted($gid)){

            $tid = $this -> gamemodel -> createNewTurn($gid);

            $users = $this -> gamemodel -> getGameMembers($gid);
            $userIds = $this -> usermodel -> getUserIds($users);

            $this -> namesmodel -> createNames($tid,$userIds);
                       
            return $tid;

        }

        echo "Game rounds Completed";

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function test(){

        $temp = $this -> gamemodel -> getUsersUnfinishedGameGid("erfan");

        echo $temp;

        //echo $this -> usermodel ->getUserIdByNickname("emadok");
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
}
?>