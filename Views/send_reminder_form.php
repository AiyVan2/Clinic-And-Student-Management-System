<?php
session_start();
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
</body>
</html>