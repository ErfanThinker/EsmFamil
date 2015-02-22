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
        echo "count of users Exist = ".$count;
        if($count == 0)
            return False;
        
        return True;
    }
    
    function nicknameExists($nickname){
        
        $this->db->select("nickname");
        $this->db->from("esmFamil_user");
        $this->db->where("nickname",$nickname);
        $count = $this->db->count_all_results();
        echo "count of nickname Exist = ".$count;
        if($count == 0)
            return False;
        
        return True;
    }

    function addUser($name, $bdate, $mail, $nick_name, $pass){
    	$data = array(
		   'name' => $name ,
		   'mail' => $mail ,
		   'nickname' => $nick_name,
		   'bdate' => $bdate,
		   'pass' => crypt($pass),
		   'isActive' => 0
		);

		$query = $this->db->insert('esmFamil_user', $data);
        /*echo "register result = ".$query;*/
        return $query; 
    }

    function activateUser($email){
	    $data = array(
               'isActive' => 1,
            );

        $this->db->where('mail', $email);
        $this->db->update('esmFamil_user', $data); 
	
    }
    
};