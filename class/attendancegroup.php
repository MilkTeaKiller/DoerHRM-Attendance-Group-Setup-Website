<?php
class Attendancegroup {
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

	public function search_attendance_group_list() {
		$group_list = array();

		$data = $this->_db->getAll('attendance_group');
		if ($data->count()) {
			$attendance_group_list = $data->results();
			if (!empty($attendance_group_list)) {
				foreach ($attendance_group_list as $row) {
					$group_list[] = array('agID'=>$row->agID,'agname'=>$row->agname,'firstpunchintime'=>$row->firstpunchintime,'breaktime'=>$row->breaktime,'breakhours'=>$row->breakhours,'secondpunchintime'=>$row->secondpunchintime,'secondpunchouttime'=>$row->secondpunchouttime, 'status'=>$row->status);
				}
			}
		}
		return $group_list;
	}

	public function get_attendance_group($id) {
		$item = array();
		$data = $this->_db->get('attendance_group', array("agID", '=', $id)); 
		if ($data->count()) {
			$data_row = $data->results();
			if (!empty($data_row)) {
				foreach ($data_row as $row) {
					$item[] = array('agID'=>$row->agID,'agname'=>$row->agname,'firstpunchintime'=>$row->firstpunchintime,'breaktime'=>$row->breaktime,'breakhours'=>$row->breakhours,'secondpunchintime'=>$row->secondpunchintime,'secondpunchouttime'=>$row->secondpunchouttime, 'status'=>$row->status);
				}
			}
		}
		return $item;
	}

	public function update_attendance_group($fields = array(), $id = null, $idname){
		if (!$this->_db->update('attendance_group', $id, $fields, $idname)) {
		  throw new Exception('There was a problem updating attendance_group.');
		}
	}

	public function add_attendance_group($fields = array()){
		if(!$this->_db->insert('attendance_group', $fields)) {
		  throw new Exception('There was a problem adding an attendance_group.');
		}
	}

	public function delete_attendance_group($id = null){
		if($id){
			$data = $this->_db->delete('attendance_group', array("agID", '=', $id));
			return $data;
		}
		return false;
	}
}
?>