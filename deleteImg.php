<?	
require_once("database.php");
$id		= $_GET['id'];
$tbl	= $_GET['tbl'];
$fld	= $_GET['fld'];
$img	= $_GET['img'];
$dir	= $_GET['dir'];

//echo "update $tbl set $fld='' where id='$id' limit 1";
if( $tbl == 'homes_images' ||  $tbl == 'seasonal_images' )
	mysqli_query($Conn_db,"delete from $tbl where id='$id' limit 1");
else
	mysqli_query($Conn_db,"update $tbl set $fld='' where id='$id' limit 1");
	

unlink($dir . $img);
unlink($dir . "th_" . $img);
unlink($dir . "ico_" . $img);
unlink($dir . "sub_" . $img);


?>