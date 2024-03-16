<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './php_mailer/vendor/autoload.php';
require_once './core/database.php';
include_once './core/functions.php';

if (isset($_POST['forget_pwd_email'])) {

    $forgetPwdEmail = $_POST['forget_pwd_email'];

    $checkEmailExist = checkEmailExist($forgetPwdEmail, $db);

    if ($checkEmailExist) {
        $pwd = rand(999999, 9999999);
        $pwdMD5 = md5($pwd);
        $db->query("UPDATE `employees` SET `password`='$pwdMD5' WHERE `email`='$forgetPwdEmail'");
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username = 'arshidni2023@gmail.com';
            $mail->Password = 'vtujprgdlrywzycz';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('info@professionalcoast.com', 'Mailer');
            $mail->addAddress($forgetPwdEmail);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Professional Costs | Password Reset';
            $mail->Body    = 'This is your New Password <strong>' . $pwd . '</strong>';
            $mail->AltBody = '<strong>Hint:</strong> Note down your passwords in your notebook that you think is safe from the reach of others.';

            $mail->send();
            echo json_encode(['class_' => 'text-success', 'msg' => 'Password Request has been sent.', 'status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['class_' => 'text-danger', 'msg' => $mail->ErrorInfo, 'status' => 'error']);
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo json_encode(['class_' => 'text-info', 'msg' => 'Email not in our database.', 'status' => 'error']);
    }
}
