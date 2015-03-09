<?php
class Gamemodel extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    
    public function createNewGame($gname,$maxPlayer,$rounds,$creatorNickname){
        $data = array(
           'gname' => $gname ,
           'maxnumofplayers' => $maxPlayer ,
           'creaternickname' => $creatorNickname,
           'winnernickname' => '',
           'rounds' => $rounds,
           'isfinished' => 0,
           'pass' => ''
        );

        $query = $this->db->insert('esmfamil_game', $data);
        return $query; 
    }

    
};