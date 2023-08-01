<?php
	include("database.php");
	if($_SESSION['admin_user']!=''){
	
	if($_GET['export_data']=="client" && $_GET['id']>0){
		
		$adviser_use = getSingleColumn("username","SELECT username from advisers where id = '".$_GET['id']."'");
		
		$csv_filename = 'client_of_'.$adviser_use.'_'.date("Y-m-d H-i-s").'.csv';
		
		$adviser_clients = "SELECT * from account WHERE adviser_id = '".$_GET['id']."' ORDER by userid DESC";
		
		$res	= mysqli_query($Conn_db,$adviser_clients);
		if(mysqli_num_rows($res)){
		
			$header  = "First Name,";
			$header .= "Last Name,";
			$header .= "User Name,";
			$header .= "Phone,";
			$header .= "Email Address,";
			$header .= "Street Address,";
			$header .= "City,";
			$header .= "State,";
			$header .= "Zip,";
			$header .= "Disabled,\n";
			
		
	
			$data	= '';
			$line	= '';
			while($row2 = mysqli_fetch_array($res)){
				
				$firstname	= $row2['first'];
				$lastname	= $row2['last'];
				$username	= $row2['username'];
				$phone		= $row2['phone'];
				$email		= $row2['username'];
				$address1	= str_replace("\n", '', $row2['street']);
				$address1	= str_replace("\r", '', $address1);
				$address1	= str_replace("\r\n", '', $address1);
				$address1	= str_replace(",", '', $address1);
				$city		= $row2['city'];
				$state		= $row2['state'];
				$zip_code	= $row2['zip'];
				$disabled	= $row2['disabled']=='1'?'Disable':'Enable';
				
				
				$line	.= $firstname.",";
				$line	.= $lastname.",";
				$line	.= $username.",";
				$line	.= $phone.",";
				$line	.= $email.",";
				$line	.= $address1.",";
				$line	.= $city.",";
				$line	.= $state.",";
				$line	.= $zip_code.",";
				$line	.= $disabled.",";
				
				$data.= trim( $line ) . "\r\n";
				$line = '';
				
				
				
	
			}
			
			//$data = str_replace( "\r" , "" , $data );
									
			if ( $data == "" )
			{
				$data = "\n(0) Records Found!\n";                        
			}
			
			//echo $data;
			
			header("Content-type: application/html-csv"); 
			//	header("Content-type: application/octet-stream");
			//header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=".$csv_filename."");
			header("Pragma: no-cache");
			header("Expires: 0");
			print "$header\n$data";
		}
		
		
	}else if($_GET['export_data']=="advisers"){
		
		$csv_filename = 'advisers_list_'.date("Y-m-d").'_'.time().'.csv';
		
		$adviser_clients = "select * from advisers ORDER by id DESC";
		
		
		$res	= mysqli_query($Conn_db,$adviser_clients);
		if(mysqli_num_rows($res)){
			
			$header  = "First Name,";
			$header .= "Last Name,";
			$header .= "User Name,";
			$header .= "Phone,";
			$header .= "Email Address,";
			$header .= "Address1,";
			$header .= "Address2,";
			$header .= "City,";
			$header .= "State,";
			$header .= "Zipcode,\n";
		
	
			$data	= '';
			$line	= '';
			while($row2 = mysqli_fetch_array($res)){
				
				$firstname	= $row2['first_name'];
				$lastname	= $row2['last_name'];
				$username	= $row2['username'];
				$email		= $row2['email_address'];
				$address1	= str_replace("\n", '', $row2['address1']);
				$address1	= str_replace("\r", '', $address1);
				$address1	= str_replace("\r\n", '', $address1);
				$address1	= str_replace(",", '', $address1);
				$address2	= str_replace("\n", '', $row2['address2']);
				$address2	= str_replace("\r", '', $address1);
				$address2	= str_replace("\r\n", '', $address1);
				$address2	= str_replace(",", '', $address1);
				$city		= $row2['city'];
				$state		= $row2['state'];
				$zip_code	= $row2['zipcode'];
				$phone		= $row2['phone'];
	
				
				$line	.= $firstname.",";
				$line	.= $lastname.",";
				$line	.= $username.",";
				$line	.= $phone.",";
				$line	.= $email.",";
				$line	.= $address1.",";
				$line	.= $address2.",";
				$line	.= $city.",";
				$line	.= $state.",";
				$line	.= $zip_code.",";
				
				$data.= trim( $line ) . "\r\n";
				$line = '';
				
				
				
	
			}
		
	
									
			if ( $data == "" )
			{
				$data = "\n(0) Records Found!\n";                        
			}
			
			//echo $data;
			
			header("Content-type: application/html-csv"); 
			//	header("Content-type: application/octet-stream");
			//header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=".$csv_filename."");
			header("Pragma: no-cache");
			header("Expires: 0");
			print "$header\n$data";
		}
	
	}
	
	
 
}else{
	header('Location:'+ABSOLUTE_PATH);
	exit;

}
	
?>