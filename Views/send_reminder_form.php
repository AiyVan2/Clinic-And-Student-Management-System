<?php require_once '../Config/db.php'; 
// Fetch all students with status 'Monitoring'
$query = "SELECT email, first_name, last_name FROM student_health_records WHERE status = 'For Monitoring'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Health Reminder</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- Navbar -->
       <?php include '../includes/navbar.php';?>
        <!-- Main Content Area -->
        <div class="flex-1 p-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-bell text-blue-600 mr-2"></i>Send Health Reminders
            </h1>
            <!-- <a href="admin_dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Records
            </a> -->
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Send to All Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-users text-green-600 mr-2"></i>Send to All Students
                </h2>
                <form action="../Controllers/send_reminders_all.php" method="POST">
                    <div class="mb-4">
                        <label for="all-message" class="block text-sm font-medium text-gray-700 mb-2">Reminder Message:</label>
                        <textarea 
                            name="message" 
                            id="all-message" 
                            rows="8" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter message to send to all students..."
                            required
                        ></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow transition duration-200 flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i> Send to All
                        </button>
                    </div>
                </form>
            </div>

            <!-- Send to Specific Student Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                    <i class="fas fa-user-md text-blue-600 mr-2"></i>Send to Specific Student (For Monitoring)
                </h2>
                <form action="../Controllers/send_reminders_monitoring_students.php" method="POST">
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Select Student:</label>
                        <select 
                            name="email" 
                            id="email" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                            <option value="">-- Select Student --</option>
                            <?php if($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($row['email']) ?>">
                                        <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?> (<?= htmlspecialchars($row['email']) ?>)
                                    </option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="" disabled>No students found for monitoring</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="specific-message" class="block text-sm font-medium text-gray-700 mb-2">Reminder Message:</label>
                        <textarea 
                            name="message" 
                            id="specific-message" 
                            rows="8" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter personalized reminder message..."
                            required
                        ></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition duration-200 flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i> Send Reminder
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            <p>&copy; <?php echo date('Y'); ?> School Health System</p>
        </div>
    </div>
</body>
</html>