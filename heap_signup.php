<?php
include_once("database.php");
$encripted_page_id = tep_encrypt(7);
?>
<!DOCTYPE html>
<link href="<?php echo ABSOLUTE_PATH; ?>assets/css/signup_style.css" type="text/css" rel="stylesheet" />
<html >
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="<?php echo ABSOLUTE_PATH; ?>assets/css/signup_leadpage.css">
        <meta name="viewport" content="width=device-width">
        <link href="<?php echo ABSOLUTE_PATH; ?>assets/css/signup_css" rel="stylesheet" type="text/css">
        <link href="<?php echo ABSOLUTE_PATH; ?>assets/css/signup_colorbox.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo ABSOLUTE_PATH; ?>assets/css/signup_style.css">
         <script src="<?php echo ABSOLUTE_PATH; ?>assets/js/jquery.js" type="text/javascript"></script>
        <script src="<?php echo ABSOLUTE_PATH; ?>assets/js/jquery.colorbox.js"type="text/javascript"></script>
        <script type="text/javascript">
        function checky()
        {
    
            $.colorbox({'iframe':true, width:"850", height:"510", href:"<?php echo ABSOLUTE_PATH; ?>saved_resource.php?page_id=<?php echo $encripted_page_id; ?>", escKey:true});
        }
    	</script>
		<meta content="" name="description"><meta content="" name="keywords">
		<link rel="stylesheet" href="<?php echo ABSOLUTE_PATH; ?>assets/css/css(1)" media="all">
		<meta name="leadpages-served-by" content="leadpages">
	</head>
<body>
<header id="header" class="role-element leadstyle-container">
    <div class="shell" data-lead-id="shell-id">
        <div id="vertical-box" data-lead-id="vertical-box-id">
            <a id="logo" class="role-element leadstyle-image-link" target="_blank">
                <img src="<?php echo ABSOLUTE_PATH; ?>assets/images/heaplan.png" style="max-width: 246px; max-height: 246px;"></a>

            <div class="clear"></div>
        </div>
        <div id="vertical-box">
            <img src="<?php echo ABSOLUTE_PATH; ?>assets/images/arrow_.png" id="divider" alt="divider" width="7" height="58">
        </div>
        <div id="vertical-box" data-lead-id="vertical-box1-id">
            <p class="headline role-element leadstyle-text">Get Your H.E.A.P&trade; App For FREE Today!</p>
        </div>
        <div class="clear"></div>
    </div>
</header>
<section id="main" data-lead-id="main-id">
    <div class="shell" data-lead-id="shell1-id">
        <div id="bx-lft" data-lead-id="bx-lft-id">
            <img src="<?php echo ABSOLUTE_PATH; ?>assets/images/heap_.png" class="role-element leadstyle-image" style="max-width: 340px; max-height: 340px;">
        </div>
        <div id="bx-rgt" data-lead-id="bx-rgt-id">
            <p class="headline role-element leadstyle-text">"Pay off your mortgage <span class="__postbox-detected-content __postbox-detected-date">5, 10, 15,</span> years early, save $100,000+ in interest payments, and do so without changing your spending habits?"</p>

            <p class="subheadline role-element leadstyle-text"><strong>H.E.A.P. app is normally $9.99. </strong><br>Create your own unique user name/password<br><b><b>ACTIVATE, A<b>ND GET THE APP FREE!</b></b></b></p>

            <div id="free-access" data-lead-id="free-access-id">
                <div>
                    <a onclick="checky();" class="button role-element leadstyle-link pop_up" data-option="true">GET YOUR APP NOW!</a>
                </div>
            </div>
            <div>
                <a onclick="checky();" class="button2 role-element leadstyle-link" data-optin="true">Get My Free H.E.A.P.&trade; APP Now! </a>
            </div>
            <p>
                <a class="take-site role-element leadstyle-link" href="#">
                    No, thanks, I'll pass this opportunity. Take me to the site now...
                </a>
            </p>
        </div>
        <div class="clear"></div>
    </div>
</section>
<footer>
    <div class="shell" data-lead-id="shell2-id">
        <p class="legal role-element leadstyle-text">&copy; 2015 | <a target="_blank" href="#">Legal Information</a></p>
    </div>
<script src="<?php echo ABSOLUTE_PATH; ?>assets/js/signup_webfont.js" type="text/javascript"></script>
</footer>
