<?php
class Newsmodel extends CI_Model {

    public function __construct()
    {
        $this -> load -> model("usermodel");

        $this->load->database();
        $this->load->helper('array');
    }

    
    public function getNews(){

        $this -> db -> select('*');
        $this -> db -> from("esmFamil_news");
        $this -> db ->order_by("creationDate", "desc");
        $this -> db -> limit(5);
        $query = $this -> db -> get();
        $result = $query -> result_array();

        return $result;
    }


    public function setNews($title, $body, $nickname){
    	
    	$data = array('title' => $title, 'body' => $body, 'creator' => $nickname, 'creationDate' => round(microtime(true) * 1000) );
    	
    	$success =  $this -> db -> insert('esmFamil_news',$data);

    	return $success;
    }

};
?>