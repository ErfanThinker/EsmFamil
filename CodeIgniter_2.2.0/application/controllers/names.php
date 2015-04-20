<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Names extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this -> load -> model("namesmodel");
        $this->load->library('session');
    }

    

};