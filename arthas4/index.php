<?php
    /*
		for fun 4
		 入口文件
	*/
	
	define("ACCESS", true);
	  $redis = new Redis();
   $redis->connect('127.0.0.1', 6379);
    
	require("bootstrap.php");
	
	
	
	
?>