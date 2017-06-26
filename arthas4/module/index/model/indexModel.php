<?php
	class IndexModel extends Model {
		
		function __construct() {
			parent::__construct();
		}
		
		public function index() {
			$sql = "select * from test";
			print_r($this->db_instance->query($sql));
		}
		
		public function get_info() {
			
		}
	}

?>