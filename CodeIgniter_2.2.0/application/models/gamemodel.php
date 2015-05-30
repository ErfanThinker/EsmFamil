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
    public function createNewGame($maxPlayer,$rounds,$creatorNickname, $gname, $isPrivate){

        $data = array(
           'gname' => $gname,
           'maxnumofplayers' => $maxPlayer ,
           'creaternickname' => $creatorNickname,
           'winnernickname' => '',
           'rounds' => $rounds,
           'isfinished' => 0,
           'pass' => '',
           'isPrivate' => $isPrivate
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
    public function getListOfGames($isAdmin,$nickname){

        if($isAdmin == 0){

            $query = $this->db->get_where('esmfamil_game',array('isfinished' => 0, 'isPrivate' => 0));

        }else{

            $query = $this->db->get_where('esmfamil_game',array('isfinished' => 0));            

        }
        
        $result = array();
        if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row)
            {

                $temp = $this -> getGameMembers($row['gid']);
                $row['currentlyJoined'] = count($temp);

                array_push($result, $row);
                
            }
        }

        if($this -> checkActiveGame($nickname)){

            $activeGame = $this -> getActiveGame($nickname);

            if($activeGame['0']['isPrivate'] == 1 && $isAdmin == 0)
                array_push($result,$activeGame['0']);

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

        $letter = $this -> getTurnLetter($gid);
        if($letter != null){

            $result[0]['letter'] = $letter;
        }else{

            $result[0]['letter'] = '';
        }

        $result[0]['currentlyJoined'] = count($gameMembers);

        return $result;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getTurnLetter($gid){
        
        $tid = $this -> getLastTurnId($gid);

        $this -> db -> select('letter');
        $this -> db -> from('esmfamil_turn');
        $this -> db -> where('tid',$tid);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        if(isset($result[0])){

            return $result[0]['letter'];        

        }else{

            return null;

        }
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


        $pool = array('ض','ص','ث','ق','ف','غ','ع','ه','خ','ح','ج','چ','ش','س','ی','ب','ل','ا','ت','ن','م','ک','گ','ظ','ط','ز','ر','ذ','د','پ','و');
        $rand = rand(0,30);

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
    public function getLastRoundResults($gid){

        $lastTurnId = $this -> getLastTurnId($gid);

        return $this -> getRoundResult($lastTurnId);

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getRoundResult($tid){

        $turnNames = $this -> namesmodel -> getTurnNamesIds($tid);

        $result = array();
        foreach ($turnNames as $name) {

            $nid = $name['nid'];
            $uid = $name['uid'];
            $nickname = $this -> usermodel -> getNicknameByUid($uid);
            $score = $this -> namesmodel -> getNamesScore($nid);

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
    public function getGameResultUntilNow($gid){

        /*$gameTids = $this -> getGameTurnsIds($gid);*/
        $gameMembers = $this -> getGameMembers($gid);
        $lastTurnResult = $this -> getLastRoundResults($gid);

        $result = array();

        foreach ($gameMembers as $member) {
            
            $temp = array('nickname' => '','totalScore' => 0,'score' => 0);
            $temp['nickname'] = $member['pnickname'];

            
            $uid = $this -> usermodel -> getUserIdByNickname($member['pnickname']);
            $userTotalScoreInGame = $this -> namesmodel -> getUserTotalScoreInGame($gid,$uid);
            $temp['totalScore'] = $userTotalScoreInGame[0]['score'];


            foreach($lastTurnResult as $userTurnResult){

                if($userTurnResult['nickname'] == $temp['nickname']){
                    $temp['score'] = $userTurnResult['score'];
                }

            }

            array_push($result, $temp);

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
    public function getGameTurnsIds($gid){

        $this -> db -> select("tid");
        $this -> db -> from("esmfamil_game_turns");
        $this -> db -> where("gid",$gid);
        $query = $this -> db -> get();

        $result = $query -> result_array();

        return $result;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function setReferies($tid){

        $turnNames = $this -> namesmodel -> getTurnNamesIds($tid);

        for($i = 0;$i<count($turnNames);$i++){

            $nextOne = ($i + 1) % count($turnNames);

            $nid = $turnNames[$i]['nid'];
            $nextOneUid = $turnNames[$nextOne]['uid'];
            
            $this -> addReferi($nid,$nextOneUid);

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function addReferi($nid,$uid){

        $this -> db -> select('*');
        $this -> db -> from('esmfamil_judgments');
        $this -> db -> where("uid",$uid);
        $this -> db -> where("nid",$nid);
        $query = $this -> db -> count_all_results();

        if($query == 0){

            $data = array("uid" => $uid,"nid" => $nid);
            $this -> db -> insert("esmfamil_judgments",$data);

            return true;

        }else{

            return false;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getToJudgeNamesForUser($gid,$nickname){

        $tid = $this -> getLastTurnId($gid);

        $uid = $this -> usermodel -> getUserIdByNickname($nickname);
        $nidToJudge = $this -> getLastNidUserShouldJudge($uid);

        $isNidInThisTurn = $this -> namesmodel -> isNidInThisTurn($nidToJudge,$tid);
        $isScored = $this -> checkNameIsScored($nidToJudge);

        if($isNidInThisTurn && $isScored == 0){

            return $this -> namesmodel -> getNames($nidToJudge);

        }else{

            return null;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getLastNidUserShouldJudge($uid){

        $this -> db -> select('nid');
        $this -> db -> from("esmfamil_judgments");
        $this -> db -> where("uid",$uid);
        $this -> db ->order_by("id", "desc");
        $this -> db -> limit(1);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        if(count($result) != 0){
            return $result[0]['nid'];
        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function get20BestUsersAcordingTotalScores(){

        $data = array('id','nickname','totalscore');

        $this -> db -> select($data);
        $this -> db -> from('esmFamil_user');
        $this -> db -> order_by("totalscore", "desc");
        $this -> db -> limit(20,0);
        $query = $this -> db -> get();
        $result = $query -> result_array();
            
        return $result; // array of (nickname, score)
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function checkNameIsScored($nid){
        
        $this -> db -> select('isScored');
        $this -> db -> from('esmfamil_names');
        $this -> db -> where('nid', $nid);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        if(count($result) != 0){
            if($result[0]['isScored'] == 1)
                return 1;
            else
                return 0;
        }else{

            return -1;
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function checkUserIsValidForJudgment($nid, $nickname){

        $user_id = $this -> usermodel -> getUserIdByNickname($nickname);        

        $this -> db -> select('uid');
        $this -> db -> from('esmfamil_judgments');
        $this -> db -> where('nid', $nid);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        if( count($result) > 0 && $result[0]['uid'] == $user_id)
            return 1;
        else
            return 0;
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function setNameScore($score, $nid){

        $data = array(
               'score' => $score,
               'isScored' => '1'
            );

        $this -> db -> where('nid', $nid);
        $query = $this -> db -> update('esmfamil_names', $data);

        if($query){
            return true;
        }else{
            return false;
        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function namesIsForThisGame($nid,$gid){

        $this -> db -> select();
        $this -> db -> from('esmfamil_names');
        $this -> db -> join('esmfamil_game_turns','esmfamil_game_turns.tid = esmfamil_names.tid');
        $this -> db -> where('esmfamil_names.nid',$nid);
        $this -> db -> where('esmfamil_game_turns.gid',$gid);
        $query = $this -> db -> count_all_results();

        if($query == 0){

            return 0;

        }else{

            return 1;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getGamesUserInvitedTo($nickname)
    {
        $uid = $this -> usermodel -> getUserIdByNickname($nickname);

        $this -> db -> select('gid');
        $this -> db -> from('esmfamil_invitations');
        $this -> db -> where('uid',$uid);
        $this -> db -> where('status',0);

        $query = $this -> db -> get();

        $result = array();

        if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row)
            {

                $temp = $this -> getGamesCreatorname($row['gid']);
                if($temp)
                    $row['creatornickname'] = $temp;


                array_push($result, $row);
                
            }
        }

        return $result;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getGamesCreatorname($gid)
    {

        $this -> db -> select('creaternickname');
        $this -> db -> from('esmfamil_game');
        $this -> db -> where('gid',$gid);
        $qeury = $this -> db -> get();

        $result = $qeury -> result_array();

        if(count($result) > 0){

            return $result[0]['creaternickname'];

        }else{

            return 0;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function userIsNotInvitedToGame($gid,$nickname){

        $uid = $this -> usermodel -> getUserIdByNickname($nickname);

        $this -> db -> select();
        $this -> db -> from("esmfamil_invitations");
        $this -> db -> where("gid",$gid);
        $this -> db -> where("uid",$uid);
        $query = $this -> db -> count_all_results();

        if($query == 0){

            return 1;
        }else{

            return 0;
        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function inviteUserToGame($gid,$user){

        $uid = $this -> usermodel -> getUserIdByNickname($user);

        $data = array('gid'=> $gid , 'uid' => $uid, 'status' => 0);

        $query = $this->db->insert('esmfamil_invitations', $data);
        $id = $this->db->insert_id();

        return $id;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function invitationIsFinished($invitationId){

        $this -> db -> select();
        $this -> db -> from("esmfamil_invitations");
        $this -> db -> where("id",$invitationId);
        $this -> db -> where("status",1);
        $query = $this -> db -> count_all_results();

        if($query == 0){
            return 0;
        }else{
            return 1;
        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function finishInvitation($invitationId){

        $data = array('status' => 1);

        $this->db->where('id', $invitationId);
        $this->db->update('esmfamil_invitations', $data);

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //

};