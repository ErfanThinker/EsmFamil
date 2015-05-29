 <?php
class Chatmodel extends CI_Model {

    public function __construct()
    {
        $this -> load -> model("usermodel");

        $this->load->database();
        $this->load->helper('array');
    }

    public function addMessage($gid,$uid,$text){

    	$data = array('gid' => $gid, 'uid' => $uid, 'text' => $text, 'time' => round(microtime(true) * 1000) );
    	
    	$success =  $this -> db -> insert('esmfamil_messages',$data);

    	return $success;
    }
}
?>