<?php include_once("database.php");?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="<?php echo ABSOLUTE_PATH; ?>assets/css/free-book_popup.css">
</head>
<body>
<div id="leadpages-form-wrapper">
    <form  action=""  method="post" class="form-horizontal " id="leadpages-form" style="background-color: rgb(255, 255, 255); border-style: solid; border-width: 1pt; border-color: rgb(255, 255, 255)" accept-charset="utf-8">
        <a id="leadpages-close-button" href="#" onClick="parent.$.colorbox.close();">×</a>
            <div id="leadpages-form-header">
                <img id="leadpages-form-header-image" src="<?php echo ABSOLUTE_PATH; ?>assets/images/leadbox_status_bar_gray3.gif">
            
                <div id="leadpages-form-header-text" style="font-family: &quot;Helvetica&quot;,&quot;Arial&quot;,sans-serif; font-size: 10pt; letter-spacing: 0em; display: block">
                    
                    Almost there! Please complete this form and click
                    the button below to gain instant access.
                </div>
            
            </div>
        
            <img id="leadpages-form-image" src="<?php echo ABSOLUTE_PATH; ?>assets/images/free-book_left-pop-up.jpg">
        
        <div class="leadbox-content-wrapper">
            <div id="leadpages-form-title" style="font-family: &quot;Open Sans&quot;,&quot;Helvetica&quot;,&quot;Arial&quot;,sans-serif; font-size: 18pt; letter-spacing: 0em; display: block">
                
                        
                        
                        
                        
                        
                        <div style="text-align: center"><strong>Enter your email address below to reserve your report...it's 100% FREE! </strong></div>       
            </div>
            <div id="leadpages-fieldset-wrapper">
                <fieldset id="leadpages-fieldset">
                    
                        
                            <div class="control-group" id="leadpages-container-email-address">
                                <div class="controls">
    <input name="email_address" id="email-address" placeholder="E-Mail" data-source="leadpages-email" data-role="email" required type="email">
</div><input type="hidden" name="encripted_page_id" value="<?php echo $_GET["page_id"];?>" required>
                                        <span class="error-container" id="leadpages-error-email-address"></span>
                            </div>
                        
                    
                    <div class="control-group">
                        <div class="controls">
                            <button id="leadpages-submit-button" type="button" onClick="submitFormHeap();"  style="font-family: &quot;Open Sans&quot;,&quot;Helvetica&quot;,&quot;Arial&quot;,sans-serif; font-size: 14pt; letter-spacing: 0em; background-color: rgb(18, 133, 221); border-style: solid; border-width: 0pt; border-top-width: 0pt; border-right-width: 0pt; border-bottom-width: 0pt; border-left-width: 0pt; border-color: rgb(240, 240, 240); text-shadow: 2px 2px 0px rgb(18, 133, 221)"> Get Your FREE Books Now &nbsp;&nbsp; » </button>
                        </div>
                    </div>
                    <div class="leadpages-spacer">- -</div>
                </fieldset>
            </div>
            <div id="leadpages-privacy-policy" style="font-family: &quot;Open Sans&quot;,&quot;Helvetica&quot;,&quot;Arial&quot;,sans-serif; font-size: 10pt; letter-spacing: 0em">
                                        
                        <div style="text-align: center"> Privacy Policy: We hate SPAM and promise to keep your email address safe. </div>    
                    
            </div>
        </div>
        <div class="leadpages-spacer">- -</div>
    </form>
	</div>
<script src="<?php echo ABSOLUTE_PATH; ?>assets/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo ABSOLUTE_PATH; ?>assets/js/function.js" type="text/javascript"></script>
<script type="text/javascript">
function submitFormHeap(){
		var email_address = $("#email-address").val();
		if(email_address=='' || !validateEmail(email_address)){
			alert('Invalid Email Address.');
		}else{
			$.ajax({
				type:"POST",
				data:"action=heaplanAccount&"+$("#leadpages-form").serialize(),
				url:"<?php echo ABSOLUTE_PATH;?>/api/hnadelFormRequest.php",
				dataType:"json",
				crossDomain:true,
				success: function(dataresult){
					if(dataresult.result=="error"){
						alert(dataresult.message);
					}
					else if(dataresult.result=="success"){
						if (window.location != window.parent.location)
    						window.parent.location = '<?php echo ABSOLUTE_PATH; ?>heap-default-thank-you.php';
						else
							window.location.href = '<?php echo ABSOLUTE_PATH; ?>heap-default-thank-you.php';
					}
			}
		});
	}
}
</script>
</body>
</html>
