<?php
require_once("database.php");

$d = $_REQUEST['id'] ;
if ( mysqli_query($Conn_db,"delete from  form_feilds where id = '".$d."' ") )
	echo '1' ;
else
	echo '0' ;

?>
