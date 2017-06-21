<?php
	class FileModel extends Mysqli_db {
		function __construct() {
			parent::__construct();
		}
		
		public function index() {
			$sql = "select * from xxx";
			$arr = $this->query($sql);
		}
	}

?>