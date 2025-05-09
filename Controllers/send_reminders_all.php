<?php
require '../Config/db.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['message'])) {
    $customMessage = nl2br(htmlspecialchars($_POST['message'])); // Safely format message

// Query students with upcoming checkups (customize condition as needed)
$query = "SELECT first_name, last_name, email FROM student_health_records 
        WHERE email IS NOT NULL";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $email = $row['email'];
    $name = $row['first_name'] . ' ' . $row['last_name'];

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Or your mail server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'gmail mo';     // Your Gmail
        $mail->Password   = 'gmail code';        // Use App Password for Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('gmail mo', 'School Clinic');
        $mail->addAddress($email, $name);
        $mail->Body    = "Hi $name,<br><br>$customMessage<br><br>- School Clinic";

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Health Reminder';
    
        $mail->send();
        echo "Reminder sent to $email<br>";
        header('Location: ../Views/send_reminder_form.php');
    } catch (Exception $e) {
        echo "Failed to send to $email: {$mail->ErrorInfo}<br>";
    }
}
    } else {
    echo "Invalid request.";
}
?>
