<?php
require_once '../Config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id         = $_POST['student_id'];
    $first_name         = $_POST['first_name'];
    $last_name          = $_POST['last_name'];
    $email              = $_POST['email'];
    $appointment_date   = $_POST['appointment_date'];
    $appointment_time   = $_POST['appointment_time'];

    // Extract the hour (e.g. "09") from HH:MM:SS
    $hour = substr($appointment_time, 0, 2);
    $start_time = $hour . ":00:00";
    $end_time   = $hour . ":59:59";

    // Count how many appointments are already booked in that hour
    $check = $conn->prepare("SELECT COUNT(*) as count FROM appointment_requests 
        WHERE appointment_date = ? 
        AND appointment_time BETWEEN ? AND ?");
    $check->bind_param("sss", $appointment_date, $start_time, $end_time);
    $check->execute();
    $result = $check->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] >= 10) {
        echo "Sorry, this hour is fully booked. Please choose a different time.";
    } else {
        // Insert appointment request
        $stmt = $conn->prepare("INSERT INTO appointment_requests (
            student_id, first_name, last_name, email, appointment_date, appointment_time
        ) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $student_id, $first_name, $last_name, $email, $appointment_date, $appointment_time);

        if ($stmt->execute()) {
            echo "Appointment request submitted. Waiting for confirmation!";
            header('Location: ../index.php');
            exit();
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
