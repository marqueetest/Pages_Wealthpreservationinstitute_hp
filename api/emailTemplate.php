<?php ob_start();?>
<table style="padding:68px 75px" width="100%" bgcolor="#ebebeb" border="0" cellpadding="0" cellspacing="0">

            <tbody><tr>
                <td>
                    <table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                            <td>
                                <table style="border-collapse:collapse" width="660" align="center" border="0" cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                        <td style="padding:45px 0 30px 0" colspan="3" align="center">
                                            <img src="<?php echo ABSOLUTE_PATH;?>Wealth-Preservation-Institute.png" alt="Wealth Preservation Institute" style="display:block" height="80" width="205" class="CToWUd" title="Wealth Preservation Institute">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0 75px" colspan="3" align="center">
                                            Hi there! Someone has opted 
in to "<strong><?php echo $page_name; ?></strong>" with the following information:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:25px 0 30px 0" colspan="3" align="center">
                                            <table cellpadding="5">
                                            
                                                <tbody>
                                                  <tr>
                                                    <td>
                                                        E-Mail:
                                                    </td>
                                                    <td style="color:#7dc1f4;text-decoration:underline">
                                                        
<a href="mailto:<?php echo $bc_email_address;?>" target="_blank"><?php echo $bc_email_address;?></a>
                                                    </td>
                                                </tr>
                                                <?php if($bc_first_name!=''){?>
                                                <tr>
                                                    <td>
                                                       First Name
                                                    </td>
                                                    <td >
                                                    	<?php echo $bc_first_name;?>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                                 <?php if($bc_last_name!=''){?>
                                                <tr>
                                                    <td>
                                                      Last Name:
                                                    </td>
                                                    <td >
                                                    	<?php echo $bc_last_name;?>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                                 <?php if($bc_city!=''){?>
                                                <tr>
                                                    <td>
                                                       City:
                                                    </td>
                                                    <td >
                                                    	<?php echo $bc_city;?>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                                 <?php if($bc_state!=''){?>
                                                <tr>
                                                    <td>
                                                        State:
                                                    </td>
                                                    <td >
                                                    	<?php echo $bc_state;?>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                                 <?php if($bc_zipcode!=''){?>
                                                <tr>
                                                    <td>
                                                       Zipcode:
                                                    </td>
                                                    <td >
                                                    	<?php echo $bc_zipcode;?>
                                                    </td>
                                                </tr>
                                                <?php }?>
                                            
                                            </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:20px 0"><br>
</td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody>
</table>
<?php 
		$emailTemplate = ob_get_contents();
		ob_clean(); 
	 	//$to  	  = "john@globaladvisors.org";
        $to       = "dummydeni132@gmail.com";
		$subject  = 'Someone has opted in to '.$page_name;
		//$headers  = "From: Wealth Preservation Institute - ".$page_name." <" . strip_tags("info@roccy.org") . ">\r\n";
		$headers .= "Reply-To: ". strip_tags("info@roccy.org") . "\r\n";
		$headers .= "Return-Path: info@roccy.org\r\n";
		$headers .= "Organization: Wealth Preservation Institute\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$headers .= "X-Priority: 3\r\n";
 		$headers .= "X-Mailer: PHP". phpversion() ."\r\n"; 
		
		@mail($to, $subject, $emailTemplate, $headers);
        // require $_SERVER['DOCUMENT_ROOT'].'\vendor\phpmailer\phpmailer\src\Exception.php';
        // require $_SERVER['DOCUMENT_ROOT'].'\vendor\phpmailer\phpmailer\src\PHPMailer.php';
        // require $_SERVER['DOCUMENT_ROOT'].'\vendor\phpmailer\phpmailer\src\SMTP.php';
        
        // require_once  $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
        // // create a new object
        // //$mail = new PHPMailer();
        // $mail = new PHPMailer\PHPMailer\PHPMailer();
        // // configure an SMTP
        // $mail->isSMTP();
        // $mail->SMTPDebug = 0;
        // $mail->SMTPAuth = true;
        // $mail->Debugoutput = 'html';    
        // $mail->Host = 'smtp.gmail.com';
        // // $mail->Host = 'smtp.office365.com';
        // $mail->Username = 'dummydeni132@gmail.com';
        // $mail->Password = 'uicfyinlgjwsmwnz';
        // // $mail->Password = 'Mansis@1234';
        // $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        // $mail->Port = 587;

        // $mail->setFrom('info@roccy.org',"Wealth Preservation Institute - ".$page_name." <" . strip_tags("info@roccy.org") . ">");
        // $mail->addAddress($to, 'TEST');
        // $mail->Subject = $subject;
        // // Set HTML 
        // $mail->isHTML(TRUE);
        // $mail->Body = $headers;  
        // if($mail->send()){
        //     return 1;
        // }


?>