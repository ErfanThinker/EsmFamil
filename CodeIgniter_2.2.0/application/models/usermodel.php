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
        if($count == 0)
            return False;
        
        return True;
    }
    
    function nicknameExists($nickname){
        
        $this->db->select("nickname");
        $this->db->from("esmFamil_user");
        $this->db->where("nickname",$nickname);
        $count = $this->db->count_all_results();
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
        return $query; 
    }

    function activateUser($email){
	    $data = array(
               'isActive' => 1,
            );

        $this->db->where('mail', $email);
        $this->db->update('esmFamil_user', $data); 
	
    }

    function addVerificationToken($token, $email){
        $data = array(
            'mail' => $email,
            'token' => $token,
            'timestamp' => round(microtime(true) * 1000)
            );
        $query = $this->db->insert('esmFamil_verf', $data);
        return $query; 
    }
    
    function updateVerf($token, $email){
        $data = array(
            'token' => $token,
            'timestamp' => round(microtime(true) * 1000)
            );
        $this->db->where('mail', $email);
        $this->db->update('esmFamil_verf', $data); 
    }

    function confirmValidation($token, $email){
        $this->db->select();
        $this->db->from("esmFamil_verf");
        $this->db->where("mail",$email);
        $this->db->where("token",$token);
        $count = $this->db->count_all_results();
        
        //check timestamp Here...
        
        
        if($count == 0){
            return False;
        }else{
            $this -> activateUser($email);
            return TRUE; 
        }

    }
    
    function removeOldCaptcha(){
        $expiration = time()-60;
        //this query should change to active record
        $this->db->query("DELETE FROM captcha WHERE time < ".$expiration);
        
        //old images should remove from captcha directory here.
    }
    
    function addNewCaptcha($time , $ip , $word){
        $data1 = array('time'=> $time,'ip'=> $ip,'word'=> $word);
        
        $query = $this->db->insert_string('captcha', $data1);
        $this->db->query($query);
        
    }
    
};