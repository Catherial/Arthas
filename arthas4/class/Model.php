<?php
	//
	class Model {
		
		public $db_instance = "";   //数据库实例
		
		function __construct() {
			
			$db_type = DB_TYPE;
			$this->db_instance = new $db_type();
			
		}
		
		public function query($sql) {
			 
			return $this->db_instance->query($sql);
		}
		
		public function show_query() {
			$this->db_instance->show_query();
		}
	}
?>