<?php
// ✅ Step 5 — Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once 'db_connect.php';
$conn = Database::getInstance()->getConnection();

    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // ✅ Generate unique OTP
    $otp = rand(100000, 999999);

    // ✅ Store in session (or DB if needed)
    $_SESSION["otp"] = $otp;
    $_SESSION["email"] = $email;
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;

    // ✅ Send email with PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'yourgmail@gmail.com';       // 🔁 your Gmail
        $mail->Password = 'Your App password';         // 🔁 your App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email Content
        $mail->setFrom('yourgmail@gmail.com', 'Register&Login_OTP');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP Verification Code';
        $mail->Body    = "Hi $username,\n\nYour OTP code is: $otp\n\nUse this to verify your account.";

        $mail->send();

        // ✅ Redirect to OTP form with email in query
        header("Location: index.php?show=otp&email=" . urlencode($email));
        exit();
    } catch (Exception $e) {
        echo "❌ OTP email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

