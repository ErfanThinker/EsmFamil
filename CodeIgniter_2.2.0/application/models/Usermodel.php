<?php
class Usermodel extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    function userExists($email){

        $this->db->select("mail");
        $this->db->from("esmFamil_user");
        $this->db->where("mail",$email);
        $count = $this->db->count_all_results();

        if($count == 0)
            return False;
        
        return True;
    }

    function addUser(){

    }
}