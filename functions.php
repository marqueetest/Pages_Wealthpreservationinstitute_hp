<?php

function adminAuthentication($username, $password){
		global $Conn_db;
		$sql = "select * from bc_admin where name='". $username ."' and password='". $password ."'";
		$res = mysqli_query($Conn_db,$sql);
		if (mysqli_num_rows($res) > 0)
		 return true;
		else
		 return false;
}

function generatePaging($sql,$link,$pageNum)
{
		global $Conn_db;
		
		$tmpRes = mysqli_query($Conn_db,$sql);
		$totalRecs = mysqli_num_rows($tmpRes) ;
		$_SESSION['TOTAL_RECORDS'] = $totalRecs;
		
		$recStart = ( (int) ($pageNum-1) )* ((int) MAX_RECORD_PER_PAGE );
		$totalRecs = $_SESSION['TOTAL_RECORDS'];
		
		$totalPages = ceil( ( (int) $totalRecs ) / ( (int) MAX_RECORD_PER_PAGE ) );

		$pagingString = '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="right" ><tr>';
		$pagingString .= '<td align="left" class="bc_label" style="padding:5px">Showing page '. $pageNum.' of '. $totalPages .'</td>';
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
			$a['pagingString'] = '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" ><tr><td align="left" class="bc_label" style="padding:5px">Showing page 1 of 1</td></tr></table>';
			$a['limit'] = '';
		}
		else
		{
			$a['pagingString'] = $pagingString;
			$a['limit'] =  $sqlLIMIT;
		}
		
		return $a;
}

function getBreadcrumb($str)
{
	//$str = $_SERVER['REQUEST_URI'];
	return $str;
}

function showImage($id,$tbl,$field)
{
	global $Conn_db;
	$show_img = '';
	$sql = "select $field from $tbl where id=$id";
	$res = mysqli_query($Conn_db,$sql);
	if ($res)
		if ($row = mysqli_fetch_assoc($res) )
			$show_img = $row[$field];
	if ($show_img != "" ) {
				
		$show_img = '<div style="margin: 5px;">
					<strong>'. substr($show_img,11) .'</strong>
					<!--<a href="'. $_SERVER['REQUEST_URI'] .'&delete=' . $field . '">
						<img src="'. ABSOLUTE_PATH  .'images/cross.jpg" title="Remove Image" align="top" border="0">
					</a>--> 
					</div>';
		
	}	
	return $show_img;	
}

function deleteImage($id,$tbl,$field)
{
	global $Conn_db;
	$sql = "select $field from $tbl where id=$id";
	$res = mysqli_query($Conn_db,$sql);
	if ($res)
		if ($row = mysqli_fetch_assoc($res) )
			$del_img = $row[$field];
			
	@unlink(IMAGE_UPLOAD_PATH.$del_img);
	@unlink(IMAGE_UPLOAD_PATH."thumbs/".$del_img);
	
	@mysqli_query($Conn_db,"update $tbl set $field='' where id=$id");
}

function DBin($string)
{
	return  trim(htmlspecialchars($string,ENT_QUOTES));
}

function DBout($string)
{
	$string = trim($string);
	$string = html_entity_decode($string);
	$string = str_replace("<p?&nbsp;</p>","<br><br>",$string);
	$string = str_replace("�"," ",$string);

	
	return utf8_encode($string);
}

function validateEmail($email)
{
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
		return true;
	else	
		return false;
}

function emailAlreadyExists($email)
{
	global $Conn_db;
	$res = mysqli_query($Conn_db,"select * from customers where email='". $email ."'");
	if ( mysqli_num_rows($res) > 0 )
		return true;
	else
		return false;
}

function makeThumbnail($imgName, $srcDir, $thDir, $maxWidth, $maxHeight) {
    
    if ($thDir != "") {
        copy($srcDir.$imgName, $thDir.$imgName);
        $srcFile = $thDir.$imgName;
    }
    else {
        copy($srcDir.$imgName, $srcDir.'th_'.$imgName);
        $srcFile = $srcDir.'th_'.$imgName;
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
        $image = imagecreatefrompng($srcFile);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $IW, $IH);
        imagepng($image_p, $srcFile, 9);
    }
    else if ($ext == 'gif') {
        
        $image = imagecreatefromgif($srcFile);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $IW, $IH);
        imagegif($image_p, $srcFile, 100);
    }
}


function attribValue($table, $return, $where) {
	global $Conn_db;
	$q = mysqli_query($Conn_db,"SELECT $return FROM $table $where") or die(mysqli_error());
	$r = mysqli_fetch_assoc($q);
	return DBout($r[$return]);
}


function getSingleColumn($column,$sql)
{
	global $Conn_db;
	$res = mysqli_query($Conn_db,$sql);
	if ( $row = mysqli_fetch_assoc($res) )
		return $row[$column];
}
function tep_encrypt($data){
    $output = '';
    if($data!=''){
		$encrypt_method = "AES-256-CBC";
		$secret_key 	= 'HEAPLANGG101GGADVISOR';
		$secret_iv  	= 'AVISOR801AS';
		// hash
		$key = hash('sha512', $secret_key);
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha512', $secret_iv), 0, 16);
		$output = openssl_encrypt($data, $encrypt_method, $key, 0, $iv);
		return $output = base64_encode($output);
	}else
		return '';

}
 function tep_decrypt($data){
   $output = '';
    if($data!=''){
		$encrypt_method = "AES-256-CBC";
		$secret_key 	= 'HEAPLANGG101GGADVISOR';
		$secret_iv  	= 'AVISOR801AS';
		// hash
		$key = hash('sha512', $secret_key);
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha512', $secret_iv), 0, 16);
		return $output = trim(openssl_decrypt(base64_decode($data), $encrypt_method, $key, 0, $iv));
	}else
		return '';
 }
?>