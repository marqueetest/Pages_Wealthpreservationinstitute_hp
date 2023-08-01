<?php

require_once("database.php"); 
require_once("header.php"); 

$bc_teste	=	$_POST["teste"];
$bc_padd	=	$_POST["padd"];

$frmID	=	$_GET["id"];

$action1 = isset($_POST["bc_form_action"]) ? $_POST["bc_form_action"] : "";

$action = "save";
$sucMessage = "";

$errors = array();

$err = '<table border="0" width="90%"><tr><td class="error" ><ul>';
for ($i=0;$i<count($errors); $i++) {
	$err .= '<li>' . $errors[$i] . '</li>';
}
$err .= '</ul></td></tr></table>';	

if (isset($_POST["submit"]) ) {

	if (!count($errors)) {

		 if ($action1 == "save") {
			$sql	=	"insert into teste (1,2) values ('" . $bc_teste . "','" . $bc_padd . "')";
			$res	=	mysqli_query($arrRES,$sql);
			$frmID = mysqli_insert_id($arrRES);
			if ($res) {
				$sucMessage = "Record Successfully inserted.";
			} else {
				$sucMessage = "Error: Please try Later";
			} // end if res
		} // end if
		
		if ($action1 == "edit") {
			$sql	=	"update teste set 1 = '" . $bc_teste . "', 2 = '" . $bc_padd . "' where id=$frmID";
			$res	=	mysqli_query($arrRES,$sql);
			if ($res) {
				$sucMessage = "Record Successfully updated.";
			} else {
				$sucMessage = "Error: Please try Later";
			} // end if res
		} // end if

	} // end if errors

	else {
		$sucMessage = $err;
	}
} // end if submit
$sql	=	"select * from teste where id=$frmID";
$res	=	mysqli_query($arrRES,$sql);
if ($res) {
	if ($row = mysqli_fetch_assoc($arrRES) ) {
		$bc_teste	=	$row["1"];
		$bc_padd	=	$row["2"];
	} // end if row
	$action = "edit";
} // end if 

?>
<form method="post" name="bc_form" enctype="multipart/form-data" action=""  >
<input type="hidden" name="bc_form_action" class="bc_input" value="<?php echo $action; ?>"/>
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
<tr class="bc_heading">
<td colspan="2" align="left" >tye</td>
 </tr>
<tr>
<td colspan="2" align="center" class="success" ><?php echo $sucMessage; ?></td>
</tr>
<tr>
<td align="right" class="bc_label">teste</td>
<td align="left" class="bc_input_td">
<input type="text" name="teste" id="teste" class="bc_input" value="<?php echo $bc_teste; ?>"/>
</td>
</tr>

<tr>
<td align="right" class="bc_label">pass</td>
<td align="left" class="bc_input_td">
<input type="text" name="padd" id="padd" class="bc_input" value="<?php echo $bc_padd; ?>"/>
</td>
</tr>

<tr>
<td>&nbsp;</td><td align="left">
<input name="submit" type="submit" value="Save" class="bc_button" />
</td>
</tr>
</table>
</form>

<?php 
require_once("footer.php"); 
?>