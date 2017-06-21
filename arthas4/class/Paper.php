<?php
	class Paper {
		/*
			$url : �ļ�url (fileЭ���ʽ ����httpЭ���ʽ�Կ�)
			function file_download()
		*/
		public static function file_download($file_url) {
			if (@$file_handle = fopen($file_url, 'r')) {        //http Э��ʱ
				header("Content-Type: application/octet-stream");
				header("Accept-Ranges: bytes");
				header("Accept-Length: ".filesize($file_url));
				header("Content-Disposition: attachment; filename=".basename($file_url));
				
				$part_size = 10000000;      //ԼΪ10MB
				$part_num = ceil(filesize($file_url) / $part_size);
				
			
				
				for ($i = 0; $i < $part_num; $i++) {
				
					 fseek($file_handle, $part_size * $i, SEEK_SET);
					 echo fread($file_handle, 10000000);
				}
				fclose($file_handle);
			} else if(file_exists($file_url)) {                  //file Э��ʱ
				$file_handle = fopen($file_url, 'r');
				header("Content-Type: application/octet-stream");
				header("Accept-Ranges: bytes");
				header("Accept-Length: ".filesize($file_url));
				header("Content-Disposition: attachment; filename=".basename($file_url));
				$part_size = 10000000;      //ԼΪ10MB
				$part_num = ceil(filesize($file_url) / $part_size);
				
			
				
				for ($i = 0; $i < $part_num; $i++) {
				
					 fseek($file_handle, $part_size * $i, SEEK_SET);
					 echo fread($file_handle, 10000000);
				}
				fclose($file_handle);
				
			} else {
				header("Content-Type: text/html; charset=utf-8");
				echo "<p style='color:red'>�ļ���ַ����</p><br/>";
				echo "<a href='javascript:window.history.go(-1)'>����</a>";
			}
		}
		
			/*
	�ļ��ϴ�    $files : $_FILES ����
				$path :  Ĭ�� upload/
				$mode : 0 Ϊ�����ϴ� 1Ϊͬ������
				return : �����ļ���������
	*/
	public static function files_upload($files, $second_path='', $path='upload/', $mode=0 ) {
		 
		if (!empty($second_path)){
			$path .= $second_path . "/";
		}
		
		//echo $path;
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		$files_info = array();
		 
		foreach($files as $key => $value) {
			 
			if (is_array($value['name'])) {
				 
				for ($i = 0; $i < count($value['name']); $i++) {
					if ($i > 0) {
						$path_str .= '?';
					}
					 
					$value['name'][$i] = iconv('utf-8','gb2312',$value['name'][$i]);  //ת������ �����������
					$path_str = $path.$value['name'][$i];
					
					$files_info[$i]['name'] = $value['name'][$i];
					$files_info[$i]['type'] = $value['type'][$i];
					$files_info[$i]['size'] = $value['size'][$i];
					$files_info[$i]['path'] = $path_str;
					
					switch($mode) {
						case '0' : move_uploaded_file($value['tmp_name'][$i], $path.$value['name'][$i]);
								   
								   break;
						case '1' : if (!file_exists($path.$value['name'][$i])) {
									   move_uploaded_file($value['tmp_name'][$i], $path.$value['name'][$i]);
									   
									   break;
								   }
						default :  break;
					}
				}
				
			} else {
				
				$value['name'] = iconv('utf-8','gb2312',$value['name']);  //ת������ �����������
				$files_info[0] = $value;
				
				if ($value['error'] <=0 && $value['name']) {
					
					switch($mode) {
						case '0' : move_uploaded_file($value['tmp_name'], $path.$value['name']);
								   $path_str .= $path.$value['name'];
								   break;
						case '1' : if (!file_exists($path.$value['name'])) {
									   move_uploaded_file($value['tmp_name'], $path.$value['name']);
									   $path_str .= $path.$value['name'];
								   }
								   break;
						default  : break;
						
					}
				}
				$files_info[$value['name']]['path'] = $path_str;
			}				
			 
		}
		return $files_info;
	}
		
	}
?>