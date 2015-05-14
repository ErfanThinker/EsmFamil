<?php
class Namesmodel extends CI_Model {

    public function __construct()
    {
        $this -> load -> model("usermodel");

        $this->load->database();

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function createNames($tid , $userIds){ // Checked

    	foreach ($userIds as $id) {

    		// Create one Names
    		$data = array(
    			'uid' => $id ,
    			'tid' => $tid
			);

			$this->db->insert('esmfamil_names', $data);
			$nid = $this -> db -> insert_id();

			// Add names to user_names
			$data = array(
    			'nid' => $nid ,
    			'uid' => $id
			);

			$this->db->insert('esmfamil_user_names', $data);


    	}

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function setNames($nickname,$gid,$name,$family,$car,$color,$objects,$city){ // checked

        $userLastNamesId = $this -> getUserLastNames($nickname,$gid);

        if($this -> namesSetBefore($userLastNamesId)){

            return false;

        }else{

            $data = array("name" => $name,
                          "family" => $family,
                          "car" => $car,
                          "color" => $color,
                          "objects" => $objects,
                          "city" => $city,
                          "score" => 1
                    );

            $this->db->where('nid', $userLastNamesId);
            $query = $this->db->update('esmfamil_names', $data);

            return true;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getUserLastNames($nickname,$gid){ // checked

        $tid = $this -> getUserLastTurn($nickname,$gid);
        $uid = $this -> usermodel -> getUserIdByNickname($nickname);

        $this -> db -> select('nid');
        $this -> db -> from("esmfamil_names");
        $this -> db -> where("uid",$uid);
        $this -> db -> where("tid",$tid);
        $query = $this -> db -> get();

        $result = $query -> result_array();

        $nid = $result[0]['nid'];

        return $nid;


    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getUserLastTurn($nickname,$gid){ // checked

        $this -> db -> select_max("tid");
        $this -> db -> from("esmfamil_game_turns");
        $this -> db -> join('esmfamil_game_members','esmfamil_game_members.gid = esmfamil_game_turns.gid');
        $this -> db -> where("esmfamil_game_members.gid",$gid);
        $this -> db -> where("pnickname",$nickname);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        $tid = $result[0]['tid'];

        return $tid;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function firstSetNameInThisTurn($nickname,$gid){ // checked

        $lastTurnId = $this -> getUserLastTurn($nickname,$gid);

        $this -> db -> from("esmfamil_names");
        $this -> db -> where("tid",$lastTurnId);
        $this -> db -> where("score !=",0);
        $result = $this -> db -> count_all_results();

        if($result == 1){

            return 1;

        }else{

            return 0;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function namesSetBefore($nid){ // checked

        $this -> db -> select('*');
        $this -> db -> from("esmfamil_names");
        $this -> db -> where("nid",$nid);
        $this -> db -> where("score !=",0);
        $result = $this -> db -> count_all_results();

        if($result != 0){

            return 1;

        }else{

            return 0;

        }

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function setScoreForNames($nid){

        $data = array('name','family','car','color','city','objects');
        $this -> db -> select($data);
        $this -> db -> from("esmfamil_names");
        $this -> db -> where('nid',$nid);
        $query = $this -> db -> get();
        $results = $query -> result_array();
        $results = $results['0'];

        $trueAnswers = 0;
        foreach ($results as $result) {

            if($result != NULL){
                $trueAnswers = $trueAnswers + 1 ;
            }

        }

        $score = $trueAnswers * 10;
        $data = array("score" => $score);

        $this -> db -> where("nid",$nid);
        $this -> db -> update("esmfamil_names",$data);


        return $score;

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getTurnNamesIds($tid){

        $this -> db -> select("nid");
        $this -> db -> select("uid");
        $this -> db -> from("esmfamil_names");
        $this -> db -> where("tid",$tid);
        $query = $this -> db -> get();

        return $query -> result_array();

    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getNamesScore($nid){

        $this -> db -> select("score");
        $this -> db -> from("esmfamil_names");
        $this -> db -> where("nid",$nid);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        return $result[0]['score'];
    }
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    public function getUserTotalNamesScore($uid){

        $this -> db -> select("score");
        $this -> db -> from("esmfamil_names");
        $this -> db -> where("uid",$uid);
        $query = $this -> db -> get();
   	return $query; 
   }
};
