<?php
require_once("database.php");
	$id 		= $_GET['id'];
	$table 		= $_GET['table'];
	$link  		= $_GET['link'];
	$field_name = $_GET["field_name"];
	$adviser_id = (int)$_GET['advisor_id'];

	
	//echo "delete from $table where `id` ='$id' limit 1";
	
	
	if($table==='advisers'){
				mysqli_query($Conn_db,"delete from $table where `id`='$id' limit 1");
				if (mysqli_affected_rows($Conn_db) > 0) {
					$adviser_id 	= (int)$id;
					mysqli_query($Conn_db,"DELETE FROM survey_response WHERE userid IN (SELECT userid  FROM account WHERE adviser_id = '".$adviser_id."') ");
					mysqli_query($Conn_db,"DELETE FROM userpdf WHERE userid IN (SELECT userid  FROM account WHERE adviser_id = '".$adviser_id."') ");
    				mysqli_query($Conn_db,"DELETE FROM account WHERE adviser_id = '".$adviser_id."' ");
				}
	
	}elseif($table==='account'){
				$userid 		= (int)$id;
				mysqli_query($Conn_db,"DELETE FROM account WHERE userid = '".$userid."'");
				if (mysqli_affected_rows($Conn_db) > 0) {
					mysqli_query($Conn_db,"DELETE FROM survey_response WHERE userid = '".$userid."'");
					mysqli_query($Conn_db,"DELETE FROM userpdf WHERE  userid = '".$userid."'");
				}
    }else{
		mysqli_query($Conn_db,"delete from $table where `id`='$id' limit 1");
	}
	echo '<script>window.location.href="'.  $_SERVER['HTTP_REFERER'] .'&msg=Successfully+deleted";</script>';

?>