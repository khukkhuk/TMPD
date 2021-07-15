<?php
if(session_status()==PHP_SESSION_NONE){
	session_start();
}
require_once('class.db.php');
class sql {
	public function login($user,$pass){
		$db = new db();
		$txt = "TMPD_KMUTNB";
		$sql = "SELECT * FROM person ,position WHERE person.position = position.position_id AND username = '$user' AND password =md5('$pass$txt') AND user_status='activated' ";
		// $sql = "SELECT * FROM person ,position WHERE person.position = position.position_id AND username = '$user' AND password ='$pass' ";
		$result = $db->connectdb()->query($sql);
		return $result;
	}
	public function select($field,$table,$where){
		$db = new db();
		if($where==""){
			$sql = "SELECT $field FROM $table";
		}else{
			$sql = "SELECT $field FROM $table WHERE $where";
		}
		// echo $sql;
		$result = $db->connectdb()->query($sql);
		if(!$result){
			echo $sql;
		}return $result; 
	}

	public function insert($table,$field,$value){
		$db = new db();
		$sql = "INSERT INTO $table ($field) VALUES ($value)";
		$result = $db->connectdb()->query($sql);
		if(!$result){
			echo $sql;
		}return $result;
	}

	public function update($table,$value,$where){
		$db = new db();
		$sql = "UPDATE $table SET $value WHERE $where ";
		$result = $db->connectdb()->query($sql);
		if(!$result){
			echo $sql;
		}
		return $result;
	}

	public function delete($table,$where){
		$db = new db();
		$sql = "DELETE FROM $table WHERE $where";
		$result = $db->connectdb()->query($sql);
		if(!$result){
			echo $sql;
		}
		return $result;
	}

}
 ?>
