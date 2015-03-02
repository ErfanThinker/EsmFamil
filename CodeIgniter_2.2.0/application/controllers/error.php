<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {

    public function error($text){
    	$this -> load -> view('error-page.php', $text);
	}
}