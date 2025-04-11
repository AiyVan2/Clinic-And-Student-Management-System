<?php
require_once '../Config/db.php';

// Fetch all students with status 'Monitoring'
$query = "SELECT email, first_name, last_name FROM student_health_records WHERE status = 'For Monitoring'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Health Reminder</title>
</head>
<body>
    <h2>Send Custom Health Reminder</h2>
    <form action="../Controllers/send_reminders.php" method="POST">
        <label for="message">Reminder Message:</label><br>
        <textarea name="message" rows="8" cols="50" required></textarea><br><br>
        <input type="submit" value="Send Reminder to All Students">
    </form>

    <!-- Student Health only for monitoring -->
    <h2>Send Health Reminder to Student (Monitoring Only)</h2>

<form action="../Controllers/send_reminders_monitoring_students.php" method="POST">
    <label for="email">Select Student:</label>
    <select name="email" id="email" required>
        <option value="">-- Select Student --</option>
        <?php while ($row = $result->fetch_assoc()): ?>
            <option value="<?= $row['email'] ?>">
                <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?> (<?= $row['email'] ?>)
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <label for="message">Reminder Message:</label><br>
    <textarea name="message" id="message" rows="6" cols="50" placeholder="Enter reminder message..." required></textarea>

    <br><br>

    <button type="submit">Send Reminder</button>
</form>
</body>
</html>