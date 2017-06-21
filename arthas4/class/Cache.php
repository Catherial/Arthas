<?php
/*
	Cache 类
		约定的缓存文件名为  控制器名_方法名.html
		
		控制器有改动则刷新缓存
*/
	class Cache {
		
		public static function execute ($controller_obj, $action) {
			$cache_path = MODULE_PATH . "/cache/";
			$cache_file = $cache_path  . CONTROLLER_NAME . "_" . ACTION_NAME. ".html";
			$controller_file = CONTROLLER_PATH . "/" . CONTROLLER_NAME . "Controller.php";
			if (!is_dir ($cache_path)) {
			
				echo "cache path not exist,please create cache folder";
				exit;
			}
			 
			if (file_exists ($cache_file) && filemtime ($cache_file) > filemtime ($controller_file)) {
				include ($cache_file);
				echo "this is cache";
			} else {
				ob_start ();
				$controller_obj -> $action();
				$cached = fopen ($cache_file, 'w');
				fwrite ($cached, ob_get_contents ());
				fclose ($cached);
				ob_end_flush ();
			}
			
		}
		/*
			写入缓存
			$name: 缓存名
			$value: 缓存内容
			$expire: 过期时间
			$path: 位置 
		
		public static set($name, $value, $expire=36000, $path=MODULE_PATH."/cache/") {
			$data = serialize($value);
			$data = "<?php\\n".$data."?>";
			$result = file_put_contents($path.$name, $data);
			if ($result) {
				return true;
			} else {
				return false;
			}
		}*/
		
	}
?>