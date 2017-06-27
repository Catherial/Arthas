<?php
	 
	class IndexController {
		
		public function index() {
			$model = new IndexModel();
			_print($model->query("SELECT * FROM test"));
			include(VIEW_PATH . "/index.php");
			 
			 
			
			 
		}
		
		public function index2() {
			  
		}
		
		
		
		
	}
?>