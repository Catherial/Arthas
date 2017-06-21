<?php
/*
*     CSV��
*  
*/
	class Csv {
		/*
		*  $file_name �����ļ���
		*  $head_content ͷ��
		*  $body_content ������
		*   to deal with :    ֱ�����csv��ʽ�ļ�
		*                 
		*/
		public static function put_csv($file_name, $head_content, $body_content) {
			
			header("Content-Type: application/vnd.ms-excel");
			header('Content-Disposition: attachment;filename="'.$file_name.'"');
			header('Cache-Control: max-age=0');
			for ($i = 0; $i < count($head_content); $i++) {
				$head_content[$i] = iconv('utf-8', 'gbk', $head_content[$i]);
				echo $head_content[$i];
				if ($i + 1 < count($head_content))
					echo ",";
			}
		
			ob_start();
			foreach ($body_content as $arr) {
				echo "\n";
				for ($i = 0; $i < count($arr); $i++) {
					$arr[$i] = iconv('utf-8', 'gbk', $arr[$i]);
					echo $arr[$i];
					if ($i +1 < count($arr))
						echo ",";
					if (count($body_content % 50000 == 0)) {
						ob_flush();
					}
				}
			}
		/*	$fp = fopen("php://output", 'a');
			for ($i = 1; $i < 100000; $i++)
			fputcsv($fp, $head_content);*/
		}
		
		/*
		*  ��ȡcsv��ʽ�ļ�
		*  $file_path : �ļ���ַ
		*/
		public static function get_csv($file_path) {
			if ($file = fopen($file_path, 'r')) {
				$arr = array();
				while ($data = fgetcsv($file)) {
					$arr[] = $data;
				}
				return $arr;
					
			} else {
				return "�ļ���ַ����";
			}
			
		}
	}

?>