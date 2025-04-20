<?php
require '../Config/db.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'], $_POST['message'])) {
    $email = $_POST['email'];
    $message = nl2br(htmlspecialchars($_POST['message']));

    // Lookup student name based on email
    $stmt = $conn->prepare("SELECT first_name, last_name FROM student_health_records WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name);
    $stmt->fetch();
    $stmt->close();

    $name = $first_name . ' ' . $last_name;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'gmail mo';
        $mail->Password   = 'gmail code'; // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('gmail mo', 'School Clinic');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Health Reminder';
        $mail->Body    = "Hi $name,<br><br>$message<br><br>- School Clinic";

        $mail->send();
        echo "Reminder sent to $email.";
        header('Location: ../Views/send_reminder_form.php');
    } catch (Exception $e) {
        echo "Failed to send to $email: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
