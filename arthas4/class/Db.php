<?php
//数据库工厂
	class Db {
		public static function db_factory($db_type) {
			switch ($db_type) {
				case "mysql" :
					return new Db_Mysql();
					break;
				case "redis" :
					return new Db_Redis();
					
				default :
					break;
			}
		}
	}
?>