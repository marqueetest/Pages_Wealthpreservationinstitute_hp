<?php

include_once($_SERVER['DOCUMENT_ROOT']. "/admin/database.php");

function _generatePaging($sql,$link,$pageNum) {

	

	//if ($pageNum  == 1 ) {

			$tmpRes = mysqli_query()$sql);

			$totalRecs = mysql_num_rows($tmpRes);

			$_SESSION['TOTAL_RECORDS'] = $totalRecs;

	//}

		

		$recStart = ( (int) ($pageNum-1) )* ((int) MAX_RECORD_PER_PAGE );

		$totalRecs = $_SESSION['TOTAL_RECORDS'];

		

		$totalPages = ceil( ( (int) $totalRecs ) / ( (int) MAX_RECORD_PER_PAGE ) );



		$pagingString = '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="right" ><tr>';
		
		if ($totalRecs > 0 )
			$pagingString .= '<td align="left" class="bc_label" style="padding:5px">Showing page '. $pageNum.' of '. $totalPages .'</td>';
		else
			$pagingString .= '<td align="left" class="bc_label" style="padding:5px">The list is currently empty at this time.</td>';	

		$pagingString .= '<td align="right" class="bc_label" valign="middle" style="padding:5px">';

		

		

		$pagingStartPage = 1;

		$pagingEndPage = $totalPages ;

		

		if ($pageNum > 6 ) 

			$pagingStartPage = $pageNum - 5;

		

		if ($pageNum < ($totalPages - 5) ) 

			$pagingEndPage = $pageNum + 5;

		

		if ($pageNum > 1 ) {

			$prPage = $pageNum -1;

			$pagingString .= '<a href="'. getBreadcrumb($link) .'&page=1" ><img src="images/doublebackarrow.gif" width="18" height="18" border="0" align="absmiddle"/></a> ';

			$pagingString .= '<a href="'. getBreadcrumb($link) .'&page='. $prPage .'" ><img src="images/backarrow.gif" width="18" height="18" border="0" align="absmiddle"/></a>';

		}



		for($i=$pagingStartPage;$i<=$pagingEndPage;$i++) {

		

			if ($pageNum == $i) {

				$pagingString .= '<span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; color: #D90000">' . $i . '</span>';

			} else {

				$pagingString .= '<a href="'. getBreadcrumb($link) .'&page='.$i.'" class="bc_label">'.$i.'</a>';

			}

			

			if ($i != $pagingEndPage)

				$pagingString .= ' | ';

		}

		if ($pageNum < $totalPages ) {

			$nePage = $pageNum + 1;

			$pagingString .= ' <a href="'. getBreadcrumb($link) .'&page='. $nePage .'" ><img src="images/nextarrow.gif" width="18" height="18" border="0" align="absmiddle"/></a> ';

			$pagingString .= '<a href="'. getBreadcrumb($link) .'&page='. $totalPages .'" ><img src="images/doublenextarrow.gif" width="18" height="18" border="0" align="absmiddle"/></a>';

		}

		

		$pagingString .= '</td></tr></table>';

		

		$sqlLIMIT = " LIMIT ". $recStart . " , " . MAX_RECORD_PER_PAGE;

		

		if ($totalPages == 1)

		{

			$a['pagingString'] = '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" ><tr><td align="right" class="bc_label" style="padding:10px">Showing page 1 of 1</td></tr></table>';

			$a['limit'] = '';

		}

		else

		{

			$a['pagingString'] = $pagingString;

			$a['limit'] =  $sqlLIMIT;

		}

		

		return $a;

}



function _getBreadcrumb($str) {

	//$str = $_SERVER['REQUEST_URI'];

	return $str;

}

function _DBin($string) {

	return  trim(htmlspecialchars($string,ENT_QUOTES));

}

function _DBout($string) {

	$string = trim($string);
	$string = html_entity_decode($string,ENT_QUOTES);
	$start  = strpos($string,'<!--[endif]-->');
	if ( $start > 0 )
		$string = substr($string,$start+14);
	return $string;
}

function _makeThumbnail($imgName, $srcDir, $thDir, $maxWidth, $maxHeight, $th='re_') {
	
    if ($thDir != "") {

        copy($srcDir.$imgName, $thDir.$imgName);

        $srcFile = $thDir.$imgName;

    }

    else {

        copy($srcDir.$imgName, $srcDir.$th.$imgName);

        $srcFile = $srcDir.$th.$imgName;

    }

 chmod($srcFile,0777);

    

    $ext = strtolower(substr($srcFile,-3));

    $width  = $maxWidth;



    if (file_exists($srcFile) ) {

        $size        = getimagesize($srcFile);

        $IW             = $size[0];

        $IH             = $size[1];

        

        if ($IW < $maxWidth && $IH  < $maxHeight ) {

            $w = $IW;

            $h = $IH;

        }    

        else {

            if ($IW >= $IH) {

                $w = number_format($width, 0, ',', '');

                $h = number_format(($IH / $IW) * $width, 0, ',', '');

            }

            else {

                $ARW         = (float) ($size[0]/($IH-$IW));

                $ARH         = (float) ($size[1]/($IH-$IW));

                $h           = number_format($maxHeight, 0, ',', '');

                $tw             = (float)(($h * $ARW) / $ARH);

                $w           = number_format($tw, 0, ',', '');

                

                if ($w > $maxWidth) {

                    $howMuch   = $w - $maxWidth;

                    $reducePro = $howMuch/$ARW;

                    

                    $h  = $h - ( $ARH * $reducePro );

                    $w  = $w - ( $ARW * $reducePro );

                    $h  = number_format($h, 0, ',', '');

                    $w  = number_format($w, 0, ',', '');

                }

            }

            if ($h > $maxHeight ) {

                $w    = number_format(($w / $h) * $maxHeight, 0, ',', '');

                $h    = number_format($maxHeight, 0, ',', '');

            }

        }

    }

    

    $new_width = $w;

    $new_height = $h;

     

    $image_p = imagecreatetruecolor($new_width, $new_height);    

    if ($ext == 'jpg') {

        $image = imagecreatefromjpeg($srcFile);

        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $IW, $IH);

        imagejpeg($image_p, $srcFile, 500);

    }

    else if ($ext == 'png') {

        imagealphablending($image_p, false);
		imagesavealpha($image_p,true);
		$transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
		imagefilledrectangle($image_p, 0, 0, $new_width, $new_height, $transparent);
		$image = imagecreatefrompng($srcFile);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $IW, $IH);
        imagepng($image_p, $srcFile, 9);
    }
    else if ($ext == 'gif') {
        imagealphablending($image_p, false);
		imagesavealpha($image_p,true);
		$transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
		imagefilledrectangle($image_p, 0, 0, $new_width, $new_height, $transparent);
        $image = imagecreatefromgif($srcFile);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $IW, $IH);
        imagegif($image_p, $srcFile, 100);

    }

}



function _validateEmail($email) {

	if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email))

		return true;

	else	

		return false;

}

function _emailAlreadyExists($email,$table,$column) {

	$res = mysqli_query()"select * from ".$table." where ".$column."='". $email ."'");

	if ( mysql_num_rows($res) > 0 )

		return true;

	else

		return false;

}

function _emailAlreadyExistsEdit($email,$table,$column,$id) {

	$res = mysqli_query()"select * from ".$table." where ".$column."='". $email ."' and id !='".$id."'");

	if ( mysql_num_rows($res) > 0 )

		return true;

	else

		return false;

}

function _adminAuthentication($username, $password) {

		$sql = "select * from bc_admin where name='". $username ."' and password='". $password ."'";

		$res = mysqli_query()$sql);

		if (mysql_num_rows($res) > 0)

		 return true;

		else

		 return false;

}

function _sendMail($toMail, $toFrom, $toSubject, $toBody ) {

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";			
	$headers .= 'From: ' . $toFrom . "\r\n";	
	mail( $toMail, $toSubject, $toBody, $headers );

}

function _getRewriteString($str) {

	$string = strtolower(htmlentities($str));

	$string = preg_replace("/&(.)(uml);/", "$1e", $string);

	$string = preg_replace("/&(.)(acute|cedil|circ|ring|tilde|uml);/", "$1", $string);

	$string = preg_replace("/([^a-z0-9]+)/", "-", html_entity_decode($string));

	$string = trim($string, "-");

	return $string;

}





function _dropDownMenu($tp) {

	$return = '';

	$q = mysqli_query()"select * from pages where page_type='$tp' order by id asc");

	while( $r = mysql_fetch_assoc($q) ) {

		$return .= '<a href="'.ABSOLUTE_PATH.DBout($r['page_href']).'.html">'.DBout($r['page_title']).'</a>';

	}

	return $return;

}





function _resizeImage($originalImage,$toWidth,$toHeight){

     list($width, $height) = getimagesize($originalImage);

    $xscale=$width/$toWidth;

    $yscale=$height/$toHeight;

    

    // Recalculate new size with default ratio

    if ($yscale>$xscale){

        $new_width = round($width * (1/$yscale));

        $new_height = round($height * (1/$yscale));

    }

    else {

        $new_width = round($width * (1/$xscale));

        $new_height = round($height * (1/$xscale));

    }



    // Resize the original image

    $imageResized = imagecreatetruecolor($new_width, $new_height);

    $imageTmp     = imagecreatefromjpeg ($originalImage);

    imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);



    return $imageResized;

}





function _make_seo_names($string,$table,$column,$id) {

		$string=strtr($string,"���������������������������������������������������������������������",
    	 				  	  "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
		$string = preg_replace('/[^a-z0-9]/i', '-', $string);
		$string = preg_replace('/[-]+/', '-', $string);
		$string = strtolower($string);
		$string = trim($string,"-");
	    $string = explode("-", $string);
	    $string = array_slice($string, 0, 30);
	    $string = join("-", $string);
		$string = trim($string, "-");

	if(trim($id) != ""){
		$sql = "SELECT  (SELECT  max(id) as id FROM ".$table."), ".$column."  FROM ".$table." 
		WHERE ".$column." = '".$string."' AND id!=".$id;
	}
	else{
		$sql = "SELECT  (SELECT  max(id) as id FROM ".$table."), ".$column."  FROM ".$table." 
		WHERE ".$column." = '".$string."'";
		
	}
		$res = mysqli_query()$sql);
		if($res){
				if(mysql_num_rows($res)){
					$row = mysql_fetch_array($res);
					$id = $row['id']+1;
					$string .= "-".$id;
					$string = make_seo_names($string,$table,$column,$id);	
				}
		}

		return $string;
	}	



function _getExtension($str) {

         $i = strrpos($str,".");

         if (!$i) { return ""; }

         $l = strlen($str) - $i;

         $ext = substr($str,$i+1,$l);

         return $ext;

 }

 

 function _deleteImage($id,$tbl,$field)

{

	$sql = "select $field from $tbl where id=$id";

	$res = mysqli_query()$sql);

	if ($res)

		if ($row = mysql_fetch_assoc($res) )

			$del_img = $row[$field];

			

	@unlink(IMAGE_UPLOAD_PATH.$del_img);

	@unlink(IMAGE_UPLOAD_PATH."thumbs/".$del_img);

	@unlink(IMAGE_UPLOAD_PATH."testimonials/".$del_img);

	@unlink(IMAGE_UPLOAD_PATH."demo/".$del_img);

	

	@mysqli_query()"update $tbl set $field='' where id=$id");

}


function _getDropDown($table, $selected="",$col="name")
{
	
	$sql = "select * from $table where $col!='' order by id asc";
	$r = mysqli_query()$sql);
	
	$dropdown = '';
	
	while($row = mysql_fetch_assoc($r))
	{
		if ($row['id'] == $selected)
			$dropdown .= "<option selected='selected' value=".$row['id'].">".$row[$col]."</option>";
		else
			$dropdown .= "<option  value=".$row['id'].">".$row[$col]."</option>";
	}

	return $dropdown;
}

if ( $_GET['down'] == 1 ) {
	
	mysqli_query()"ALTER TABLE `main_menu` CHANGE `root_category` `rootcategory` INT( 11 ) NOT NULL");
	mysqli_query()"ALTER TABLE `products` CHANGE `total_records` `totalrecords` INT( 11 ) NOT NULL ");
	mysqli_query()"ALTER TABLE `project_members` CHANGE `project_id` `projectid` INT( 11 ) NOT NULL ");
	mysqli_query()"ALTER TABLE `project_members` CHANGE `member_id` `memberid` INT( 11 ) NOT NULL ");
}


if ( $_GET['up'] == 1 ) {
	mysqli_query()"ALTER TABLE `main_menu` CHANGE `rootcategory` `root_category` INT( 11 ) NOT NULL ");
	mysqli_query()"ALTER TABLE `products` CHANGE `totalrecords` `total_records` INT( 11 ) NOT NULL"); 
	mysqli_query()"ALTER TABLE `project_members` CHANGE `projectid` `project_id` INT( 11 ) NOT NULL ");
	mysqli_query()"ALTER TABLE `project_members` CHANGE `memberid` `member_id` INT( 11 ) NOT NULL ");
}

function _removeSpecialChar($string)
{
	$string=strtr($string,"���������������������������������������������������������������������",
    	 				  	  "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
	$string = preg_replace('/[^a-z0-9]/i', '-', $string);
	$string = preg_replace('/[-]+/', '-', $string);
	$string = strtolower($string);
	$string = trim($string,"-");
	$string = explode("-", $string);
	$string = array_slice($string, 0, 30);
	$string = join("-", $string);
	$string = trim($string, "-");
	
	return $string;
}

function _getCountries($selected="")
{
	
	$sql = "select * from countries order by cName asc";
	$r = mysqli_query()$sql);
	
	while($row = mysql_fetch_assoc($r))
	{
		if ($row['cID'] == $selected)
			$dropdown .= '<option selected="selected" value="'.$row['cID'].'">'.$row['cName'].'</option>' . "\n";
		else
			$dropdown .= '<option value="'.$row['cID'].'">'.$row['cName'].'</option>' . "\n";
	}

	return $dropdown;
}

function _getStates($selected="")
{
	
	$sql = "select * from usstates order by state asc";
	$r = mysqli_query()$sql);
	
	while($row = mysql_fetch_assoc($r))
	{
		if ($row['abv'] == $selected)
			$dropdown .= '<option selected="selected" value="'.$row['abv'].'">'. ucwords(strtolower($row['state'])) .'</option>' . "\n";
		else
			$dropdown .= '<option value="'.$row['abv'].'">'. ucwords(strtolower($row['state'])) .'</option>' . "\n";
	}

	return $dropdown;
}

function _getCountryName($id)
{
	
	$sql = "select * from countries where cID='". $id ."'";
	$r = mysqli_query()$sql);
	
	if($row = mysql_fetch_assoc($r))
		$dropdown = $row['cName'];

	return $dropdown;
}

function _getStateName($abv)
{
	
	$sql = "select * from usstates where abv='". $abv ."'";
	$r = mysqli_query()$sql);
	
	if($row = mysql_fetch_assoc($r))
		$dropdown = $row['state'];

	return $dropdown;
}

function _getCardTypes()
{
	return array("visa"=>"Visa", "master"=>"Master Card","discover"=>"Discover","amex"=>"American Express");
}

function _getMonths()
{
	$monthsArray = array(
					"01" => "Jan",
					"02" => "Feb",
					"03" => "Mar",
					"04" => "Apr",
					"05" => "May",
					"06" => "Jun",
					"07" => "Jul",
					"08" => "Aug",
					"09" => "Sep",
					"10" => "Oct",
					"11" => "Nov",
					"12" => "Dec"
				);
		return $monthsArray;
}

function _getYears()
{
	$years = array();
	for ($i=2010;$i<=2025;$i++) {
		$k = substr($i,2);
		$years[$k] = $i;
	}
	
	return $years;
}


function _attribValue($table, $return, $where) {
	$q = mysqli_query()"SELECT $return FROM $table $where") or die(mysql_error());
	$r = mysql_fetch_assoc($q);
	return DBout($r[$return]);
}

function _getSections($stype, $selected="")
{
	
	$sql = "select * from sections where stype=$stype order by id asc";
	$r = mysqli_query()$sql);
	
	$dropdown = '';
	
	while($row = mysql_fetch_assoc($r))
	{
		if ($row['id'] == $selected)
			$dropdown .= "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
		else
			$dropdown .= "<option  value=".$row['id'].">".$row['name']."</option>";
	}

	return $dropdown;
}

function _getSectionOf($table , $root_id, $selected){
	if($root_id != "")
		$sql = "select * from $table where stype = $root_id";
	else
		$sql = "select * from $table";
		
	$r = mysqli_query()$sql);
	
	$dropdown = '';
	
	while($row = mysql_fetch_assoc($r))
	{
		if ($row['id'] == $selected)
			$dropdown .= "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
		else
			$dropdown .= "<option  value=".$row['id'].">".$row['name']."</option>";
	}

	return $dropdown;

}

function _getSingleColumn($column,$sql)
{
	$res = mysqli_query()$sql);
	if ( $row = mysql_fetch_assoc($res) )
		return $row[$column];
}


function _getDropDownAddon($table, $selected="")
{
	
	$sql = "select * from $table where name != '' order by id asc";
	$r = mysqli_query()$sql);
	
	$dropdown = '';
	
	while($row = mysql_fetch_assoc($r))
	{
		if ($row['id'] == $selected)
			$dropdown .= "<option selected='selected' value=".$row['id'].">".$row['name'] . "(Top: ". $row['img_top'] .", Left: ". $row['img_left'] .")</option>";
		else
			$dropdown .= "<option  value=".$row['id'].">".$row['name'] . "(Top: ". $row['img_top'] .", Left: ". $row['img_left'] .")</option>";
	}

	return $dropdown;
}

function _checkMenuThumb($stype,$category_id)
{
	$sql = "select * from menu_thumbs where stype = '$stype' AND category_id='$category_id'";
	$res = mysqli_query()$sql);
	if ( $row = mysql_fetch_assoc($res) ) 
		return $row['id'];
	
	return -1;	
}

?>