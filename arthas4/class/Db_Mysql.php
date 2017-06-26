<?php
	/*
		数据库类     Arthas
		    
	*/
		
	class Db_Mysql{
		private $con;
		public $sql_record = array();
		public $sql_status = array();
		/*
			构造函数
			        : 用于连接数据库
		*/
		
		function __construct() {
			$this -> con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this -> con) {
				die("数据库连接错误: " . mysqli_connect_error()); 
			}
		}

		/***
			sql语句执行函数
			$sql : sql语句
		*/
		function query($sql) {
			
			set_time_limit(0);
			$result = mysqli_query($this->con, $sql);
			$this->sql_record[] = $sql; 
			if ($result) {                 //sql语句是否执行成功
				if ($result === true) {   //insert,update,delete类型的语句
					$this->sql_status[] = "insert,update,delete true";
					return true;
				} else {                  //select 类型语句
					$arr = array();
					while($row = $result->fetch_assoc()) {
						$arr[] = $row;
					}
					$this->sql_status[] = "select true";
					return $arr;              //返回执行的结果
				}
			} else if($result === false) {
				$this->sql_status[] = "sql error";
				echo "sql error!<br/>".$sql;
			}
		}
		
		/**
			事务函数
			$sql_arr : sql语句数组
		*/
		function query_commit($sql_arr) {
			
		}
		/*****
			关闭数据库连接函数
		*/
		function close_con() {
			mysqli_close($this->con);
		}
		
		
		function open_con() {
				$this -> con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this -> con) {
				die("连接错误: " . mysqli_connect_error()); 
			}
		}
		
	}
	 
	 
?>