<?php
class Gamemodel extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('array');
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function createNewGame($maxPlayer,$rounds,$creatorNickname, $gname){

        $data = array(
           'gname' => $gname,
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
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function userIsParticipatingAnotherGame($nickname){ // Checked

        $this->db->select('*');
        $this->db->from("esmfamil_game_members");
        $this->db->join('esmfamil_game','esmfamil_game.gid = esmfamil_game_members.gid');
        $this->db->where("pnickname",$nickname);
        $this->db->where("isfinished",'0');
        $count = $this->db->count_all_results();

        if($count != 0){

            return TRUE;

        }else {

            return False;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function checkIfUserHasAnUnfinishedGame($nickname){ // Checked

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
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getListOfGames(){

        $query = $this->db->get_where('esmfamil_game',array('isfinished' => 0));
        $result = array();
        if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row)
            {

                $temp = $this -> getGameMembers($row['gid']);
                $row['currentlyJoined'] = count($temp);

                array_push($result, $row);
                
            }
        }

        return $result;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getGameMembers($gid){ // Checked

        $this -> db -> select("pnickname");
        $this -> db -> from("esmfamil_game_members");
        $this -> db -> where("gid",$gid);
        $query = $this -> db -> get();

        return $query -> result_array();

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function userHasAnActiveGame($nickname){ // Checked

        $this -> db -> select('*');
        $this -> db -> from("esmfamil_game");
        $this -> db -> where("creaternickname",$nickname);
        $this -> db -> where("isfinished",0);
        $temp = $this -> db -> count_all_results();

        if($temp == 0){

            return 0;

        }else{

            return 1;

        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function removeGame($gid){
        
        $data = array(
           'gid' => $gid
        );

        $this -> db -> delete('esmfamil_game_members', $data);
        $query = $this->db->delete('esmfamil_game', $data);

        return $query; 
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getUsersUnfinishedGameGid($nickname){

        $this -> db -> select("gid");
        $this -> db -> from("esmfamil_game");
        $this -> db -> where("creaternickname",$nickname);
        $this -> db -> where("isfinished",0);
        $query  = $this -> db -> get();
        $result = $query -> result_array();
        
        if($query -> num_rows() > 0){
            $gid = $result[0]['gid'];
        }

        return $gid;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function addPlayerToGame($gid, $pnickname){
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
            } 
          }
        }

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
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function ownsTheGame($nickname,$gid){
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
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function removePlayerFromGame($gid,$pnickname){

        $this->db->delete('esmfamil_game_members', array(
           'gid' => $gid,
           'pnickname' => $pnickname
        ));

        return $query; 
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getListOfGamesUserCreatedAndFinished($creaternickname){

        $query = $this->db->get_where('esmfamil_game',array('isfinished' => 1,'creaternickname' => $creaternickname));
        $result = array();
        if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row)
            {
               array_push($result, $row);
            }
        }
        return $result;
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function isGameRoundsCompleted($gid){ // Checked

        if($this -> getNumberOfGameRoundsPlayed($gid) >= $this -> gameRoundNumber($gid)){
            return TRUE;
        }

        return False;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getNumberOfGameRoundsPlayed($gid){ // Checked

        $this -> db -> from("esmfamil_game_turns");
        $this -> db -> where("gid",$gid);
        $query = $this -> db -> count_all_results();

        return $query;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function gameRoundNumber($gid){ // Checked

        $this -> db -> select("rounds");
        $this -> db -> from("esmfamil_game");
        $this -> db -> where("gid",$gid);
        $query = $this -> db -> get();
        $row = $query->row();
        
        return $row->rounds;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function createNewTurn($gid){ // Checked

        $letter = $this -> randomLetter();


        $data = array(
           'letter' => $letter
        );

        $this->db->insert('esmfamil_turn', $data); 
        $tid = $this->db->insert_id();

        if($this -> gameExists($gid)){
            $data = array(
               'gid' => $gid ,
               'tid' => $tid
            );

            $this->db->insert('esmfamil_game_turns', $data);

            return $tid;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function randomLetter(){ // Checked

        $pool = "abcdefghijklmnopqrstuvwxyz";
        $rand = rand(0,25);

        return $pool[$rand];
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function gameExists($gid){ // Checked

        $this->db->where('gid', $gid);
        $this->db->from('esmfamil_game');
        
        if($this->db->count_all_results() == 0){
            return False;
        }

        return TRUE;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    
};