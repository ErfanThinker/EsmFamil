<?php
class Usermodel extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    function userExists($email){//Checked

        $this->db->select("mail");
        $this->db->from("esmFamil_user");
        $this->db->where("mail",$email);
        $count = $this->db->count_all_results();
        if($count == 0)
            return 0;
        
        return 1;
    }
    
    function nicknameExists($nickname){//Checked
        
        $this->db->select("nickname");
        $this->db->from("esmFamil_user");
        $this->db->where("nickname",$nickname);
        $count = $this->db->count_all_results();
        if($count == 0)
            return FALSE;
        
        return True;
    }

    function addUser($name, $bdate, $mail, $nick_name, $pass){//Checked
        $data = array(
           'name' => $name ,
           'mail' => $mail ,
           'nickname' => $nick_name,
           'bdate' => $bdate,
           'pass' => md5($pass),
           'isActive' => 0
        );

        $query = $this->db->insert('esmFamil_user', $data);
        return $query; 
    }

    function activateUser($email){// Checked
        $data = array(
               'isActive' => 1,
            );

        $this->db->where('mail', $email);
        $this->db->update('esmFamil_user', $data); 
    
    }

    function addVerificationToken($token, $email){//Checked
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

    function confirmValidation($token, $email){//Checked
        $this->db->select();
        $this->db->from("esmFamil_verf");
        $this->db->where("mail",$email);
        $this->db->where("token",$token);
        $count = $this->db->count_all_results();
        
        if($count == 0){
            return FALSE;
        }else{
            $this -> activateUser($email);
            return TRUE; 
        }

    }
    
    function removeOldCaptcha(){//Checked
    
        $expiration = time()-60;
        $this->db->query("DELETE FROM captcha WHERE time < ".$expiration);
        
        $this->deleteExpiredImages();
    
    }
    
    function deleteExpiredImages(){//Checked
        
        $result ="";
        $path = "/var/www/EsmFamil/CodeIgniter_2.2.0/css/captcha/";
        // Open a known directory, and proceed to read its contents
        if ($dh = opendir($path)) {
            while (($file = readdir($dh)) !== FALSE){
                $temp = explode(".", $file);
                $extension = end($temp);
                if($extension == "jpg"){
                    $time = $temp[0].'.'.$temp[1];
                    if(intval($time) < time() - 60){
                        $tempPath = $path.$file;
                        unlink($tempPath);
                    }
                }
            }
        }
        closedir($dh);
    }
    
    public function addNewCaptcha($time , $ip , $word){//Checked
        $data1 = array('time'=> $time,'ip'=> $ip,'word'=> $word);
        
        $query = $this->db->insert_string('captcha', $data1);
        $this->db->query($query);
        $cid = $this -> db -> insert_id();
        return $cid;
    }

    public function checkPassword($nickname, $password){//Checked
    
        $this->db->from('esmFamil_user');
        $this->db->where('nickname', $nickname);
        $this->db->where('pass', md5($password));
        $count = $this->db->count_all_results();
        
        
        if($count == 0){
            return 0;
        }else{
            return 1; 
        }
        
    }

    //it changes password of $nickname to $newPassword
    function changePassword($nickname, $oldPassword, $newPassword){//Checked
        
        $check = $this->checkPassword($nickname, $oldPassword);
        
        if($check == FALSE){
            return FALSE;
        }else{
            $data = array(
               'pass' => md5($newPassword)
            );
            
            $this->db->where('nickname', $nickname);
            $result = $this->db->update('esmFamil_user', $data);
            
            return $result;
            
        }
        
        
    }

    function editProfile($nickname, $name, $bdate){//Checked
        
        $exist = $this->nicknameExists($nickname);
        
        if($exist == FALSE)
            return FALSE;
        
        $data = array(
           'name' => $name ,
           'bdate' => $bdate
        );
        $this->db->where('nickname', $nickname);
        $result = $this->db->update('esmFamil_user', $data);
        return $result; 
        
    }
    
    function checkVerified($nickname){//Checked

        $this->db->select();
        $this->db->from('esmFamil_user');
        $this->db->where('nickname', $nickname);
        $this->db->where('isActive', 1);
        $count = $this->db->count_all_results();
        
        if($count == 0){
            return 0;
        }else{
            return 1; 
        }
    }

    public function getUserIdByNickname($nickname){ // Checked

        $this -> db -> select("id");
        $this -> db -> from("esmFamil_user");
        $this -> db -> where("nickname",$nickname);
        $query = $this -> db -> get();

        if ($query->num_rows() > 0)
        {
           $row = $query->row();

           return $row -> id;
        } 

    }

    public function getUserIds($users){

        $userIds = array();

        foreach ($users as $user) {
            $id = $this -> getUserIdByNickname($user["pnickname"]);
            array_push($userIds, $id);
        }

        return $userIds;

    }
};
