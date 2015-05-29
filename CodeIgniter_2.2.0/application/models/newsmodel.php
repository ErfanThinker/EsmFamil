<?php
class Newsmodel extends CI_Model {

    public function __construct()
    {
        $this -> load -> model("usermodel");

        $this->load->database();
        $this->load->helper('array');
    }

    
    public function getNews($nickname){

        $this -> db -> select('*');
        $this -> db -> from("esmFamil_news");
        $this -> db ->order_by("creationDate", "desc");
        $this -> db -> limit(5);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        //set lastNewsId of user to last news id
        if(count($result) > 0){
            $data = array(
                'lastNewsId' => $result[0]['id']
            );

            $this->db->where('nickname', $nickname);
            $this->db->update('esmFamil_user', $data);
        }

        return $result;
    }


    public function setNews($title, $body, $nickname){
    	
    	$data = array('title' => $title, 'body' => $body, 'creator' => $nickname, 'creationDate' => round(microtime(true) * 1000) );
    	
    	$success =  $this -> db -> insert('esmFamil_news',$data);

    	return $success;
    }

    public function isThereNews($nickname){
        $this -> db -> select('lastNewsId');
        $this -> db -> from('esmFamil_user');
        $this -> db -> where('nickname', $nickname);
        $query  = $this -> db -> get();
        $result = $query -> result_array();

        if(count($result) == 0)
            return 0;
        $user_lastNewsId = $result[0]['lastNewsId'];

        //getting last news id
        $this -> db -> select('*');
        $this -> db -> from("esmFamil_news");
        $this -> db ->order_by("creationDate", "desc");
        $this -> db -> limit(1);
        $query = $this -> db -> get();
        $news_result = $query -> result_array();

        if(count($news_result) == 0)
            return 0;
        $last_news_id = $news_result[0]['id'];

        if($last_news_id != $user_lastNewsId)
            return 1;
        else
            return 0;
    
    }

};
?>