<?php
class ManageShift {
	private $_data,
			$_db;

	public function __construct($id = null) {
		$this->_db = Database::getInstance();
	}

	public function data() {
		return $this->_data;
	}

	public function lastinsertid() {
		return $this->_db->lastinsertid();
	}

	public static function exists() {
		return (!empty($this->_data)) ? true : false;
	}

	public function search_manage_shift_list() {
		$item = array();

		$data = $this->_db->getAll('manage_shift');
		if ($data->count()) {
			$data_row = $data->results();
			if (!empty($data_row)) {
				foreach ($data_row as $row) {
					$item[] = array('manageShiftID'=>$row->manageShiftID,'userID'=>$row->userID,'manageShiftDate'=>$row->manageShiftDate,'comment'=>$row->comment);
				}
			}
		}
		return $item;
	}

	public function get_manage_shift($id) {
		$item = array();
		$data = $this->_db->get('manage_shift', array("manageShiftID", '=', $id)); 
		if ($data->count()) {
			$data_row = $data->results();
			if (!empty($data_row)) {
				foreach ($data_row as $row) {
					$item[] =  array('manageShiftID'=>$row->manageShiftID,'userID'=>$row->userID,'manageShiftDate'=>$row->manageShiftDate,'comment'=>$row->comment);
				}
			}
		}
		return $item;
	}

	public function update_manage_shift($fields = array(), $id = null, $idname){
		if (!$this->_db->update('manage_shift', $id, $fields, $idname)) {
		  throw new Exception('There was a problem updating manage shift.');
		}
	}

	public function add_manage_shift($fields = array()){
		if(!$this->_db->insert('manage_shift', $fields)) {
		  throw new Exception('There was a problem adding a manage shift.');
		}
	}

	public function delete_manage_shift($id = null){
		if($id){
			$data = $this->_db->delete('manage_shift', array("manageShiftID", '=', $id));
			return $data;
		}
		return false;
	}
}
?>