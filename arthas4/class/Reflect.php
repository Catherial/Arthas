<?php
	//自定义的反射类
	class Reflect {
		
		//输出实例的信息
		// $class_name : 参数为实例
		public static function print_instance($instance) {
			$reflect = new ReflectionObject($instance);
			
			$properties = $reflect->getProperties();
			$methods = $reflect->getMethods();
			$path = $reflect->getFileName();
			
			echo "The instance infomation as follow: <br/>";
			echo "class path: " . $path . "<br/>";
			echo "---------------------------<br/>";
			
			echo "properties:<br/>";
			foreach ($properties as $key => $value) {
				echo $value->name . "<br/>";
				
			}
			
			echo "--------------------------<br/>";
			echo "methods:<br/>";
			foreach ($methods as $key => $value) {
				echo $value->name . "<br/>";
			
			}
			
		}
		
		public static function print_class($class_name) {
			$reflect = new ReflectionClass($class_name);
			
			$path = $reflect->getFileName();
			$properties = $reflect->getProperties();
			$methods = $reflect->getMethods();
			echo "The class infomation as follow: <br/>";
			echo "class path: " . $path . "<br/>";
			echo "---------------------------<br/>";
			
			echo "properties:<br/>";
			foreach ($properties as $key => $value) {
				echo $value->name . "<br/>";
				
			}
			
			echo "--------------------------<br/>";
			echo "methods:<br/>";
			foreach ($methods as $key => $value) {
				echo $value->name . "<br/>";
			
			}
			
			
		}
		
	}
	
?>