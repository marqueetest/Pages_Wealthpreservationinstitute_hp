<?php

require_once 'database.php';

require_once("header.php");

$page_id = isset($_GET["id"]) ? $_GET["id"] : "";

	



if($page_id>0){ 

	



?>

<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">

    <tr class="bc_heading"><td colspan="2">Page (<?php echo getsingleColumn("page_name","SELECT page_name FROM pages WHERE id  = '".$page_id."'"); ?>)</td></tr>

	

</table>

<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">

    <tr>

        <tr><td width="100%" align="left" valign="middle" class="text">

        <h3>Copy the code below and past in your website</h3>

        <textarea name="formtext" id="formtext" style="width:100%; height:100px;" >
			<?php 

			switch($page_id){

				case 1:

				?>

                <body style="margin: 0; padding: 0; height: 100%; overflow: hidden;"><div style="position:absolute; left: 0; right: 0; bottom: 0; top: 0px;"><iframe src="<?php echo ABSOLUTE_PATH;?>heap-steve.php" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe></div></body>

                <?php

					

				break;

				case 2:

				?>

                <body style="margin: 0; padding: 0; height: 100%; overflow: hidden;"><div style="position:absolute; left: 0; right: 0; bottom: 0; top: 0px;"><iframe src="<?php echo ABSOLUTE_PATH;?>auto_insurance_sign_in.php" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe></div></body>

                <?php

				break;

				case 3:

				?>

                <body style="margin: 0; padding: 0; height: 100%; overflow: hidden;"><div style="position:absolute; left: 0; right: 0; bottom: 0; top: 0px;"><iframe src="<?php echo ABSOLUTE_PATH;?>auto_insurance_thank_you.php" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe></div></body>

                <?php

				break;

				case 5:

				?>

                <body style="margin: 0; padding: 0; height: 100%; overflow: hidden;"><div style="position:absolute; left: 0; right: 0; bottom: 0; top: 0px;"><iframe src="<?php echo ABSOLUTE_PATH;?>chezheap.php" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe></div></body>

                <?php

				break;

				case 6:

				?>

                <body style="margin: 0; padding: 0; height: 100%; overflow: hidden;"><div style="position:absolute; left: 0; right: 0; bottom: 0; top: 0px;"><iframe src="<?php echo ABSOLUTE_PATH;?>free-books-signup.php" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe></div></body>

                <?php

				break;

				case 7:

				?>
				<body style="margin: 0; padding: 0; height: 100%; overflow: hidden;"><div style="position:absolute; left: 0; right: 0; bottom: 0; top: 0px;"><iframe src="<?php echo ABSOLUTE_PATH;?>heap_signup.php" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe></div></body>

                <?php

				break;
				case 8:
				?><body style="margin: 0; padding: 0; height: 100%; overflow: hidden;"><div style="position:absolute; left: 0; right: 0; bottom: 0; top: 0px;"><iframe src="<?php echo ABSOLUTE_PATH;?>heap_signup_copy.php" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe></div></body>
				<?php
				break;

			}

			?>

        </textarea>

        </td>

    </tr>

    

    

</table>

<script>
	function trimSpaces(){
		s = document.getElementById("formtext").value;
		s = s.replace(/(^\s*)|(\s*$)/gi,"");
		s = s.replace(/[ ]{2,}/gi," ");
		s = s.replace(/\n /,"\n");
		document.getElementById("formtext").value = s;
	}
	$(document).ready(function(e) {
        trimSpaces();
    	document.getElementById("formtext").select();
	});

</script>



<?php

}

require_once("footer.php"); 



?>