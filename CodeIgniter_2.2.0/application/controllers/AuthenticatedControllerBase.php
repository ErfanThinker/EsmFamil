<?php 

class AuthenticatedControllerBase extends authentication {

	protected $signed_in_user_data;

	public function __construct(){
		$this->load->helper('url');
		$res_logged_in = $this->session->get_userdata("logged_in");
		if(! (isset($res_logged_in) && is_array($res_logged_in) && isset($res_logged_in['nickname'])) ){
			redirect('signin');
		}else{
			//$this->signed_in_user_data = $res_logged_in;
		}
	}

	public function signOut() {

		// Removing session data
		$sess_array = array(
			'nickname' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		echo "successfuly signed out";
		redirect('signin');
	}

	public function startNewGame($gname, $maxnumofplayers, $pass){
		if(empty($_POST)){
            $this -> load -> view("new_game");
        }else{
			$nickname = $this->session->userdata('nickname');
			$gname = $this -> input -> post("gname");
            $maxnumofplayers = $this -> input -> post("maxnumofplayers");
            $pass = $this -> input -> post("pass");
            addGame($gname, $maxnumofplayers, $pass, $nickname);
        	
        }
	}

	public function getListOfGames(){

		$data['games']= $this->user_model->getListOfGames();
		$this -> load -> view("list_of_games",$data);

		/* view
		<?php
		  if(isset($supplier)){
		      foreach ($supplier as $info){
		      echo'<option value="' . $info->userid . '">' . $info->company . ' - ' . $info->lastname . ', ' . $info->firstname . '</option>';
		    }
		  }
		  ?> */
	}
}