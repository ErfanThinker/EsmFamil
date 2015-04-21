<?php
class Namesmodel extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function createNames($tid , $userIds){ // Checked

    	foreach ($userIds as $id) {

    		// Create one Names
    		$data = array(
    			'uid' => $id ,
    			'tid' => $tid
			);

			$this->db->insert('esmfamil_names', $data);
			$nid = $this -> db -> insert_id();


			//Add names to turn_names
			$data = array(
    			'nid' => $nid ,
    			'tid' => $tid
			);

			$this->db->insert('esmfamil_turn_names', $data);

			// Add names to user_names
			$data = array(
    			'nid' => $nid ,
    			'uid' => $id
			);

			$this->db->insert('esmfamil_user_names', $data);


    	}

    }

};