<?php
require_once '../Config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM student_health_records WHERE record_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_assoc();

    if ($record) {
        echo "<h3>Student Health Record Details</h3>";
        echo "<p><strong>Student ID:</strong> " . htmlspecialchars($record['student_id']) . "</p>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($record['first_name']) . " " . htmlspecialchars($record['last_name']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($record['email']) . "</p>";
        echo "<p><strong>Gender:</strong> " . htmlspecialchars($record['gender']) . "</p>";
        echo "<p><strong>Date of Birth:</strong> " . htmlspecialchars($record['date_of_birth']) . "</p>";
        echo "<p><strong>Blood Type:</strong> " . htmlspecialchars($record['blood_type']) . "</p>";
        echo "<p><strong>Allergies:</strong> " . nl2br(htmlspecialchars($record['allergies'])) . "</p>";
        echo "<p><strong>Medical Conditions:</strong> " . nl2br(htmlspecialchars($record['medical_conditions'])) . "</p>";
        echo "<p><strong>Vaccinations:</strong> " . nl2br(htmlspecialchars($record['vaccinations'])) . "</p>";
        echo "<p><strong>Emergency Contact:</strong> " . htmlspecialchars($record['emergency_contact_name']) . " (" . htmlspecialchars($record['emergency_contact_phone']) . ")</p>";
        echo "<p><strong>Physician:</strong> " . htmlspecialchars($record['physician_name']) . " (" . htmlspecialchars($record['physician_phone']) . ")</p>";
        echo "<p><strong>Last Checkup:</strong> " . htmlspecialchars($record['last_checkup_date']) . "</p>";
        echo "<p><strong>Health Status:</strong> " . nl2br(htmlspecialchars($record['health_status'])) . "</p>";
        echo "<p><strong>Status</strong> " . nl2br(htmlspecialchars($record['status'])) . "</p>";
    } else {
        echo "Record not found.";
    }
}
?>
