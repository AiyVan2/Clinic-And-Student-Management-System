<?php
require_once '../Config/db.php'; // adjust path if needed

// Fetch counts from the database

// Total students
$studentsResult = $conn->query("SELECT COUNT(*) as total_students FROM student_health_records");
$students = $studentsResult->fetch_assoc()['total_students'] ?? 0;

// Pending Appointments
$pendingAppointmentsResult = $conn->query("SELECT COUNT(*) as pending_appointments FROM appointment_requests WHERE status = 'pending'");
$pendingAppointments = $pendingAppointmentsResult->fetch_assoc()['pending_appointments'] ?? 0;

// Students Fit For School
$fitStudentsResult = $conn->query("SELECT COUNT(*) as fit_students FROM student_health_records WHERE status = 'Fit For School'");
$fitStudents = $fitStudentsResult->fetch_assoc()['fit_students'] ?? 0;

// Students For Monitoring
$monitoringStudentsResult = $conn->query("SELECT COUNT(*) as monitoring_students FROM student_health_records WHERE status = 'For Monitoring'");
$monitoringStudents = $monitoringStudentsResult->fetch_assoc()['monitoring_students'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Navbar -->
        <?php include '../includes/navbar.php'; ?>
        
        <div class="flex-1 p-8">
            <div class=" mb-6 p-6">
                <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-tachometer-alt text-green-600 mr-3"></i>Dashboard
                </h1>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Total Students -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full text-green-600 mr-4">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700">Total Students</h2>
                            <p class="text-2xl font-bold text-gray-900"><?= $students ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Pending Appointments -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-full text-yellow-600 mr-4">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700">Pending Appointments</h2>
                            <p class="text-2xl font-bold text-gray-900"><?= $pendingAppointments ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Students Fit For School -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600 mr-4">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700">Fit For School</h2>
                            <p class="text-2xl font-bold text-gray-900"><?= $fitStudents ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Students for Monitoring -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500 hover:shadow-lg transition duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-full text-red-600 mr-4">
                            <i class="fas fa-procedures fa-2x"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700">For Monitoring</h2>
                            <p class="text-2xl font-bold text-gray-900"><?= $monitoringStudents ?></p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>
