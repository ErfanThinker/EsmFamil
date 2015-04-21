<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loader extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("gamemodel");
    }

    public function loadhome(){

        $this->load->view("home");
    }

    public function loadNewGame(){

        $this -> load -> view("new_game");
    }

    public function loadListOfGames(){
        $data["gameList"] = $this->gamemodel->getListOfGames();
        $this->load->view('templates/header');
        $this->load->view('pages/list_of_games', $data);
        $this->load->view('templates/footer');            

        //$this -> load -> view("pages/list_of_games");
    }
    
    public function loadGameList(){

	$this->load->view("gamelist");
    }
    public function loadErrorPage($text){
        
        $data["text"] = $text;
        $this->load->view('templates/header');
        $this->load->view('pages/error', $data);
        $this->load->view('templates/footer');  
        
    }


}
?>
