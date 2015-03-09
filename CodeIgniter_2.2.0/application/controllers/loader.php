<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loader extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function loadDashbord(){

        $this -> load -> view("home");
    }

    public function loadNewGame(){

        $this -> load -> view("new_game");
    }

    public function loadListOfGames(){

        $this -> load -> view("list_of_games");
    }

    public function loadErrorPage(){
        $this -> load -> view("error_page");
    }


}
?>