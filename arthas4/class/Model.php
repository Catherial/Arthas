<?php
	//
	class Model {
		public $db_instance = "";   //数据库实例
		function __construct() {
			$db_type = DB_TYPE;
			$this->db_instance = new $db_type();
		}
	}
?>