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



    function checkIfUserIsSomeoneElseGame($nickname){

        $this->db->select('*');
        $this->db->from("esmfamil_game_members");
        $this->db->where("pnickname",$nickname);
        $count = $this->db->count_all_results();
        if($count != 0){
            return TRUE;
        }else {
            return False;
        }
    }

    function checkIfUserHasGame($nickname){
        $this->db->select('*');
        $this->db->from("esmfamil_game");
        $this->db->where('creaternickname', $nickname);
        $this->db->where('isfinished', 0);
        $count = $this->db->count_all_results();
        if($count == 0){
            return False;
        }else{
            return TRUE; 
        }

    }

    

    function addPlayerToGame($gid, $pnickname){
        $data = array(
               'gid' => $gid,
               'pnickname' => $pnickname
            );



        //Check if game has capacity
        $this->db->select('*');
        $query = $this->db->get_where('esmfamil_game', array('gid' => $gid), 1);
        $row =  $query->result();
        if($query->num_rows() > 0){
          foreach($query->result() as $row){
            if(isset($row->maxnumofplayers)){
                $maxNum = $row->maxnumofplayers;
                echo $row->maxnumofplayers;
            } 
          }
        }
        //echo $row->maxnumofplayers;
        //$maxNum = $row->maxnumofplayers;
        


        $this->db->select();
        $this->db->from("esmfamil_game_members");
        $this->db->where("gid",$gid);
        $count = $this->db->count_all_results();


        if(($maxNum - 1)>$count){
            $this->db->insert("esmfamil_game_members", $data); 
            return TRUE;
        }else {
            return False;
        }
    }

    function ownsTheGame($nickname,$gid){
        $this->db->select('*');
        $this->db->from("esmfamil_game");
        $this->db->where('creaternickname', $nickname);
        $this->db->where('gid', $gid);
        $count = $this->db->count_all_results();
        if($count == 0){
            return False;
        }else{
            return TRUE; 
        }
    }


    function removeGame($gid){
        $data = array(
           'gid' => $gid
        );

        
        $this->db->delete('esmfamil_game_members', $data);
        $query = $this->db->delete('esmfamil_game', $data);
        return $query; 
    }

    function removePlayerFromGame($gid,$pnickname){
        $this->db->delete('esmfamil_game_members', array(
           'gid' => $gid,
           'pnickname' => $pnickname
        ));
        return $query; 
    }

    function getListOfGames(){
        return $this->db->get_where('esmfamil_game',array('isfinished' => 0));

    }
    function getListOfGamesUserCreatedAndFinished($creaternickname){
        return $this->db->get_where('esmfamil_game',array('isfinished' => 1,'creaternickname' => $creaternickname));
    }

    
};