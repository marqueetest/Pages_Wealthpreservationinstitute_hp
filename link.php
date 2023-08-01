<?php


/************

Total width for image listing is 940 px;
every image have distance 20 px

so this is the image width calculation according to per images roll
 
if admin select 8 images per roll  then image width should be 100 px
if admin select 7 images per roll  then image width should be 117 px
if admin select 6 images per roll  then image width should be 140 px
if admin select 5 images per roll  then image width should be 172 px
if admin select 4 images per roll  then image width should be 220 px
if admin select 3 images per roll  then image width should be 300 px

*************/

require_once("database.php"); 
require_once("header.php"); 

$lightbox_id	=	$_POST['lightbox_id'];
$bc_title		=	$_POST['bc_title'];
$group_id		=	$_POST["group_id"];
$image_alt		=	$_POST["image_alt"];
$rolls			=	attribValue("link_groups" , "rolls" , "where id = '". $group_id ."'");

$bc_url	=	$_POST["url"];
$sql_img = '';
$frmID	=	$_GET["id"];

$imgPreWidths = array("3" => 300 , "4" => 220 , "5" => 172 , "6" => 140 , "7" => 117 , "8" => 100);


$html_js  = DBin($_POST["html_js"]);

$action1 = isset($_POST["bc_form_action"]) ? $_POST["bc_form_action"] : "";

$action = "save";
$sucMessage = "";

$errors = array();


if ( $_FILES["image"]["name"] != '') {
	list($w, $h, $type, $attr) = getimagesize($_FILES["image"]["tmp_name"]);
		if ($imgPreWidths[$rolls] != $w )
			$errors[] = 'Please set your link image width (' . $imgPreWidths[$rolls] . ' PX. )';
}

if($action1 == 'save' and $_FILES["image"]["name"] == '' and $html_js == '')
	$errors[] = 'Please upload image or Banner HTML/JS one is neccessary from both';
	
if($action1 == 'edit' and $_FILES["image"]["name"] == '' and $html_js == ''){
	$isimgExist = attribValue("links" , "image" , "where id = '". $frmID ."'");
	
	if($isimgExist == '')
		$errors[] = 'Please upload image or Banner HTML/JS one is neccessary from both';
	
}
	


$err = '<table border="0" width="90%"><tr><td class="error" ><ul>';
for ($i=0;$i<count($errors); $i++) {
	$err .= '<li>' . $errors[$i] . '</li>';
}
$err .= '</ul></td></tr></table>';	

if (isset($_POST["submit"]) ) {

	if (!count($errors)) {

	
		if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
			$bc_image  = time() . "_" . str_replace(" " , "-" , $_FILES["image"]["name"]) ;
			if ($action1 == "edit") {
					deleteImage($frmID,"links ","image");
			}
			move_uploaded_file($_FILES["image"]["tmp_name"], LINKS_IMAGES_PATH .$bc_image);
			makeThumbnail($bc_image, LINKS_IMAGES_PATH, '', 300, 250);
			$sql_img = " image = '$bc_image' , ";
		}
		
		if (isset($_FILES["big_image"]) && !empty($_FILES["big_image"]["tmp_name"])) {
			$bc_big_image  = time() . "_" . str_replace(" " , "-" , $_FILES["big_image"]["name"]) ;
			if ($action1 == "edit") {
					deleteImage($frmID,"links ","big_image");
			}
			move_uploaded_file($_FILES["big_image"]["tmp_name"], LINKS_IMAGES_PATH .$bc_big_image);
			//makeThumbnail($bc_big_image, LINKS_IMAGES_PATH, '', 300, 250);
			$sql_big_img = " big_image = '$bc_big_image' , ";
		}
		
		if ($action1 == "save") {
			$sql	=	"insert into links  (lightbox_id  , title , image , big_image ,group_id,url,html_js, image_alt) values ('". $lightbox_id ."' , '". $bc_title ."' , '" . $bc_image . "', '". $bc_big_image ."' ,'" . $group_id . "','" . $bc_url . "','". $html_js ."','". $image_alt ."')";
			$res	=	mysqli_query($Conn_db,$sql);
			$frmID = mysqli_insert_id($Conn_db);
			$aScript = 'http://'.$_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '?id='. $frmID;
			jsRedirect($aScript);
			if ($res) {
				$sucMessage = "Record Successfully inserted.";
			} else {
				$sucMessage = "Error: Please try Later";
			} // end if res
		} // end if
		
		if ($action1 == "edit") {
			$sql	=	"update links  set lightbox_id = '". $lightbox_id ."' , title = '". $bc_title ."' ,  " . $sql_img  . $sql_big_img ." group_id = '" . $group_id . "', url = '" . $bc_url . "',html_js='". $html_js ."',image_alt='". $image_alt ."' where id=$frmID";
			$res	=	mysqli_query($Conn_db,$sql);
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
$sql	=	"select * from links  where id=$frmID";
$res	=	mysqli_query($Conn_db,$sql);
if ($res) {
	if ($row = mysqli_fetch_assoc($res) ) {
		$lightbox_id	=	$row["lightbox_id"];
		$bc_title		=	$row["title"];
		$bc_image		=	$row["image"];
		$bc_big_image	=	$row["big_image"];
		$group_id		=	$row["group_id"];
		$bc_url			=	$row["url"];
		$html_js 		= DBout($row["html_js"]);
		$image_alt		=	$row["image_alt"];
	} // end if row
	$action = "edit";
} // end if 

?>
<script language="JavaScript" type="text/javascript" src="js/cal2.js"></script>
<form method="post" name="bc_form" enctype="multipart/form-data" action="">
<input type="hidden" name="bc_form_action" class="bc_input" value="<?php echo $action; ?>"/>
<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">

<tr class="bc_heading" >
<td colspan="2" align="left" >Links</td>
 </tr>
 <tr><td colspan="2" align="center" >&nbsp;</td></tr>

<?php if ($sucMessage) { ?>
<tr>
<td colspan="2" align="center" class="success" ><?php echo $sucMessage; ?></td>
</tr>
<?php } ?>

<tr>
<td align="right" class="bc_label">Link Title:</td>
<td align="left" class="bc_input_td">
<input type="text" name="bc_title" id="bc_title" class="bc_input" value="<?php echo $bc_title; ?>" style="width:350px;"/>
</td>
</tr>


<tr>
<td align="right" class="bc_label">Group:</td>
<td align="left" class="bc_input_td">
<select name="group_id"  style="width:150px;" >
<?php 
	$sql = "select * from link_groups ORDER BY name ASC";
	$res = mysqli_query($Conn_db,$sql);
	while($groups = mysqli_fetch_assoc($res)){
?>

	<option <?php if($groups["id"] == $group_id) {?> selected <?php } ?> value="<?php echo $groups["id"] ?>"><?php echo $groups["name"] ?></option>
<?php } ?>
</select>
</td>
</tr>


<tr>
<td align="right" class="bc_label">Image:</td>
<td align="left" class="bc_input_td">
<?php 
if( $bc_image != '' ) {
							echo '<img src="images/links/'.$bc_image .'" class="dynamicImg" id="delImg_image" width="75" height="76" />';
							$image_del = '<img src="images/remove_img.png" class="delImg" id="'.$frmID.'" style="cursor:pointer" rel="links|image|'.$bc_image.'|images/links/" />';
						}
						else
							echo '<img src="images/no_image.png" class="dynamicImg"width="75" height="76" />';
							
 ?>
<input type="file" name="image" id="image" /><br />
<?=$image_del?>
</td>
</tr>


<tr>
<td align="right" class="bc_label">Big Image:</td>
<td align="left" class="bc_input_td">
<?php 
if( $bc_big_image != '' ) {
							echo '<img src="images/links/'.$bc_big_image .'" class="dynamicImg" id="delImg_image" width="75" height="76" />';
							$big_image_del = '<img src="images/remove_img.png" class="delImg" id="'.$frmID.'" style="cursor:pointer" rel="links|big_image|'.$bc_big_image.'|images/links/" />';
						}
						else
							echo '<img src="images/no_image.png" class="dynamicImg"width="75" height="76" />';
							
 ?>
<input type="file" name="big_image" id="image" /><br />
<?=$big_image_del?>
</td>
</tr>

<tr>
<td align="right" class="bc_label">Alt. Text:</td>
<td align="left" class="bc_input_td">
<input type="text" name="image_alt" id="image_alt" class="bc_input" value="<?php echo $image_alt; ?>" style="width:350px;"/>
</td>
</tr>

<tr>
<td align="right" class="bc_label">URL:</td>
<td align="left" class="bc_input_td">
<input type="text" name="url" id="url" class="bc_input" value="<?php echo $bc_url; ?>"  style="width:350px;"/>
</td>
</tr>

<tr>
<td width="27%" align="right" class="bc_label">Lightbox Group (Optional):</td>
<td width="73%" align="left" class="bc_input_td">
<select name="lightbox_id" id="lightbox_id">
	<option value="">Select Lightbox</option>
	<?php 
		$sqllightboxgroup = "select * from seasonal_lightbox";
		$reslightboxgroup = mysqli_query($Conn_db,$sqllightboxgroup);
		while($lbs = mysqli_fetch_assoc($reslightboxgroup)){
	?>
    <option <?php if($lightbox_id == $lbs['id']) { ?> selected="selected" <?php } ?> value="<?php echo $lbs['id']; ?>"><?php echo $lbs['name']; ?></option>
    <?php }?>
</select>
</td>
</tr>
<tr>


<tr>
<td width="27%" align="right" class="bc_label" valign="top">
Banner HTML/JS:<br />
<font color="red">This HTML/JS will only be displayed when Image and  URL are empty. Please also note, this is HTML/JS so we don't have control on this. Please make sure the HTML/JS you are putting display the right size contents. <strong>Correct Content size is 300px X 250px. </strong>
</font></td>
<td width="73%" align="left" class="bc_input_td">
<textarea name="html_js" style="width:650px;height:200px;" id="descr"><?php echo $html_js; ?></textarea>
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
//require_once("footer.php"); 
?>

<script type="text/javascript" src="tinymce/tiny_mce.js"></script>
<script type="text/javascript">

$(".delImg").click(function() {
	var con = confirm("Are you sure you want to delete this image?");
	if( con == true ) {
		var imgID = $(this).attr('id');
		var imgInfo = $(this).attr('rel').split('|');
		$(this).load("deleteImg.php?id=" + imgID + "&tbl=" + imgInfo[0] + "&fld=" + imgInfo[1] + "&img=" + imgInfo[2] + "&dir=" + imgInfo[3] );
		$(this).hide();
		$("#delImg_" + imgInfo[1]).attr("src", "images/no_image.png");
	}
});

</script>