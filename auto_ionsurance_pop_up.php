<?php include_once("database.php");?>

<!DOCTYPE html>

<html class=" gecko win js in-iframe"><head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <title>Opt-in Form</title>

    <head>
	
    <link rel="stylesheet" href="<?php echo ABSOLUTE_PATH; ?>assets/css/auto_insurance_pop_up.css">
	<script src="<?php echo ABSOLUTE_PATH; ?>assets/js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo ABSOLUTE_PATH; ?>assets/js/function.js" type="text/javascript"></script>
</head>

<body>

<div style="" id="leadpages-form-wrapper">

    <form  method="post" class="form-horizontal " id="leadpages-form" style="background-color: rgb(255, 255, 255); border-style: solid; border-width: 1pt; border-color: rgb(255, 255, 255)" accept-charset="utf-8">

        <a id="leadpages-close-button" href="javascript:void(0)" onClick="parent.$.colorbox.close();">×</a>

            <div id="leadpages-form-header">

                <div id="leadpages-form-header-text" style="font-family: &quot;Helvetica&quot;,&quot;Arial&quot;,sans-serif; font-size: 10pt; letter-spascing: 0em; display: block">

                     

                    Almost there! Please complete this form <strong>to get an email with your form to sign</strong>.

                </div>

            

            </div>

        

            <img id="leadpages-form-image" src="<?php echo ABSOLUTE_PATH; ?>assets/images/pop_up.jpg">

        

        <div class="leadbox-content-wrapper">

            <div id="leadpages-form-title" style="font-family: &quot;Open Sans&quot;,&quot;Helvetica&quot;,&quot;Arial&quot;,sans-serif; font-size: 18pt; letter-spacing: 0em; display: block">
            <div style="text-align: center"><strong>Enter your email address below.<br><br>Sign a Petition to Get Rid of MI No-Fault Auto Insurance. <br><br>It's 100% Free! </strong></div>
             </div>

            <div id="leadpages-fieldset-wrapper">

                <fieldset id="leadpages-fieldset">
					 <div class="control-group" id="leadpages-container-email-address">
							<div class="controls">
									<input name="email_address" value="" id="email-address" placeholder="E-Mail" data-source="leadpages-email" data-role="email" required type="email">

								</div>
								<span class="error-container" id="leadpages-error-email-address"></span>
						</div>
						<div class="control-group" id="leadpages-container-first-name">

                                <div class="controls">

    <input name="first_name" id="first-name" placeholder="First Name" data-source="leadpages-first_name" data-role="first_name" type="text">

</div>

                                        <span class="error-container" id="leadpages-error-first-name"></span>

                            </div>
							<div class="control-group" id="leadpages-container-last-name">

                                <div class="controls">

    <input name="last_name" id="last-name" placeholder="Last Name" data-source="leadpages-last_name" data-role="last_name" type="text">

</div>

                                        <span class="error-container" id="leadpages-error-last-name"></span>

                            </div>
							<div class="control-group" id="leadpages-container-city">

                                <div class="controls">

    <input name="city" id="city" placeholder="City" data-source="leadpages-city" data-role="city" type="text">

</div>

                                        <span class="error-container" id="leadpages-error-city"></span>

                            </div>
							<div class="control-group" id="leadpages-container-state">

                                <div class="controls">

    								<input name="state" id="state" placeholder="State" data-source="" data-role="" type="text">
                                    <input type="hidden" name="encripted_page_id" value="<?php echo $_GET["page_id"];?>" required>

								 </div>

                                        <span class="error-container" id="leadpages-error-state"></span>

                            </div>
							<div class="control-group" id="leadpages-container-zipcode">

                                <div class="controls">

    							<input name="zipcode" value="" id="zipcode" placeholder="Zipcode" data-source="leadpages-postcode" data-role="postcode" type="text">

</div>

                                        <span class="error-container" id="leadpages-error-zipcode"></span>

                            </div>
							<div class="control-group">
							<div class="controls">

                            	<button id="leadpages-submit-button" type="button" onClick="submitFormHeap();" style="font-family: &quot;Open Sans&quot;,&quot;Helvetica&quot;,&quot;Arial&quot;,sans-serif; font-size: 14pt; letter-spacing: 0em; background-color: rgb(18, 133, 221); border-style: solid; border-width: 0pt; border-top-width: 0pt; border-right-width: 0pt; border-bottom-width: 0pt; border-left-width: 0pt; border-color: ; text-shadow:"><div style="text-align: center">Click Here to sign the petition &nbsp;&nbsp; »</div>
								</button>

                        	</div>
							</div>
							<div class="leadpages-spacer">- -</div>

                	</fieldset>

            </div>

            <div id="leadpages-privacy-policy" style="font-family: &quot;Open Sans&quot;,&quot;Helvetica&quot;,&quot;Arial&quot;,sans-serif; font-size: 10pt; letter-spacing: "><div style="text-align: center"> <strong>Privacy Policy:</strong> We hate SPAM and promise to keep your email address safe. </div> </div>
			</div>
			<div class="leadpages-spacer">- -</div>

    </form>

</div>
<script type="text/javascript">
function submitFormHeap(){
		var email_address 	= $("#email-address").val();
		var first_name 		= $("#first-name").val();
		var last_name 		= $("#last-name").val();
		var city		 	= $("#city").val();
		var state		 	= $("#state").val();
		var zipcode		 	= $("#zipcode").val();
		
		if(email_address=='' || !validateEmail(email_address)){
			alert('Invalid Email Address.');
		}
		else if(first_name==''){
			alert('First Name is required.');
		}
		else if(last_name==''){
			alert('Last Name is required.');
		}
		else if(city==''){
			alert('City is required.');
		}
		else if(state==''){
			alert('State is required.');
		}
		else if(zipcode==''){
			alert('Zipcode is required.');
		}
		else{
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
    						window.parent.location = '<?php echo ABSOLUTE_PATH; ?>auto_insurance_thank_you.php';
						else
							window.location.href = '<?php echo ABSOLUTE_PATH; ?>auto_insurance_thank_you.php';
					}
			}
		});
	}
}
</script>
</body></html>