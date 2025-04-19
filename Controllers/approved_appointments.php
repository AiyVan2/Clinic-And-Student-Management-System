<?php
require '../Config/db.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Handle confirmation action
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get appointment details
    $stmt = $conn->prepare("SELECT * FROM appointment_requests WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    if ($appointment) {
        // Check for conflict before confirming
        $check = $conn->prepare("SELECT * FROM appointment_requests 
            WHERE appointment_date = ? AND appointment_time = ? AND status = 'confirmed'");
        $check->bind_param("ss", $appointment['appointment_date'], $appointment['appointment_time']);
        $check->execute();
        $conflict = $check->get_result();

        if ($conflict->num_rows > 0) {
            echo "<script>alert('Time slot already confirmed for another student.');</script>";
        } else {
            // Confirm the appointment
            $confirm = $conn->prepare("UPDATE appointment_requests SET status = 'confirmed', confirmed_at = NOW() WHERE id = ?");
            $confirm->bind_param("i", $id);
            if ($confirm->execute()) {
                // Send email
                $mail = new PHPMailer(true);

                // Configure your SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // or your mail host
                $mail->SMTPAuth = true;
                $mail->Username = 'ivanzky22@gmail.com';
                $mail->Password = 'xeiv jtzh rned wqxg';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('ivanzky22@gmail.com', 'Clinic Admin');
                $mail->addAddress($appointment['email'], $appointment['first_name'] . ' ' . $appointment['last_name']);

                $mail->isHTML(true);
                $mail->Subject = 'Appointment Confirmation';
                $mail->Body    = "
                    Hello <strong>{$appointment['first_name']}</strong>,<br><br>
                    Your appointment on <strong>{$appointment['appointment_date']}</strong> at 
                    <strong>{$appointment['appointment_time']}</strong> has been <span style='color:green;'>confirmed</span>.<br><br>
                    Please be on time!<br><br>
                    - Health Center
                ";

                if ($mail->send()) {
                    echo "<script>alert('Appointment confirmed and email sent!');</script>";
                    header('Location: ../Views/appointments.php');
                } else {
                    echo "<script>alert('Appointment confirmed, but email failed to send.');</script>";
                }
            }
        }
        $check->close();
    }
    $stmt->close();
}
?>
