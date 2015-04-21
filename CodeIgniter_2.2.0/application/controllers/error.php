<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {

    public function error($text){
    	$data["text"] = $text;
		$this->load->view('templates/header');
        $this->load->view('pages/error', $data);
        $this->load->view('templates/footer');            

	}
}