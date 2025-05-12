<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//if Send OTP is clicked
if (isset($_POST['send_otp'])) {
    $fullname = trim($_POST['full_name']);
    $email = trim($_POST['email']);

    if (empty($fullname) || empty($email)) {
        echo "Please fill in all fields.";
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    } else {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'YOUR_EMAIL_ID';
            $mail->Password   = 'YOUR_EMAIL_APP_PASSWORD';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('your_email@gmail.com', 'OTP Verification');
            $mail->addAddress($email, $fullname);
            $mail->isHTML(true);
            $mail->Subject = 'Encrypters - OTP verification';
            $mail->Body    = "Hello <strong>$fullname</strong>,<br>Your OTP is: <strong>$otp</strong><br>Don't share your OTP with anyone.";
            $mail->send();

            echo "OTP sent to $email";
        } catch (Exception $e) {
            echo "Failed to send OTP: {$mail->ErrorInfo}";
        }
    }
}

if (isset($_POST['verify_otp'])) {
    $enteredOtp = trim($_POST['otp']);
    if ($enteredOtp == $_SESSION['otp']) {
        unset($_SESSION['otp']);
        echo "✅ OTP Verified Successfully!";
    } else {
        echo "❌ Invalid OTP.";
    }
}
