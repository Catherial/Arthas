<?php
	/*
		����������
	*/
	class Base_function{
		
		/**���ݹ��˺���
		*  &$data : ��Ҫ���˵�
		**/
		static function data_filter(&$data){
			if (is_string($data)) {
				$data = trim(htmlspecialchars($data));
				if (!get_magic_quotes_gpc()) {             //���û���Զ�addslashes
					$data = addslashes($data);
				}
			} else if (is_array($data)) {
				foreach($data as $key => &$value) {
					self::data_filter($value);
				}
			}
		}
		
		/**
		* ���ݻ�ԭ����
		* &$data : ���˺���Ҫ��ԭ��
		**/
		static function data_restore(&$data){
			if (is_string($data)) {
				$data = stripslashes($data);
			} else if (is_array($data)) {
				for ($i = 0; $i < count($data); $i++) {
					self:data_restore($data[$i]);
				}
					 
			}
		}
		/*
		* ��ʱ����
		  $status : ��ʼʱֵдstart ,����ʱдend
		*/
		static function use_time($status) {
			static $arr = array();
			if ($status == 'start') {
				$arr['start'] = microtime(true);
			} else if ($status == 'end') {
				echo "<p>runtime:".round(microtime(true)-$arr['start'],6).",memory_useage:".memory_get_usage()/1000 ."kb</p>";
			}
		}
		
		/*
		* ����ַ�����
		  $length : �ַ�����
		*/
		static function random_char(&$str,$length) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			for ($i = 0; $i < $length; $i++) {
				$str .= $chars[rand(0, strlen($chars)-1)];
			}
			
		}
		 
	/*
		***
		* $now_page : ��ǰҳ��
		* $records  :  �ܼ�¼��
		* $each_page_records :ÿҳ��¼��
		* $page_list : ��ҳ������ Ĭ��Ϊ5
	*/
		static function show_pagination($now_page, $records, $each_page_records, $page_list=5){
			$query_str = $_SERVER['QUERY_STRING'];     //��ȡ����ѯ�ַ���
			$position = strpos($query_str, "page=");    //�����ڲ�ѯ����һ�γ��ֵ�λ��,0Ϊ��ͷ
			switch($position){                           
				case 0:                                    //pageΪ��ѯ�ַ����ĵ�һ������ʱ
					$first_separator = strpos($query_str,'&');// �ҵ��ڶ���������λ��
					if ($first_separator === false){        //���ֻ��pageһ������,�򽫲�ѯ�ַ�����Ϊ��
						$query_str = '';
					}else {						//���ж��������ȡ����Ĳ��������˵�page���� substr 0Ϊ��ͷ
						$query_str = substr($query_str,$first_separator);
					}
					break;
				default:
					$next_separator = strpos($query_str, '&', $position);  
	 
					if ($next_separator === false){                    //pageΪ��ѯ�ַ��������һ������ʱ
						 $query_str = substr($query_str,0,$position-1);//���˵�page����
						 $query_str = '&'.$query_str;
						  
					}else {                                               //page����Ϊ�м�λ��ʱ                                            
						$head_part = substr($query_str,0,$position-1);    //ȡ��page����֮ǰ�Ĳ���
						$tail_part = substr($query_str, $next_separator);  //ȡ��page����֮��Ĳ���
						$query_str ='&'. $head_part.$tail_part;
						 
					}
					break;
			}
			$total_page = ceil($records/$each_page_records);  //��ҳ��Ϊ��¼������ҳ����
			$start_page = 1;                        //��ʼҳĬ��Ϊ1
			if ($now_page > ceil($page_list/2)){   // �����ǰҳ���ڷ�ҳ���ӵ�һ�루����ȡ���� 
				$start_page = 1+$now_page-ceil($page_list/2);  //�ı���ʼҳ����
				 
			}
			//�����ҳ������ ��ǰҳ������+list������  �����������Ϊ�䡣  �����������Ϊ���ҳ��
			$end_page = ($start_page + $page_list <= $total_page)?$start_page+$page_list:$total_page;
			 
			
			$str = "<nav><ul class='pagination'>";
			if ($now_page > 1) {
				$str.="<li ><a href='?page=".($now_page-1).$query_str."'>&laquo;</a></li>";
			}	
			for($i = $start_page; $i <= $end_page; $i++){
				if($i == $now_page){
					$str.="<li class='active'><a href='?page=".$i.$query_str."'>$i</a></li>";
				}else{
					$str.="<li><a href='?page=".$i.$query_str."'>$i</a></li>";
				}
			}
			if ($now_page < $end_page){
				$str.="<li><a href='?page=".($now_page+1).$query_str."'>&raquo;</a></li>";
			}
			$str.="<li><a href='javascript:void(0);'>�� $total_page  ҳ</a>
			<a style='height:35px;'>
				<form  method='post' action='?'>
					<input type='text' name='jump_page' size='1' />
					<input type='submit' value='��ת'/>
				</form>
			</a></li></ul></nav>";
			
			echo $str;
		}
	}

?>