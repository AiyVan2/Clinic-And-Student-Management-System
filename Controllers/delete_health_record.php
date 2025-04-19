<?php
require_once '../Config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $record_id = $_POST['record_id'] ?? null;

    if ($record_id) {
        $stmt = $conn->prepare("DELETE FROM student_health_records WHERE record_id = ?");
        $stmt->bind_param("i", $record_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Record deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete record.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid record ID.']);
    }
}
?>
