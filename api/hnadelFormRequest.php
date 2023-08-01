<?php

		session_start();

		ini_set('display_errors', 0);

		require_once('../database.php'); 

		$bc_first_name		=	DBin($_POST["first_name"]);

		$bc_last_name		=	DBin($_POST["last_name"]);

		$bc_email_address	=   DBin($_POST["email_address"]);


		$bc_city			=	DBin($_POST["city"]);

		$bc_state			=	DBin($_POST["state"]);

		$bc_zipcode			=	DBin($_POST["zipcode"]);




		if ($_POST["action"]=="heaplanAccount")  {

			$page_id = tep_decrypt($_POST["encripted_page_id"]);

			$page_name = getSingleColumn("page_name","SELECT page_name from pages WHERE id = '".$page_id."'");

			

			if($page_name!=''){

				include_once("emailTemplate.php");
				
				$return["result"] = "success";

				

			

			

			}else{

				$return["result"] = "error";

				$return["message"] = "Invalid action request.";

			}

		}

		else{


			$return["result"] = "error";

			$return["message"] = "Invalid action request.";

		}

		echo json_encode($return); 



?>