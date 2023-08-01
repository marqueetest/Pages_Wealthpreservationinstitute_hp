<?php
	ini_set('display_errors', 0);
@session_start();
$pages = array(
	array("title" => "Pages List",
		"id" => "",	
		"table" => "pages",
		"add" => "no",
		"customSQL" => "select * from pages",
		"delete"=>"no",
		"page" => "pages.php",
		"default_orderby_column" => "id",
		"add_new_button" => "Add ",
		"can_not_delete_ids"=>array(1),
		"show" => array("Page Name" => "page_name"),
		"searchFieldsList" => array("Page ID"=>"id","Page Name" => "page_name"),
		"orderFieldsList" => array("Page ID"=>"id","Page Name" => "page_name"),
		"icon" => "articles.png", 
		"bulk_delete"=>"no",
	),
	array("title" => "Change Password",
			"page" => "changePass.php",
			"link" => "direct",
			"icon" => "ico_homes.png"
	)
	
);
?>