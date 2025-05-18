<?php
header('Content-Type: application/json');

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // Replace with your email
        $mail->Password = 'your-app-password'; // Replace with your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Recipients
        $mail->setFrom($_POST["email"], $_POST["name"]);
        $mail->addAddress('moustafa.mywork@gmail.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Contact Form Submission";
        $mail->Body = "
            <h3>New Contact Form Submission</h3>
            <p><strong>Name:</strong> " . htmlspecialchars($_POST["name"]) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($_POST["email"]) . "</p>
            <p><strong>Phone:</strong> " . htmlspecialchars($_POST["phone"]) . "</p>
            <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($_POST["message"])) . "</p>
        ";

        $mail->send();
        echo json_encode(["status" => "success", "message" => "تم إرسال رسالتك بنجاح!"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "حدث خطأ أثناء إرسال الرسالة. حاول مرة أخرى."]);
        // For debugging, you can log the error:
        // error_log("Mailer Error: " . $mail->ErrorInfo);
    }
} else {
    echo json_encode(["status" => "error", "message" => "طلب غير صالح."]);
}
?>