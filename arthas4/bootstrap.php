<?php
	
	/*
		公共入口文件...
		
	*/
	
	//防止被直接访问
	defined ("ACCESS") or die ("access error");
	

	
	/*
		获取到pathinfo
	*/
	$pathinfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "";
	$path_arr = explode('/', $pathinfo);
	

	/*
	    获取模块,控制器,方法名
	*/
	
	define ("MODULE_NAME", isset($path_arr[1]) && $path_arr[1] ? $path_arr[1] : "index");
	define ("CONTROLLER_NAME", isset($path_arr[2]) && $path_arr[2] ? $path_arr[2] : "index");
	define ("ACTION_NAME", isset($path_arr[3]) && $path_arr[3] ? $path_arr[3] : "index");
	
	/*
	    将pathinfo中参数给予$_GET
	*/
	for ($i = 4; $i < count($path_arr); $i+=2) {

		$_GET[$path_arr[$i]] = isset($path_arr[$i+1]) ? $path_arr[$i+1] : "";
		
	}
	
	
	/*
	   过滤参数
	*/
	foreach ($_GET as $key => &$value) {
		if (is_string($value))
			$value = addslashes (htmlspecialchars($value));
	}
	
	foreach ($_POST as $key => &$value) {
		if (is_string($value))
			$value = addslashes (htmlspecialchars($value));
	}
	
	foreach ($_REQUEST as $key => &$value) {
		if (is_string($value))
			$value = addslashes (htmlspecialchars($value));
	}
	
	
	
	
	/*
		获取路径
	*/
	define ("BASE_PATH", dirname (__FILE__));
	define ("CLASS_PATH", BASE_PATH . "/class");
	define ("MODULE_PATH", BASE_PATH . "/module/" . MODULE_NAME);
	define ("CONTROLLER_PATH", MODULE_PATH . "/controller");
	define ("MODEL_PATH", MODULE_PATH . "/model");
	define ("VIEW_PATH", MODULE_PATH . "/view/" . CONTROLLER_NAME );
	
	
	/* for test*/
	define ("HTTP_MODULE_PATH", "http://localhost/Arthas4/module/" . MODULE_NAME);
	
	
	/*
		初始化
	*/
	require_once (BASE_PATH . "/function/init.php");
	require_once (BASE_PATH . "/config/cache_config.php");
	require_once (BASE_PATH . "/config/db_config.php");
	spl_autoload_register ('autoload');
	
	/*
		初始判断
	*/
	$controller = CONTROLLER_NAME . "Controller";
	$action = ACTION_NAME;
	if (!is_dir (MODULE_PATH)) {            //判断模块目录是否存在
		echo "module not exist!";
		exit;
	}
	if (!class_exists ($controller)) {          //判断控制器是否存在
		echo "controller  $controller not exist!";
		exit;
	}
	if (!preg_match ('/^[a-zA-z_]\w*$/', $action)) {   //判断方法是否非法
		echo "method illegal!";
		exit;
	}
	
	
	$controller_obj = new $controller(); //实例化一个控制器类对象
	
	if (!method_exists ($controller_obj, $action)) {      //判断控制器中是否存在该方法
		echo "$action method not exist";
		exit;
	}
	
	$method_test = new ReflectionMethod($controller_obj, $action); //创建一个方法反射对象
	
	if (!$method_test -> isPublic() || $method_test -> isStatic()) { //判断方法是否public 且不为static
		echo "$action method is not public";
		exit;
	}
	

	/*
		开启session
	*/
	
	@session_start();
	
	/* 
		设置默认时区
	*/
	date_default_timezone_set("PRC");
	
	
	/*
		执行方法
	*/
	if (!CACHE_ENABLE || !isset ($cache_arr[MODULE_NAME][CONTROLLER_NAME][ACTION_NAME])) {
		$controller_obj -> $action();
	} else {
		Cache::execute($controller_obj, $action);
	}
	
	
	
	
?>