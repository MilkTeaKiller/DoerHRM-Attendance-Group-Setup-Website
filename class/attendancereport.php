<?php
class Attendancereport {
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

	public function search_attendance_record_list($user_id) {
		$record_list = array();
		$user_ids = array();

		$user_ids[] = $user_id;

		$attendance_record = $this->_db->getAll('attendance_record');
		if($attendance_record->count()) {
			$attendance_record_list = $attendance_record->results();
			if(!empty($attendance_record_list)) {
				foreach ($attendance_record_list as $v) {
					if(in_array($v->userID, $user_ids)) {
						$record_list[] = array('Date'=>$v->Date,'userID'=>$v->userID,'punchIn_morning'=>$v->punchIn_morning,'punchOut_morning'=>$v->punchOut_morning,
							'punchIn_afternoon'=>$v->punchIn_afternoon,'punchOut_afternoon'=>$v->punchOut_afternoon);
					}
				}
			}
		}
		return $record_list;
	}
}
?>