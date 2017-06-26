<?php
	 
	class IndexController {
		
		public function index() {
			_print($_SERVER);
			echo url("index/index2", array("id"=>"ds"));
			?>
			<form action="<?php echo url("index/index2", array("id"=>"ds"));?>">
				<input type="text"/>
				<input type="submit"/>
			</form>
			<?php
		}
		
		public function index2() {
			print_r($_GET);
		}
		
		
		
	}
?>