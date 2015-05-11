<?php
class Gamemodel extends CI_Model {

    public function __construct()
    {
        $this -> load -> model("usermodel");
        $this -> load -> model("namesmodel");

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
        $id = $this->db->insert_id();

        return $id; 

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
        $this->db->where("isfinished !=",'4');
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
        $this->db->where('isfinished !=', 4);
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
    public function removeGame($gid){ // Checked
        
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
    public function isUserParticipatingThisGame($nickname, $gid){

        $this -> db -> from("esmfamil_game_members");
        $this -> db -> where("gid",$gid);
        $this -> db -> where("pnickname",$nickname);
        $count = $this -> db -> count_all_results();

        if($count > 0){
            return 1;
        }else{
            return 0;
        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getUsersUnfinishedGameGid($nickname){ // Checked

        $this -> db -> select("gid");
        $this -> db -> from("esmfamil_game");
        $this -> db -> where("creaternickname",$nickname);
        $this -> db -> where("isfinished",0);
        $query  = $this -> db -> get();
        $result = $query -> result_array();

        $gid = 0;

        if($query -> num_rows() > 0){
            $gid = $result[0]['gid'];
        }

        return $gid;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function addPlayerToGame($gid, $pnickname){ // Checked
        
        $data = array(
               'gid' => $gid,
               'pnickname' => $pnickname
            );

        if($this -> gameHasFreeCapacity($gid)){

            $this -> db -> insert("esmfamil_game_members",$data);

            return 1;

        }else{

            return 0;

        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function gameHasFreeCapacity($gid){ // Checked

        $this -> db -> select('maxnumofplayers');
        $this -> db -> from("esmfamil_game");
        $this -> db -> where("gid",$gid);
        $query  = $this -> db -> get();

        if($query->num_rows() > 0){

            $result = $query->result_array();
            $maxNum = $result[0]['maxnumofplayers'];

        }else{
            return 0;
        }
        

        $this -> db -> select('*');
        $this -> db -> from("esmfamil_game_members");
        $this -> db -> where("gid",$gid);
        $count = $this->db->count_all_results();

        
        if($maxNum > $count){
            return 1;
        }else{
            return 0;
        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function ownsTheGame($nickname,$gid){ // Checked

        $this->db->select('*');
        $this->db->from("esmfamil_game");
        $this->db->where('creaternickname', $nickname);
        $this->db->where('gid', $gid);
        $count = $this->db->count_all_results();
        if($count == 0){
            return 0;
        }else{
            return 1; 
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function removePlayerFromGame($gid,$pnickname){ // Checked

        $this -> db -> delete('esmfamil_game_members', array(
           'gid' => $gid,
           'pnickname' => $pnickname
        ));

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
	public function checkActiveGame($nickname){ // Checked

        $this -> db -> select('*');
        $this -> db -> from("esmfamil_game");
        $this -> db -> join('esmfamil_game_members','esmfamil_game.gid = esmfamil_game_members.gid');
        $this -> db -> where("pnickname",$nickname);
        $this -> db -> where("isfinished !=",4);
        $count = $this->db->count_all_results();

        if($count == 0){
        	return False;
        }
        return TRUE;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //

    public function getActiveGame($nickname){ // Checked

        $this -> db -> select('*');
        $this -> db -> from("esmfamil_game");
        $this -> db -> join('esmfamil_game_members','esmfamil_game.gid = esmfamil_game_members.gid');
        $this -> db -> where("pnickname",$nickname);
        $this -> db -> where("isfinished !=",4);
        $query = $this -> db -> get();

        $result = $query -> result_array();
        $result[0]['members'] = array();

        $gid    = $result[0]['gid'];
        $gameMembers = $this -> getGameMembers($gid);

        foreach($gameMembers as $member){
            array_push($result[0]['members'], $member);
        }

        return $result;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function changeTurnState($tid,$state){ // Checked

        $data = array(
               'state' => $state
            );

        $this->db->where('tid', $tid);
        $this->db->update('esmfamil_turn', $data);

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function changeGameState($gid,$state){ // Checked

        $data = array(
               'isfinished' => $state
            );

        $this->db->where('gid', $gid);
        $this->db->update('esmfamil_game', $data);

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function isGameRoundsCompleted($gid){ // Checked

        if($this -> getNumberOfGameRoundsPlayed($gid) >= $this -> gameRoundNumber($gid)){
            return 1;
        }

        return 0;

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

        $pool = "ضصثقفغعهخحجچشسیبلاتنمکگظطزرذدپو";
        $rand = rand(0,30);

        /*$pool = "abcdefghijklmnopqrstuvwxyz";
        $rand = rand(0,25);        */

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
    public function calculateAndReturnLastRoundResults($gid){

        $lastTurnId = $this -> getLastTurnId($gid);
        $lastTurnNames = $this -> namesmodel -> getTurnNamesIds($lastTurnId);

        $result = array();
        foreach ($lastTurnNames as $name) {

            $nid = $name['nid'];
            $nickname = $this -> usermodel -> getNicknameByUid($name['uid']);
            $score = $this -> namesmodel -> setScoreForNames($nameId);

            $temp = array("nickname" => $nickname,
                          "score" => $score
                    );

            array_push($result,$temp);
            
        }

        return $result;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getLastTurnId($gid){ // checked

        $this -> db -> select_max('tid');
        $this -> db -> from("esmfamil_game_turns");
        $this -> db -> where("gid",$gid);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        $tid = $result[0]['tid'];

        return $tid;

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
    public function getGameState($gid){

        $this -> db -> select('isfinished');
        $this -> db -> from('esmfamil_game');
        $this -> db -> where('gid',$gid);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        $state = $result[0]['isfinished'];

        return $state;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getTurnState($tid){

        $this -> db -> select('state');
        $this -> db -> from('esmfamil_turn');
        $this -> db -> where('tid',$tid);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        $state = $result[0]['state'];

        return $state;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //    

};