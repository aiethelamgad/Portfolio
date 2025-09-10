<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . 
'/../assets/vendor/phpmailer/PHPMailer-6.9.1/src/Exception.php';
require __DIR__ . 
'/../assets/vendor/phpmailer/PHPMailer-6.9.1/src/PHPMailer.php';
require __DIR__ . 
'/../assets/vendor/phpmailer/PHPMailer-6.9.1/src/SMTP.php';

// Get credentials from environment variables
$receiving_email_address = $_ENV['RECEIVING_EMAIL'] ?? getenv('RECEIVING_EMAIL') ?? 'aiethel.amjad@gmail.com';
$smtp_username = $_ENV['SMTP_USERNAME'] ?? getenv('SMTP_USERNAME');
$smtp_password = $_ENV['SMTP_PASSWORD'] ?? getenv('SMTP_PASSWORD');

// Validate that required environment variables are set
if (empty($smtp_username) || empty($smtp_password)) {
    die('Error: SMTP credentials not configured. Please set SMTP_USERNAME and SMTP_PASSWORD environment variables.');
}

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $smtp_username;                         // SMTP username from environment
    $mail->Password   = $smtp_password;                         // SMTP password from environment
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable implicit TLS encryption
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($_POST['email'], $_POST['name']);
    $mail->addAddress($receiving_email_address);                // Add a recipient

    // Content
    $mail->isHTML(false);;                                        // Set email format to HTML
    $mail->Subject = $_POST['subject'];

    $mail->Body = 'From: ' . $_POST['name'] . "\n" .
                  'Email: ' . $_POST['email'] . "\n" .
                  'Subject: ' . $_POST['subject'] . "\n\n" .
                  'Message: ' . $_POST['message'];


    $mail->send();
    echo 'OK';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>


