<?php
	/*
		���ݿ���     Arthas
		    
	*/
		
	class Db_Mysql{
		private $con;
		public $sql_record = array();
		public $sql_status = array();
		/*
			���캯��
			        : �����������ݿ�
		*/
		
		function __construct() {
			$this -> con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this -> con) {
				die("���ݿ����Ӵ���: " . mysqli_connect_error()); 
			}
		}

		/***
			sql���ִ�к���
			$sql : sql���
		*/
		function query($sql) {
			
			set_time_limit(0);
			$result = mysqli_query($this->con, $sql);
			$this->sql_record[] = $sql; 
			if ($result) {                 //sql����Ƿ�ִ�гɹ�
				if ($result === true) {   //insert,update,delete���͵����
					$this->sql_status[] = "insert,update,delete true";
					return true;
				} else {                  //select �������
					$arr = array();
					while($row = $result->fetch_assoc()) {
						$arr[] = $row;
					}
					$this->sql_status[] = "select true";
					return $arr;              //����ִ�еĽ��
				}
			} else if($result === false) {
				$this->sql_status[] = "sql error";
				echo "sql error!<br/>".$sql;
			}
		}
		
		/**
			������
			$sql_arr : sql�������
		*/
		function query_commit($sql_arr) {
			
		}
		/*****
			�ر����ݿ����Ӻ���
		*/
		function close_con() {
			mysqli_close($this->con);
		}
		
		
		function open_con() {
				$this -> con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this -> con) {
				die("���Ӵ���: " . mysqli_connect_error()); 
			}
		}
		
	}
	 
	 
?>