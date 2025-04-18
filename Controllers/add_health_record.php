<?php
require_once '../Config/db.php'; // Make sure this path points to your actual DB config

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $blood_type = $_POST['blood_type'] ?? null;
    $allergies = $_POST['allergies'] ?? null;
    $medical_conditions = $_POST['medical_conditions'] ?? null;
    $vaccinations = $_POST['vaccinations'] ?? null;
    $emergency_contact_name = $_POST['emergency_contact_name'] ?? null;
    $emergency_contact_phone = $_POST['emergency_contact_phone'] ?? null;
    $physician_name = $_POST['physician_name'] ?? null;
    $physician_phone = $_POST['physician_phone'] ?? null;
    $last_checkup_date = $_POST['last_checkup_date'] ?? null;
    $status = $_POST['status'] ?? null;
    $health_status = $_POST['health_status'] ?? null;


    $stmt = $conn->prepare("
        INSERT INTO student_health_records (
            student_id, first_name, last_name, email, gender, date_of_birth,
            blood_type, allergies, medical_conditions, vaccinations,
            emergency_contact_name, emergency_contact_phone,
            physician_name, physician_phone, last_checkup_date, status, health_status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");


    $stmt->bind_param(
        "issssssssssssssss",
        $student_id,
        $first_name,
        $last_name,
        $email,
        $gender,
        $date_of_birth,
        $blood_type,
        $allergies,
        $medical_conditions,
        $vaccinations,
        $emergency_contact_name,
        $emergency_contact_phone,
        $physician_name,
        $physician_phone,
        $last_checkup_date,
        $status,
        $health_status
    );

    if ($stmt->execute()) {
        echo "Record added successfully!";
        header('Location:../Views/admin_dashboard.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
