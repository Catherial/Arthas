<?php
	 
	class IndexController {
		
		public function index() {
			
			$db = Db::db_factory("mysql");
			$redis = Db::db_factory("redis");
			
			
			
			
			echo $redis->get("test");
		}
		
		public function index2() {
			print_r($_GET);
		}
		
		
		
	}
?>