<?php
if(isset($_POST['submit'])):
    if(isset($_POST['h-captcha-response']) && !empty($_POST['h-captcha-response'])):
        // get verify response
        $data = array(
            'secret' => "da58e2ac-d4a6-4170-82d0-d61690e6eb44",
            'response' => $_POST['h-captcha-response']
        );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $verifyResponse = curl_exec($verify);
        $responseData = json_decode($verifyResponse);

        $name = !empty($_POST['Name'])?$_POST['Name']:'';
        $companyname = !empty($_POST['Company'])?$_POST['Company']:'';
        $email = !empty($_POST['Email'])?$_POST['Email']:'';
        $message = !empty($_POST['Message'])?$_POST['Message']:'';

        if($responseData->success):
            // Contact form submission code
            $to = "www-data@greenspacegroup.net";
            $subject = 'New contact form has been submitted';
            $htmlContent = "
                <h1>Contact request details</h1>
                <p><b>Name: </b>".$name."</p>
                <p><b>CompanyName: </b>".$companyname."</p>
                <p><b>Email: </b>".$email."</p>
                <p><b>Message: </b>".$message."</p>
            ";
            // Always set content-type when sending HTML email
            $headers = "From: www-data@greenspacegroup.net" . "\r\n";
            $headers .= "Reply-To: www-data@greenspacegroup.net" . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // Send email
            if(@mail($to, $subject, $htmlContent, $headers)):
                $succMsg = 'Your contact form has been submitted successfully.';
                $name = '';
                $companyname = '';
                $email = '';
                $message = '';
            else:
                $errMsg = 'Email could not be sent. Please try again later.';
            endif;
        else:
            $errMsg = 'Verification failed. Please try again.';
        endif;
    else:
        $errMsg = 'Please click on the hCaptcha button.';
    endif;
else:
    $errMsg = '';
    $succMsg = '';
    $name = '';
    $companyname = '';
    $email = '';
    $message = '';
endif;
?>
<html>
    <head>
        <title>GS Contact Us Form</title>
        <script src="https://www.hCaptcha.com/1/api.js" async defer></script>
    </head>
    <body>
        <div>
            <h2>Contact Us Form</h2>
            <?php if(!empty($errMsg)): ?><div class="errMsg"><?php echo $errMsg; ?></div><?php endif; ?>
            <?php if(!empty($succMsg)): ?><div class="succMsg"><?php echo $succMsg; ?></div><?php endif; ?>
            <div>
                <form action="" method="POST">
                    <input type="text" class="text" value="<?php echo !empty($name)?$name:''; ?>" placeholder="Your full name" name="Name" >
                    <input type="text" class="text" value="<?php echo !empty($email)?$email:''; ?>" placeholder="Email address" name="Email" >
                    <input type="text" class="text" value="<?php echo !empty($companyname)?$companyname:''; ?>" placeholder="Your Company Name" name="Company" >
                    <textarea type="text" placeholder="Message..." required="" name="Message"><?php echo !empty($message)?$message:''; ?></textarea>
                    <div class="h-captcha" data-sitekey="da58e2ac-d4a6-4170-82d0-d61690e6eb44"></div>
                    <input type="submit" name="submit" value="SUBMIT">
                </form>
            </div>      
            <div class="clear"> </div>
        </div>
    </body>
</html>