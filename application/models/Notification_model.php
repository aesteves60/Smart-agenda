<?php
class Notification_Model extends CI_Model {

	public function get($notification = NULL){
		if($notification === NULL) 
			throw new Exception("No notification set", 1);
		else {
			$this->db->where('item', $notification);
			$query = $this->db->get('Notification');
			
			if($result = $query->row())
				return array('code' => $notification, 'class' => $result->type, 'message' => $result->message);
			else 
				throw new Exception("No notification found", 1);
		}
	}
	
}