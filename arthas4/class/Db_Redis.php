<?php
	class Db_Redis {
		public $db_instance = "";
		
		function __construct() {
			$this->db_instance = new Redis();
			$this->db_instance->connect(REDIS_HOST, REDIS_PORT);
		}
		
		public function set($key, $value) {
			return $this->db_instance->set($key, $value);
		}
		
		public function get($key) {
			return $this->db_instance->get($key);
		}
	}
?>