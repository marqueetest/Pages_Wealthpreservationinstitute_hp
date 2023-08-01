<?php
ini_set('display_errors', 0);
ob_start();
require_once("database.php"); 
require_once("header.php");

//echo date("h:i:s A");

if($_GET['link']!='' && $_GET['id']!='' && $_GET['table']=='account'){
	if($_GET["action_account"]=="enable")
		 mysqli_query($Conn_db,"Update account set `disabled`='NULL' where userid = '".$_GET['id']."'");
	elseif($_GET["action_account"]=="disable")
		mysqli_query($Conn_db,"Update account set `disabled`='1' where userid = '".$_GET['id']."'");

 header("Location:".$_SERVER['HTTP_REFERER']);

}

if ( $_SESSION['PREVIOUS_OPEN_LINK'] != $_GET['link'] ) {
	$_SESSION['SORT_DIRECTION'] = '';
	$_SESSION['ORDER_BY'] = '';
	$_SESSION['SEARCH_FIELD'] = '';
	$_SESSION['SEARCH_TERM'] = '';
}

$max_records_per_page=0;
$link 		= $_GET['link'];
$sucMessage = $_GET['msg'];
$pNum = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = ' limit 0 , ' . $max_records_per_page;
$page   			= $pages[$link]['page'];
$table  			= $pages[$link]['table'];
$filter 			= $pages[$link]['filter'];
$delete 			= $pages[$link]['delete'];
$addBtn 			= $pages[$link]['add'];
$title  			= $pages[$link]['title'];
$default_order		= $pages[$link]['default_orderby_column'];
$show   			= $pages[$link]['show'];
$add_new_button 	= $pages[$link]['add_new_button'];
$searchFieldsList 	= $pages[$link]['searchFieldsList'];
$orderFieldsList 	= $pages[$link]['orderFieldsList'];
$customSQL 			= $pages[$link]['customSQL'];
$group_by 			= $pages[$link]['group_by'];
$add_sort 			= $pages[$link]['add_sort_button'];
$edit 				= $pages[$link]['edit']; // work for value "no"
$viewpage 			= $pages[$link]['viewpage'];
$mysales 			= $pages[$link]['mysales'];
$bulk_delete		= $pages[$link]['bulk_delete']; // work for value "yes"
$images				= $pages[$link]['images']; // only for make images links in home listing
$can_not_delete_ids = $pages[$link]['can_not_delete_ids'];
$sort_button_title	= $pages[$link]['sort_button_title'];

if ( !is_array($can_not_delete_ids) )
	$can_not_delete_ids = array();

if ( isset($_POST['btnDelete']) ) {
	$tmp_ids = $_POST['delid'];
	$del_ids = implode(",",$tmp_ids);

	$qry = "delete from " . $table . " where id IN (". $del_ids .")";
	@mysqli_query($Conn_db,$qry);
}



$orderBy = '';



$eFilter = '';



if ($_SESSION['SORT_DIRECTION'] == '' )

	$_SESSION['SORT_DIRECTION'] = ' DESC ';



if ($_GET['direction'] != '' ) {

	if ($_GET['direction'] == 'asc')

		$_SESSION['SORT_DIRECTION'] = ' ASC ';

	else

		$_SESSION['SORT_DIRECTION'] = ' DESC ';	

}




$_SESSION['ORDER_BY'] = $default_order;



if ($_GET['order'] != '') 

	$_SESSION['ORDER_BY'] =  $_GET['order'];





if ($_SESSION['ORDER_BY'] != '' )

	$orderBy = ' ORDER BY ' . $_SESSION['ORDER_BY'] . $_SESSION['SORT_DIRECTION'];







if ($_GET['search'] != '' && $_GET['term'] != '') {



	$_SESSION['SEARCH_FIELD'] =  $_GET['search'];

	$_SESSION['SEARCH_TERM']  =  $_GET['term'];



} else {



	$_SESSION['SEARCH_FIELD'] =  '';

	$_SESSION['SEARCH_TERM']  =  '';



}





if ($_SESSION['SEARCH_FIELD'] != '' && $_SESSION['SEARCH_TERM'] != '' ) {



	$eFilter = '';



	if ($_SESSION['SEARCH_FIELD'] == 'all' ) {



		 $res1 = mysqli_query($Conn_db,"DESC $table"); 

		 while ($row = mysqli_fetch_assoc($res1) ) 

		 	$eFilter .= $row['Field'] . " LIKE '%". $_SESSION['SEARCH_TERM'] ."%' OR ";



		 $eFilter = substr($eFilter,0,-3);



	} else {

		$eFilter = $_SESSION['SEARCH_FIELD'] . " LIKE '%". $_SESSION['SEARCH_TERM'] ."%'";

	}



} else {

	$eFilter = '';

}



if ($filter != "") {



	$filter = " where " . $filter ;

	if ($eFilter != "")

		$filter = $filter . ' AND ('. $eFilter .')';

} else {

	if ($eFilter != "")

		$filter = " where " . $eFilter;

}



$group_by_sql = '';

if ($group_by != '')

	$group_by_sql = ' GROUP BY ' . $group_by . ' ';

	

if ($customSQL == '' ) 

 	$sql = "select * from " . $table . $filter  . $group_by_sql . $orderBy;

else

	$sql = $customSQL  . $filter  . $orderBy;



$paging = array();

$adviosr_link  = '';
if($_GET["advisor_id"]>0)
	$adviosr_link = "&advisor_id=".$_GET["advisor_id"];
	
$link1 = 'list.php?link=' .$link.$adviosr_link ;

$paging = generatePaging($sql,$link1,$pNum,$max_records_per_page);



$sql = $sql . $paging['limit'];



$res = mysqli_query($Conn_db,$sql);





?>





<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr class="bc_heading">
	
    <td width="65%"><?php echo $title; ?> <?php if($_GET["advisor_id"]>0 && $table==='account'){ echo " of ".ucwords(getSingleColumn("advisor_name","SELECT CONCAT(first_name,' ',last_name) as advisor_name from advisers where id = '".$_GET["advisor_id"]."'"));}?></td>

	<td width="35%" style="font-size:12px;background-position:right;" align="right">

	&nbsp;

	<?php

		if (count($orderFieldsList) > 0 ) {

	?>

	Order By: &nbsp;

	<select name="field" id="field" style="width:100px" onchange="setOder(this.value)">

      <?php

	  foreach ($orderFieldsList as $key => $value) {

	  	$sel = '';

		if ( $value == $_SESSION['ORDER_BY'])

			$sel = ' selected="selected" ';



	  	echo '<option value="'. $value .'" '. $sel .'>' . $key . '</option>';

	  }

	?>

    </select>&nbsp;

	

	<?php

		if ( $_SESSION['SORT_DIRECTION'] == ' ASC ' ) {

			$dirc = 'desc';

			$dimg = 'asc1.gif';

			$txt  = ' Descending ';

		} else {

			$dirc = 'asc';

			$dimg = 'desc1.gif';

			$txt  = ' Ascending ';

			

		}	

	?>

	<a style="color:#FFFFFF; text-decoration:none" href="list.php?link=<?=$link?>&direction=<?=$dirc?>"><?=$txt?><img src="images/<?=$dimg?>" width="21" height="15" border="0" align="absmiddle" /></a>

	

	<?php } ?>

	&nbsp;

	</td>

  </tr>

  

  <tr>

    <td height="25" colspan="2" bgcolor="#efe9db" align="center">

	<table border="0" cellspacing="0" cellpadding="5" width="100%">

  	<tr>

	<td align="center" style="height:36px;">

    

	<?php

	  	if (count($searchFieldsList) > 0 ) {

	?>

    	<strong>Search For: </strong>

        <input type="text" name="term" id="term" style="width:250px" value="<?php echo $_SESSION['SEARCH_TERM']; ?>" />

      	<strong> &nbsp; &nbsp; &nbsp; In: &nbsp; </strong>

        <select name="field" id="src_field" style="width:120px">

      <option value="all">All</option>

      <?php

	  foreach ($searchFieldsList as $key => $value) {

	 	$sel = '';

		if ( $value == $_SESSION['SEARCH_FIELD'])

			$sel = ' selected="selected" ';



	  		echo '<option value="'. $value .'" '. $sel .'>' . $key . '</option>';

	  }

	?>

    </select> &nbsp;

    <img src="images/search.png" onclick="setSearch()" align="absbottom" style="cursor:pointer;" />

    

	<?php } ?>

    <?php if ( $addBtn != 'no' )  {  ?>

  			<input value="<?=$add_new_button?>" type="button" onclick="document.location.href='<?php echo $page; ?>'" class="addBtn" />

  		<?php  }  ?>
   <?php if($table=='advisers') {?>
    <a href="<?php echo ABSOLUTE_PATH; ?>exportReport.php?export_data=advisers">Export Advisers CSV</a>
    <?php }?>

        <?php 
			if( $add_sort )  {  
			
			$tit1 = 'Sort ' . $title;
			
			if ( $sort_button_title != '' )
				$tit1 = $sort_button_title;
			
		?>
		
  			<input value="<?=$tit1?>" type="button" onclick="document.location.href='<?=$add_sort?>?link=<?=(int)$_GET['link']?>'" class="addBtn" />

  		<?php  }  ?>

    </td>

  </tr>

  

</table>

	</td>

  </tr>

  

  <?php

  if ($res)



  {



 ?>

 <tr>

      <td colspan="2" align="left"  class="success">

	  <?php

	  if ($sucMessage != "" )

	  	echo '<br>' . $sucMessage . '<br>';

	  ?>

	  </td>

  </tr>

	<tr><td height="5" bgcolor="#FFFFFF">&nbsp;</td></tr>

  <tr>
  
  

    <td colspan="2">

	<?php 

		

		if ($bulk_delete == 'yes' ) 

			echo '<form name="blkDeleteForm" action="" method="post" enctype="multipart/form-data" onsubmit="return checkDelSection()">';

	?>

	<table id="tablesorter" width="99%" cellspacing="0" rules="rows" align="left">

		<thead> 

			<tr>

			<?php

				if ($bulk_delete == 'yes' ) {

				?>

					<th style="width:25px" class="{sorter: false}" ><input type="checkbox" name="sel_all" value="" style="width:auto" onclick="checkAll(this)" /></th>

				<?php	

				}

				foreach ($show as $key => $value) {
				
				?>

					<th style="text-align:left"> &nbsp; <?=$key?></th>

				<?php	

				}

			?>

			<th align="center" class="{sorter: false} action">Action</th>

			</tr>

		</thead> 

		<tbody>

 <?php	  



	  while ($row = mysqli_fetch_assoc($res) )

	  {


		$id		   	= $row['id'];
		if($table=="account"){
			 $id		   	= $row['userid'];
		}

		$eLink	   	= $page . "?id=" . $id;	
		$org_of_the_week_icon ='';
		if($table == 'organizations'){
			
			if($row['org_of_the_week'] == 1)
				$org_of_the_week_icon = '<a title="Remove From Week" id="org_week_'. $id .'" href="javascript:setOrganization('. $id .');"><img src="images/organization.png" border="0" align="absmiddle"></a>';
			else
				$org_of_the_week_icon = '<a title="Add To Week" id="org_week_'. $id .'" href="javascript:setOrganization('. $id .');"><img src="images/organization-dim.png" border="0" align="absmiddle"></a>';	
			
		}


		$dLink = '';
		
		$link_images = '';
		$mysaleslin='';
		$viewpagelink ='';
		$ExportLink ='';
		$clients_link ='';
		$mysaleslink ='';

		if ($delete == "yes" && !in_array($id,$can_not_delete_ids) ) {
			if($table==='account'){
				$ur	   	= "delete.php?id=$id&table=$table&link=$link&page=$pNum&advisor_id=".$_GET["advisor_id"];
			}else{
				$ur	   	= "delete.php?id=$id&table=$table&link=$link&page=$pNum" ;
			}
			$dLink	   = '<a href="javascript:void(0)" onclick="removeAlert(\''. $ur .'\')" class="bc_menu"><img src="images/icon_delete.gif" border="0" title="Delete Page" align="absmiddle" /></a>';
				
		} else

			$dLink	   = '<img src="images/icon_delete_dis.jpg" border="0" title="Delete Disabled for this entery" align="absmiddle" />' ;

		

		if ($viewpage != '')

			$viewpagelink = '<a target="_blank" href="../'. $viewpage . '?id=' . $id .'"><img src="images/icon_view.gif" border="0" align="absmiddle" title="Live Preview" /></a>';
		
		if ($mysales != '')

			$mysaleslink = '<a href="'. $mysales . '?id=' . $id .'"><img src="images/mysales.png" border="0" align="absmiddle" title="Commission details" /></a>';
		

		if ($edit == "no") {

			$edLink = "<span style='color:#CCCCCC'>Edit</span>";

			$eLink = '';

		} else

			$edLink = '<a href="' . $eLink . '"><img src="images/icon_edit.png" border="0" align="absmiddle" title="Edit Page" /></a>';
			if($table==='advisers'){
				$ExportLink = '<a href="'.ABSOLUTE_PATH.'exportReport.php?export_data=client&id='.$id.'"><img src="images/excel.png" border="0" title="Export Clients" align="absmiddle" /></a>';
				
				$clients_link = '<a href="'.ABSOLUTE_PATH.'list.php?link=1&advisor_id='.$id.'"><img src="images/ico_team.png" border="0" title="Clients" align="absmiddle" /></a>';
			}

		if( $images == 'yes' ) {

			$link_images = '<a href="home_images.php?id='.$id.'"><img src="images/images.png" border="0" align="absmiddle" title="View Images" /></a>';

		}

  ?>

  	<tr class="trdef">

	<?php

		if ($bulk_delete == 'yes' ) {

		?>

			<td bgcolor="#e4ddd5"><input type="checkbox" name="delid[]" value="<?php echo $row['id'];?>" style="width:auto" /></td>

		<?php	

		}

		foreach ($show as $key => $value) {
			if( $value == 'net_total' )
				$valDisp = '$'.number_format($row[$value], 2);
			else if( $value == 'date_submitted' )
				$valDisp = date('M d Y H:i', strtotime($row[$value]) );
			else if( $value == 'status' )
				$valDisp = ucwords($row[$value]);
			else
				$valDisp = $row[$value];
			
			if($value==='api_access_token' && $table==='advisers'){
				$valDisp = $row[$value];
				if($valDisp!='')
					$valDisp = "Yes";
			}
			
			
			
			if( $value=='disabled' && $row[$value]=='1' && $table=='account'){

				   $control = "list.php?link=$link&id=$id&table=account&action_account=enable";
				   $valDisp  = '<a style="cursor:pointer" href='.$control.'><img  src="images/disabled.png" border="0" align="absmiddle" title="Disable" /></a>'; 
			}

			elseif($value=='disabled' && $row[$value]!='1' && $table=='account'){
				 $control = "list.php?link=$link&id=$id&table=account&action_account=disable";
				 $valDisp  = '<a style="cursor:pointer" href='.$control.'><img  src="images/enable.png" border="0" align="absmiddle" title="Enable" /></a>'; 
			}
			?>

			<td style="cursor:pointer" onclick="window.location.href='<?=$eLink?>'"> &nbsp; <?=$valDisp?></td>

			<?php

		}

	?>

		<td class="actionMenu" align="center" <?php if($table==="advisers"){?>width="12%" <?php }?>><?=$org_of_the_week_icon .' &nbsp;'.$link_images.' &nbsp; '.$mysaleslink.' &nbsp; '.$viewpagelink.' &nbsp; '.$edLink.' &nbsp; '.$dLink.' &nbsp; '.$ExportLink.'&nbsp;'.$clients_link;?></td>

	</tr>

	



  <?php



  	}

echo '</tbody>';	

	if ($bulk_delete == 'yes' ) {

?>

	<tr><td colspan="<?php echo count($show) + 2; ?>" align="left" style="background-color:#efe9db;border:0px;padding:0px;margin:0px;">

		<input type="submit" name="btnDelete" value="Delete Selected" />

	</td></tr>

	<?php } ?>



</table>

<?php 

	if ($bulk_delete == 'yes' ) {

		echo '</form>';

	}	

	echo '<strong>' . $paging['pagingString'] . '</strong>';

?>

  	</td>

  </tr>  

<?php



  }



  else



  {



  ?>



  <tr>



    <td colspan="2" align="center" style="padding:10px" class="success">No Current Record</td>



  </tr>



  <?php



  }



  ?>



    <tr>



      <td colspan="2" align="center" style="padding:10px" class="success">



	  <?php 



	  if ($sucMessage != "" )



	  	echo '<br>' . $sucMessage . '<br>';



	  ?>



	  </td>



    </tr>



</table>



<?php

require_once("footer.php"); 



$_SESSION['PREVIOUS_OPEN_LINK'] = $_GET['link'];



?>



<script type="text/javascript">







function removeAlert(url) {

	var con = confirm("Are you sure to delete this entry?")

	if (con) 

		window.location.href = url;

}



function setOder(val) {



	url  = document.location.href;

	st = url.indexOf("&order=");

	if (st != -1 )

		url = url.substring(0,st);

	document.location.href = url + '&order=' + val;

}



function setSearch() {

	fld = document.getElementById("src_field").value;

	val = document.getElementById("term").value;

	url  = document.location.href;

	st = url.indexOf("&search=");

	if (st != -1 )

		url = url.substring(0,st);

	//alert(fld);

	document.location.href = encodeURI(url + '&search=' + fld + '&term='+val);

}





function checkAll(elem) {

	elems = document.getElementsByName("delid[]");

	if (elem.checked == true) {

		for (i=0;i<elems.length;i++) {

			elems[i].checked=true;

		}

	} else {

		for (i=0;i<elems.length;i++) {

			elems[i].checked=false;

		}

	}	

}



function checkDelSection()

{

	elems = document.getElementsByName("delid[]");

	for (i=0;i<elems.length;i++) 

		if ( elems[i].checked == true )

			return true;

	

	alert('Please select at least one row to delete.');

	return false;		

	

}



$(".trdef").hover(

	function() {

		$(this).css("background-color", "#F7F7F7");

	},

	function() {

		$(this).css('background-color', '#f2f1ec');

	}

);



</script>