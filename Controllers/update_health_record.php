<?php
require_once '../Config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("
        UPDATE student_health_records SET 
            student_id = ?, first_name = ?, last_name = ?, email = ?, gender = ?, date_of_birth = ?, 
            blood_type = ?, allergies = ?, medical_conditions = ?, vaccinations = ?, 
            emergency_contact_name = ?, emergency_contact_phone = ?, physician_name = ?, 
            physician_phone = ?, last_checkup_date = ?, health_status = ?, status = ?
        WHERE record_id = ?
    ");

    $stmt->bind_param(
        "issssssssssssssssi",
        $_POST['student_id'],
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],
        $_POST['gender'],
        $_POST['date_of_birth'],
        $_POST['blood_type'],
        $_POST['allergies'],
        $_POST['medical_conditions'],
        $_POST['vaccinations'],
        $_POST['emergency_contact_name'],
        $_POST['emergency_contact_phone'],
        $_POST['physician_name'],
        $_POST['physician_phone'],
        $_POST['last_checkup_date'],
        $_POST['health_status'],
        $_POST['status'],
        $_POST['record_id']
    );

    if ($stmt->execute()) {
        header("Location: ../Views/student_health_record.php");
        exit;
    } else {
        echo "Failed to update record: " . $conn->error;
    }
}
?>
