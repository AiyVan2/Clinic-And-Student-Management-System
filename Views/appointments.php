<?php include_once '../Config/db.php'; // Make sure path is correct

// Handle filtering
$whereConditions = [];
$params = [];

if (isset($_GET['date']) && !empty($_GET['date'])) {
    $whereConditions[] = "appointment_date = ?";
    $params[] = $_GET['date'];
}

if (isset($_GET['status']) && !empty($_GET['status'])) {
    $whereConditions[] = "status = ?";
    $params[] = $_GET['status'];
}

// Build query
$query = "SELECT * FROM appointment_requests";
if (!empty($whereConditions)) {
    $query .= " WHERE " . implode(" AND ", $whereConditions);
}
$query .= " ORDER BY appointment_date ASC, appointment_time ASC";

// Prepare and execute statement if there are parameters
if (!empty($params)) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Appointments</title>
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
         <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-calendar-check text-purple-600 mr-2"></i>Appointment Requests
                </h1>
                <div class="flex space-x-4">
                    <a href="admin_dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow transition duration-200 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Records
                    </a>
                </div>
            </div>
        
        <!-- Filter Controls (Moved to top) -->
        <div class="mb-6 bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-medium text-gray-700 mb-3">Filter Appointments</h3>
            <form action="" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">By Date</label>
                    <input type="date" id="date" name="date" value="<?= isset($_GET['date']) ? htmlspecialchars($_GET['date']) : '' ?>" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">By Status</label>
                    <select id="status" name="status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full">
                        <option value="">All</option>
                        <option value="pending" <?= (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="confirmed" <?= (isset($_GET['status']) && $_GET['status'] === 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <div class="grid grid-cols-2 gap-2 w-full">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition duration-200">
                            <i class="fas fa-filter mr-2"></i> Apply
                        </button>
                        <a href="<?= $_SERVER['PHP_SELF'] ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow transition duration-200 text-center">
                            <i class="fas fa-undo mr-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Appointments Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Number</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['id'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($row['student_id']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($row['email']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($row['appointment_date']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date("g:i A", strtotime($row['appointment_time'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($row['status'] == 'confirmed'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Confirmed
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php if($row['status'] === 'pending'): ?>
                                        <a href="../Controllers/approved_appointments.php?id=<?= $row['id'] ?>" 
                                           onclick="return confirm('Confirm this appointment?')"
                                           class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded-full transition duration-200">
                                            <i class="fas fa-check mr-1"></i> Confirm
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm font-medium text-gray-500">No appointment requests found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            <p>&copy; <?php echo date('Y'); ?> School Health System</p>
        </div>
    </div>
</body>
</html>