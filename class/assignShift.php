<?php
class AssignShift {
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

	public function search_shift_list() {
		$item = array();

		$data = $this->_db->getAll('shift_schedule');
		if ($data->count()) {
			$data_row = $data->results();
			if (!empty($data_row)) {
				foreach ($data_row as $row) {
					$item[] = array('shiftID'=>$row->shiftID,'userID'=>$row->userID,'username'=>$row->username,'agname'=>$row->agname,'corporateID'=>$row->corporateID,'companyID'=>$row->companyID);
				}
			}
		}
		return $item;
	}

	public function get_shift($id) {
		$item = array();
		$data = $this->_db->get('shift_schedule', array("shiftID", '=', $id)); 
		if ($data->count()) {
			$data_row = $data->results();
			if (!empty($data_row)) {
				foreach ($data_row as $row) {
					$item[] = array('shiftID'=>$row->shiftID,'userID'=>$row->userID,'username'=>$row->username,'agname'=>$row->agname,'corporateID'=>$row->corporateID,'companyID'=>$row->companyID);
				}
			}
		}
		return $item;
	}

	public function update_shift($fields = array(), $id = null, $idname){
		if (!$this->_db->update('shift_schedule', $id, $fields, $idname)) {
		  throw new Exception('There was a problem updating shift.');
		}
	}

	public function add_shift($fields = array()){
		if(!$this->_db->insert('shift_schedule', $fields)) {
		  throw new Exception('There was a problem adding a shift.');
		}
	}

	public function delete_shift($id = null){
		if($id){
			$data = $this->_db->delete('shift_schedule', array("shiftID", '=', $id));
			return $data;
		}
		return false;
	}
}
?>