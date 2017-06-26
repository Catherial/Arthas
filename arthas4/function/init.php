<?php
	defined ("ACCESS") or die ("access error");
	/*
		自动类加载函数        
		自动加载 class 下  和对应Controller下的类咯
	*/
	function autoload($class_name) {
		 
		$arr = array(
			CLASS_PATH . "/{$class_name}.php",
			CONTROLLER_PATH . "/{$class_name}.php",
			MODEL_PATH . "/{$class_name}.php"
		);
		foreach ($arr as $file) {
			if (is_file ($file)) {
				require_once ($file);
			}
		}
	}
	/*
		url转换函数       
	*/
	 function url($param_str, $other_str = array()) { 
		 $arr_params = explode('/', $param_str);
		 $url = $_SERVER['SCRIPT_NAME']."/".MODULE_NAME."/{$arr_params[0]}/{$arr_params[1]}";
		 
		 if ($other_str) {
		/*	 $arr_params = explode('/', $other_str);
			 for($i = 0; $i < count($arr_params) - 1; $i+=2) {
				 $url .= "&" . $arr_params[$i] . "=" . $arr_params[$i+1];
			 }*/
			 foreach($other_str as $key => $value) {
			     $url .= "/" . $key . "/" . $value;
			 }
		 }
		 return $url;
	 }
	 /*
		数组格式化输出
	 */
	 
	 function _print($arr) {
		 echo "<pre>";
		 print_r($arr);
		 echo "</pre>";
		 
	 }
?>