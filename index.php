<?php
include_once 'Config/db.php';

$available_slots = [
    "08:00:00" => "8:00 AM",
    "09:00:00" => "9:00 AM",
    "10:00:00" => "10:00 AM",
    "11:00:00" => "11:00 AM",
    "13:00:00" => "1:00 PM",
    "14:00:00" => "2:00 PM",
    "15:00:00" => "3:00 PM",
    "16:00:00" => "4:00 PM"
];

$minDate = date("Y-m-d", strtotime("+2 days"));
$selected_date = $_GET['date'] ?? null;
$booked_times = [];

if ($selected_date) {
    $stmt = $conn->prepare("SELECT appointment_time FROM appointment_requests WHERE appointment_date = ? AND status = 'confirmed'");
    $stmt->bind_param("s", $selected_date);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $booked_times[] = $row['appointment_time'];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Health Appointment Request</title>
    <script>
        // Auto-reload page with selected date to update available times
        function reloadWithDate() {
            const date = document.getElementById("appt_date").value;
            if (date) {
                window.location.href = "?date=" + date;
            }
        }
    </script>
</head>
<body>
    <h2>Request Health Appointment</h2>
    <form action="../Controllers/submit_schedule.php" method="POST">
        <label>Student Number:</label><br>
        <input type="text" name="student_id" required><br><br>

        <label>First Name:</label><br>
        <input type="text" name="first_name" required><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="last_name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Appointment Date:</label><br>
        <input type="date" name="appointment_date" id="appt_date" required min="<?= $minDate ?>" value="<?= $selected_date ?>" onchange="reloadWithDate()">
        
        <label>Appointment Time:</label><br>
        <select name="appointment_time" required>
            <option value="">-- Select Time Slot --</option>
            <?php foreach ($available_slots as $time => $label): ?>
                <?php if (!in_array($time, $booked_times)): ?>
                    <option value="<?= $time ?>"><?= $label ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Submit Request">
    </form>
</body>
</html>
