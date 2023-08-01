<?php
	ob_start();
	require_once 'database.php';

	unset($_GET['message']);

	

	if (isset($_GET['action']))

	{

		$action = $_GET['action'];

		if ($action == 'Login')

		{

			adminLogin();

		}

		else if($action == 'change')

		{

			adminchangePass();

		}

		else if($action == 'uLogin')

		{

			userLogin();

		}

		else if($action == 'logout')

		{

			$_SESSION['admin_user'] = '';
			unset($_SESSION['admin_user']);
			
			$_SESSION['user_type'] = '';
			unset($_SESSION['user_type']);

			header('Location: login.php');

		}

		

		

	}

		

function adminLogin()
{
	global $Conn_db;	
	if (isset($_POST['txtUser']) && isset($_POST['txtPass']))
	{
		$user    =  trim($_POST['txtUser']);
		$Typass  =  trim($_POST['txtPass']);

		$sql = "select * from bc_admin where user_name = '". $user ."'";
		
		$res = mysqli_query($Conn_db,$sql);
		if (mysqli_num_rows($res) > 0)
		{
			
			$rows = mysqli_fetch_assoc($res);
			$pass = $rows['password'];
			
			if ( $Typass == $pass)
			{
				$_SESSION['admin_user'] 	= $user;
				$_SESSION['user_type'] = $rows['user_type'];
				//exit($_SESSION['user_type']);
				
				header("Location: index.php");
				exit;
			}
			else
				$msg = "Password Does not match";
		}
		else 
			$msg = "User not found";
	} else
		$msg = "Plese Enter your UserName and Password";

	header("Location: login.php?errormessage=".$msg);

}



function adminchangePass()
{		
		global $Conn_db;
		if ($_POST['txtNewPass'] != '' || $_POST['txtPass3'] != '' ) {
			if ($_POST['txtNewPass'] == $_POST['txtPass3'] ) {
				$password = $_POST['txtNewPass'];
		
				$sql = "update bc_admin set password='". $password. "' WHERE user_name = '". $_SESSION['admin_user'] ."'";
				$res = mysqli_query($Conn_db,$sql);			
				if ($res) {
					
				} else {
					$message = "Can't Edit Password";
				}	
			} else {
				$message = "Confirm Password does not match";
			}
		} else {
			$message = "Password Must Not Empty";
		}
		
		header("Location: changePass.php?message=".$message);

}



?>