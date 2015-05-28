<?php
class Newsmodel extends CI_Model {

    public function __construct()
    {
        $this -> load -> model("usermodel");

        $this->load->database();
        $this->load->helper('array');
    }

    
    public function getNews(){

        $query = $this -> db -> get('esmFamil_news', 5, 0);
        $this->db->order_by("creationDate", "desc"); 
        $result = $query -> result_array();
        return $result;
    }


    public function setNews($title, $body, $nickname){
    	
    	$creator = $this -> usermodel -> getUserIdByNickname($nickname);
    	
    	$data = array('title' => $title, 'body' => $body, 'creator' => $creator, 'creationDate' => round(microtime(true) * 1000) );
    	
    	$success =  $this -> db -> insert('esmFamil_news',$data);

    	return $success;
    }

};
?>