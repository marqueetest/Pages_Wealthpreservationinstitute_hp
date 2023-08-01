<?php
// header('Location: http://heaplan.com/advisors_a/admin/');
// exit();


@session_start();



if ( !isset($_SESSION['admin_user']) || $_SESSION['admin_user'] == '' ) {



	header('Location: login.php');



	exit;



}



?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Admin Panel :: Pages</title>



<link rel="stylesheet" href="css/admin.css" type="text/css" media="print, projection, screen" />

<link rel="stylesheet" href="<?php echo ABSOLUTE_PATH;?>admin/tinymce/plugins/inlinepopups/skins/clearlooks2/window.css" type="text/css" media="print, projection, screen" />



<script type="text/javascript" src="js/jquery.min.js"></script> 



<script type="text/javascript" src="js/jquery.table.js"></script> 



<script type="text/javascript" src="js/jquery.metadata.js"></script>





<script type="text/javascript" src="js/colorpicker.js"></script>

<script type="text/javascript" src="js/eye.js"></script>

<script type="text/javascript" src="js/utils.js"></script>

<script type="text/javascript" src="js/layout.js?ver=1.0.2"></script>

<link rel="stylesheet" href="css/colorpicker.css" type="text/css" />

	

	<!--data picker --> 

<style type="text/css">

@import "js/date_picker/jquery.datepick.css";

#logo{ 

	font-size: 28px;

    color: #FFF;

    padding-left: 10px;

    font-weight: normal;

}

</style>  

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->

<script type="text/javascript" src="<?php echo ABSOLUTE_PATH;?>js/jquery-1.4.min.js"></script>

<script type="text/javascript" src="js/date_picker/jquery.datepick.js"></script>

<script type="text/javascript">



$(function() {

	$('#expiration_date').datepick();

	$('#valid_from').datepick();

	

});



function MM_swapImgRestore() { //v3.0

  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;

}



function MM_preloadImages() { //v3.0

  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();

    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)

    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}

}



function MM_findObj(n, d) { //v4.01

  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {

    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}

  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];

  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);

  if(!x && d.getElementById) x=d.getElementById(n); return x;

}



function MM_swapImage() { //v3.0

  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)

   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}

}

//-->

</script>

<!--data picker --> 





<script>



function showButtonpreview(val)

{

	

	$.ajax({  

	   

			type: "POST",  

			url: "button_preview.php",  

			data:"id="+val,



			beforeSend: function()

			{

				

			},

			success: function(resp)

			{  

				$("#button_preview").html(resp);

			}, 



			complete: function()

			{

				//$("#login_error").html('');

			},

 

			error: function(e)

			{  

				//alert('Error: ' + e);  

			}  

	});

	

	

}



</script>

  

</head>



<body onload="MM_preloadImages('images/signout_new_over.png')">

<div id="main">

<table cellpadding="0" cellspacing="0" align="center" id="tbl">



	<tr>



    	<td>



        	<table cellpadding="0" cellspacing="0" width="100%" align="center" style="padding:0px;">

                <tr>



                	<td colspan="2" height="90" style="background-color:#115d8d">



                	<table width="100%" cellpadding="0" cellspacing="0">



                    	<tr>



                        	<td id="logo">Pages Admin Control<!--<img src="<?=ADMIN_LOGO?>" align="absmiddle" alt="Logo" />--></td>



		                    <td id="loggedin">

								<a style="color:#FFF;" href="#">Welcome <?=$_SESSION['admin_user']?></a><br />

								<a href="ProcPass.php?action=logout" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','images/signout_new_over.png',1)"><img src="images/signout_new.png" name="Image3" width="91" height="34" border="0" id="Image3" /></a></td>



                        </tr>



                    </table>



                    </td>



                </tr>



                <tr><td colspan="2" height="10"></td></tr>



                <tr valign="top">



                    <td width="200" style="padding:0px 10px; background-image:url(images/menu_bg_new.png); background-repeat:repeat-y"><?php require_once("menu.php"); ?></td>



<td height="400" style="padding-right:10px;">

