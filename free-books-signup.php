<?php include_once("database.php");
$encripted_page_id = tep_encrypt(6);
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link href="<?php echo ABSOLUTE_PATH; ?>assets/css/free-boo_css_002.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo ABSOLUTE_PATH; ?>assets/css/free-book_style.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo ABSOLUTE_PATH; ?>assets/css/free-book_css.css">
    <link rel="stylesheet" href="<?php echo ABSOLUTE_PATH; ?>assets/css/colorbox.css">
    <link rel="stylesheet" href="<?php echo ABSOLUTE_PATH; ?>assets/css/free-bok_leadpage.css">
    <link rel="stylesheet" href="<?php echo ABSOLUTE_PATH; ?>assets/css/free-book-responsive.css">
    <script src="<?php echo ABSOLUTE_PATH; ?>assets/js/jquery.js" type="text/javascript"></script>
    <script  src="<?php echo ABSOLUTE_PATH; ?>assets/js/jquery.colorbox.js"></script>  
     <script>
      $(document).ready(function(){
	         $(".pop_up").click(function(){
				$(".pop_up").colorbox({href:"<?php echo ABSOLUTE_PATH; ?>free-books-pop_up.php?page_id=<?php echo $encripted_page_id; ?>",width:"900",height:"520",transition:"none", iframe:true});			
			});
		});
     </script> 
 </head>
<body>
<img class="bg role-element leadstyle-image" src="<?php echo ABSOLUTE_PATH; ?>assets/images/free-book_leftbar.png" id="bgimg" style="width: 1366px; height: 1043.47px;">
<!-- wrapper -->
<section id="wrapper" class="wrapper">
    <section class="content-box type2">
        <!-- logo -->
        <a class="role-element leadstyle-image-link" id="logo"><img alt="logo" 
        src="<?php echo ABSOLUTE_PATH; ?>assets/images/free-book_logo.png" style="max-width: 322px; max-height: 322px;" border="0"></a>
        <!-- box -->
             <section id="content-box" class="blackbox">
            <h3 id="primary-headline" class="role-element leadstyle-text">"Free
 Book Reveals . . . If you are tired of taking advice from financial 
planners or insurance agents without understanding the advice given and 
wondering if it is in their best interest instead of your best interest,
 you’ve come to the right place.<br>"</h3>
            <p id="primary-subheadline" class="role-element leadstyle-text">Enter your email address to get this free digital books</p>
            <a data-optin="true"  href="javascript:void(0);" id="optin-button" class="role-element leadstyle-link pop_up">Download Your FREE Books</a>
            <p id="subtext" class="role-element leadstyle-text"><strong>Privacy Policy:</strong> We hate SPAM and promise to keep<br>your email address safe.</p>
        </section>
        <!-- footer -->
        <footer class="footer role-element leadstyle-text" id="footer"><p>&copy; 2015</p></footer>
    </section>
</section>

</div></div><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div></div></div></div></body>
<script src="<?php echo ABSOLUTE_PATH; ?>assets/js/webfont.js" type="text/javascript"></script>
</body>
</html>
