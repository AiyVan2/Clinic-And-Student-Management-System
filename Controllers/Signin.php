<?php
session_start();
require_once '../Config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password were sent from the form
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Use prepared statements for security
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password); // Bind parameters to the statement
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // Login successful
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            
            header('Location:../Views/tite.html');
        } else {
            // Login failed, redirect or show error
            header('Location:../index.html');
        }
    }
}
?>
