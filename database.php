<?php

	// error_reporting(E_ALL ^ E_NOTICE);

	@session_start();

	if ($_SERVER['HTTP_HOST']=='localhost'){

		$hostname = "localhost";

		$database = "leadpages";

		$username = "root";

		$password = "";

		define("ABSOLUTE_PATH",			"http://localhost/leadPages/");

		define("DOC_ROOT", 			 	$_SERVER['DOCUMENT_ROOT'] . "leadPages/");

		define("MAX_RECORD_PER_PAGE",	50);

		define("MAX_RECORD_PER_PAGE_SITE",5);

		define("MAX_LINK_PER_LINK_PAGE",9);

		define("HOME_IMAGES_PATH", 	"images/home/");

		define("ADMIN_LOGO", ABSOLUTE_PATH."images/logo.png");

	

	}else{

		$hostname = "localhost";
		$database = "rsite_heaplan";
		$username = "root";
		$password = "";

		define("ABSOLUTE_PATH",			"http://pages.wealthpreservationinstitute.local/");

		define("DOC_ROOT",$_SERVER['DOCUMENT_ROOT'] . "/");

		define("MAX_RECORD_PER_PAGE",	50);

		define("MAX_RECORD_PER_PAGE_SITE",	5);

		define("MAX_LINK_PER_LINK_PAGE",	9);

		define("HOME_IMAGES_PATH", 	"images/home/");

		define("ADMIN_LOGO", ABSOLUTE_PATH."images/logo.png");

		

	}

	

	$Conn_db = mysqli_connect($hostname, $username, $password,$database) or die(mysqli_error());

	mysqli_select_db( $Conn_db,$database);

	include_once("functions.php");

?>