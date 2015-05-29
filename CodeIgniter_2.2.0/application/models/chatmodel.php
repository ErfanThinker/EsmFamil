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

    public function getLastMessages( $gid ){

    	$this -> db -> select('text, uid');
    	$this -> db -> from('esmfamil_messages');
    	$this -> db -> where('gid', $gid);
    	$this -> db -> order_by('time', 'desc');
    	$this -> db -> limit(10);
    	$query = $this -> db -> get();
    	$result = $query -> result_array();

    	$messages = array();
    	foreach ($result as $record) {

            $nickname = $this -> usermodel -> getNicknameByUid($record['uid']);
    		array_push($messages, array( 'text' => $record['text'], 'nickname' => $nickname ));
            
    	}

    	return $messages;
    }
}
?>