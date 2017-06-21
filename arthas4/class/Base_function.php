<?php
	/*
		基础函数类
	*/
	class Base_function{
		
		/**数据过滤函数
		*  &$data : 需要过滤的
		**/
		static function data_filter(&$data){
			if (is_string($data)) {
				$data = trim(htmlspecialchars($data));
				if (!get_magic_quotes_gpc()) {             //如果没有自动addslashes
					$data = addslashes($data);
				}
			} else if (is_array($data)) {
				foreach($data as $key => &$value) {
					self::data_filter($value);
				}
			}
		}
		
		/**
		* 数据还原函数
		* &$data : 过滤后需要还原的
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
		* 用时函数
		  $status : 开始时值写start ,结束时写end
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
		* 随机字符函数
		  $length : 字符长度
		*/
		static function random_char(&$str,$length) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			for ($i = 0; $i < $length; $i++) {
				$str .= $chars[rand(0, strlen($chars)-1)];
			}
			
		}
		 
	/*
		***
		* $now_page : 当前页数
		* $records  :  总记录数
		* $each_page_records :每页记录数
		* $page_list : 分页格子数 默认为5
	*/
		static function show_pagination($now_page, $records, $each_page_records, $page_list=5){
			$query_str = $_SERVER['QUERY_STRING'];     //获取到查询字符串
			$position = strpos($query_str, "page=");    //返回在查询串第一次出现的位置,0为开头
			switch($position){                           
				case 0:                                    //page为查询字符串的第一个参数时
					$first_separator = strpos($query_str,'&');// 找到第二个参数的位置
					if ($first_separator === false){        //如果只有page一个参数,则将查询字符串置为空
						$query_str = '';
					}else {						//若有多个参数则取后面的参数，过滤掉page参数 substr 0为开头
						$query_str = substr($query_str,$first_separator);
					}
					break;
				default:
					$next_separator = strpos($query_str, '&', $position);  
	 
					if ($next_separator === false){                    //page为查询字符串的最后一个参数时
						 $query_str = substr($query_str,0,$position-1);//过滤掉page参数
						 $query_str = '&'.$query_str;
						  
					}else {                                               //page参数为中间位置时                                            
						$head_part = substr($query_str,0,$position-1);    //取到page参数之前的部分
						$tail_part = substr($query_str, $next_separator);  //取到page参数之后的部分
						$query_str ='&'. $head_part.$tail_part;
						 
					}
					break;
			}
			$total_page = ceil($records/$each_page_records);  //总页数为记录数除以页容量
			$start_page = 1;                        //起始页默认为1
			if ($now_page > ceil($page_list/2)){   // 如果当前页大于分页格子的一半（向下取整） 
				$start_page = 1+$now_page-ceil($page_list/2);  //改变起始页格子
				 
			}
			//如果总页数大于 当前页格子数+list格子数  则结束格子数为其。  否则结束格子为最大页数
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
			$str.="<li><a href='javascript:void(0);'>共 $total_page  页</a>
			<a style='height:35px;'>
				<form  method='post' action='?'>
					<input type='text' name='jump_page' size='1' />
					<input type='submit' value='跳转'/>
				</form>
			</a></li></ul></nav>";
			
			echo $str;
		}
	}

?>