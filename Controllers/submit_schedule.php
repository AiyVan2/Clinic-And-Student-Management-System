<?php
require_once '../Config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id     = $_POST['student_id'];
    $first_name         = $_POST['first_name'];
    $last_name          = $_POST['last_name'];
    $email              = $_POST['email'];
    $appointment_date   = $_POST['appointment_date'];
    $appointment_time   = $_POST['appointment_time'];

    // Check for existing confirmed appointment on that date and time
    $check = $conn->prepare("SELECT * FROM appointment_requests 
        WHERE appointment_date = ? AND appointment_time = ? AND status = 'confirmed'");
    $check->bind_param("ss", $appointment_date, $appointment_time);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Sorry, this time slot is already taken. Please choose a different one.";
    } else {
        // Proceed to insert request
        $stmt = $conn->prepare("
            INSERT INTO appointment_requests (
                student_id, first_name, last_name, email, appointment_date, appointment_time
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssssss", $student_id, $first_name, $last_name, $email, $appointment_date, $appointment_time);

        if ($stmt->execute()) {
            echo "Appointment request submitted. Waiting for confirmation!";
            header('Location: ../index.php');
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
