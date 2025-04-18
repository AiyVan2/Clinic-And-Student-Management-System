<?php
include_once '../Config/db.php'; // Make sure path is correct
$result = $conn->query("SELECT * FROM appointment_requests ORDER BY appointment_date ASC, appointment_time ASC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Appointments</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background-color: #eee; }
        .confirmed { color: green; font-weight: bold; }
        .pending { color: orange; }
    </style>
</head>
<body>
    <h2>Appointment Requests</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Number</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                <td><?= $row['student_id'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['appointment_date'] ?></td>
                <td><?= date("g:i A", strtotime($row['appointment_time'])) ?></td>
                <td class="<?= $row['status'] == 'confirmed' ? 'confirmed' : 'pending' ?>">
                    <?= ucfirst($row['status']) ?>
                </td>
                <td>
                    <?php if ($row['status'] === 'pending'): ?>
                        <a href="../Controllers/approved_appointments.php?id=<?=  $row['id'] ?>" onclick="return confirm('Confirm this appointment?')">Confirm</a>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>