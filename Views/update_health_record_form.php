<?php
require_once '../Config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM student_health_records WHERE record_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_assoc();
    if (!$record) {
        echo "Record not found.";
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Health Record</title>
</head>
<body>
    <h2>Update Student Health Record</h2>
    <form action="../Controllers/update_health_record.php" method="post">
        <input type="hidden" name="record_id" value="<?= $record['record_id'] ?>">

        <label>Student ID:</label><br>
        <input type="number" name="student_id" value="<?= $record['student_id'] ?>" required><br>

        <label>First Name:</label><br>
        <input type="text" name="first_name" value="<?= htmlspecialchars($record['first_name']) ?>" required><br>

        <label>Last Name:</label><br>
        <input type="text" name="last_name" value="<?= htmlspecialchars($record['last_name']) ?>" required><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= isset($record['email']) ? htmlspecialchars($record['email']) : '' ?>" required><br>

        <label>Gender:</label><br>
        <select name="gender" required>
            <option value="Male" <?= $record['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $record['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= $record['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
        </select><br>

        <label>Date of Birth:</label><br>
        <input type="date" name="date_of_birth" value="<?= $record['date_of_birth'] ?>" required><br>

        <label>Blood Type:</label><br>
        <input type="text" name="blood_type" value="<?= htmlspecialchars($record['blood_type']) ?>"><br>

        <label>Allergies:</label><br>
        <textarea name="allergies"><?= htmlspecialchars($record['allergies']) ?></textarea><br>

        <label>Medical Conditions:</label><br>
        <textarea name="medical_conditions"><?= htmlspecialchars($record['medical_conditions']) ?></textarea><br>

        <label>Vaccinations:</label><br>
        <textarea name="vaccinations"><?= htmlspecialchars($record['vaccinations']) ?></textarea><br>

        <label>Emergency Contact Name:</label><br>
        <input type="text" name="emergency_contact_name" value="<?= htmlspecialchars($record['emergency_contact_name']) ?>"><br>

        <label>Emergency Contact Phone:</label><br>
        <input type="text" name="emergency_contact_phone" value="<?= htmlspecialchars($record['emergency_contact_phone']) ?>"><br>

        <label>Physician Name:</label><br>
        <input type="text" name="physician_name" value="<?= htmlspecialchars($record['physician_name']) ?>"><br>

        <label>Physician Phone:</label><br>
        <input type="text" name="physician_phone" value="<?= htmlspecialchars($record['physician_phone']) ?>"><br>

        <label>Last Checkup Date:</label><br>
        <input type="date" name="last_checkup_date" value="<?= $record['last_checkup_date'] ?>"><br>
        
        <label for="status">Status:</label>
        <select name="status" id="status" required>
        <option value="Fit For School">Fit For School</option>
        <option value="For Monitoring">For Monitoring</option>
        </select>

        <label>Health Status:</label><br>
        <textarea name="health_status"><?= htmlspecialchars($record['health_status']) ?></textarea><br><br>

        <input type="submit" value="Update Record">
    </form>
</body>
</html>
