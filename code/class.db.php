<?php

class db{
	public function connectdb(){
		if( file_exists("config.php") )
		{
			$database = include("config.php");	
		}else{
			$database = include("../config.php");	
		} 
		if($database['pass']==""){
			$conn = new mysqli($database['host'],$database['user'],'',$database['name']);
		}else{
			$conn = new mysqli($database['host'],$database['user'],$database['pass'],$database['name']);
		} 
		$conn->set_charset("utf8");
		return $conn; 
	}

}
 ?>
