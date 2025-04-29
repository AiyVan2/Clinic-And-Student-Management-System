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
        $hour = substr($row['appointment_time'], 0, 2); // Get hour only
        if (!isset($booked_times[$hour])) {
            $booked_times[$hour] = 0;
        }
        $booked_times[$hour]++;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Clinic - Health Appointments</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #16a34a 0%, #059669 100%);
        }
        
        .nav-gradient {
            background: linear-gradient(90deg, #16a34a 0%, #059669 100%);
        }
        
        .service-card {
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .form-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        
        .btn-gradient {
            background: linear-gradient(90deg, #16a34a 0%, #059669 100%);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(90deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .service-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: rgba(16, 185, 129, 0.1);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .service-card:hover .service-icon {
            background-color: rgba(16, 185, 129, 0.2);
            transform: scale(1.1);
        }
        
        .footer-link {
            transition: all 0.2s;
        }
        
        .footer-link:hover {
            color: #d1fae5;
        }
        
        /* Custom Date and Select Styling */
        input[type="date"], select {
            appearance: none;
            /* background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2316a34a'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E"); */
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
            padding-right: 2.5rem;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Active nav highlight */
        .nav-active {
            font-weight: 600;
            position: relative;
        }
        
        .nav-active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: white;
            border-radius: 2px;
        }
    </style>
    <script>
        // Auto-reload page with selected date to update available times
        function reloadWithDate() {
            const date = document.getElementById("appt_date").value;
            if (date) {
                window.location.href = "?date=" + date;
            }
        }
        
        // For the AJAX version - keep for future implementation
        function getAvailableTimes(date) {
            // This function can be expanded later for AJAX functionality
            console.log("Selected date: " + date);
        }
    </script>
</head>
<body class="bg-gray-50">

    <!-- Navigation Bar with subtle gradient -->
    <nav class="nav-gradient p-4 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
            <a href="#" class="text-white text-2xl font-bold flex items-center mb-4 md:mb-0">
                <!-- <i class="fas fa-heartbeat mr-2 text-3xl"></i> -->
                <img src ="Images/Zelene_Logo.png" alt= "Zelene logo" width="40" height="auto" style="margin-right:10px">
                <span>School Clinic</span>
            </a>
            <ul class="flex flex-wrap space-x-2 md:space-x-8 text-center">
                <li><a href="index.php" class="text-white hover:text-green-100 px-3 py-2 rounded-lg nav-active">Home</a></li>
                <li><a href="#services" class="text-white hover:text-green-100 px-3 py-2 rounded-lg">Services</a></li>
                <li><a href="#appointment" class="text-white hover:text-green-100 px-3 py-2 rounded-lg">Appointment</a></li>
                <li><a href="#contact" class="text-white hover:text-green-100 px-3 py-2 rounded-lg">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero-gradient text-white py-16 md:py-24">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 text-center md:text-left mb-8 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">Your Health is Our Priority</h1>
                <p class="mt-4 text-lg md:text-xl text-green-100">Book your health appointment easily and receive the care you need.</p>
                <a href="#appointment" class="mt-8 inline-block px-6 py-3 bg-white text-green-600 font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    Book Appointment
                </a>
            </div>
            <!-- <div class="md:w-1/2 flex justify-center">
                <div class="w-full max-w-md">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full">
                        <path fill="#ffffff" d="M40,-65.5C52.5,-59.5,63.8,-50.4,72.6,-38.4C81.4,-26.4,87.7,-11.5,87.8,3.7C87.9,18.8,81.8,34.3,72.1,47.1C62.3,59.9,49,70.1,34.2,76.1C19.4,82,3.1,83.8,-13.2,81.5C-29.6,79.1,-46,72.6,-58.4,61.4C-70.8,50.2,-79.2,34.4,-83.2,17.5C-87.3,0.5,-87,-17.6,-80.3,-32.3C-73.7,-47,-60.8,-58.3,-46.3,-63.6C-31.8,-68.9,-15.9,-68.3,-0.3,-67.8C15.3,-67.4,30.6,-67,40,-65.5Z" transform="translate(100 100)" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-user-md text-green-600 text-6xl"></i>
                    </div>
                </div>
            </div> -->
        </div>
    </section>

    <!-- Services Section with hoverable cards -->
    <section id="services" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Our Services</h2>
                <div class="h-1 w-24 bg-green-500 mx-auto mt-4 rounded-full"></div>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">We offer a range of healthcare services to support our school community</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="service-card bg-white p-8 rounded-xl shadow-md text-center">
                    <div class="service-icon mx-auto">
                        <i class="fas fa-stethoscope text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">General Checkup</h3>
                    <p class="text-gray-600">Comprehensive health assessments to ensure your wellbeing and identify any potential concerns.</p>
                </div>
                
                <div class="service-card bg-white p-8 rounded-xl shadow-md text-center">
                    <div class="service-icon mx-auto">
                        <i class="fas fa-prescription-bottle-alt text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Medical Prescriptions</h3>
                    <p class="text-gray-600">Get necessary medication prescriptions from our qualified healthcare providers.</p>
                </div>
                
                <div class="service-card bg-white p-8 rounded-xl shadow-md text-center">
                    <div class="service-icon mx-auto">
                        <i class="fas fa-heartbeat text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Emergency Care</h3>
                    <p class="text-gray-600">Immediate medical assistance for urgent health concerns within school hours.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Appointment Section with elegant form -->
    <section id="appointment" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Book Your Appointment</h2>
                <div class="h-1 w-24 bg-green-500 mx-auto mt-4 rounded-full"></div>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Schedule a visit with our healthcare professionals</p>
            </div>
            
            <div class="max-w-2xl mx-auto">
                <form action="Controllers/submit_schedule.php" method="POST" class="form-container bg-white p-8 rounded-xl shadow-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Student Number</label>
                            <input type="text" name="student_id" id="student_id" required 
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none">
                        </div>
                        
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" name="first_name" id="first_name" required 
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none">
                        </div>
                        
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" name="last_name" id="last_name" required 
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" id="email" required 
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none">
                        </div>
                        
                        <div>
                            <label for="appt_date" class="block text-sm font-medium text-gray-700 mb-2">Appointment Date</label>
                            <input type="date" name="appointment_date" id="appt_date" required 
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none"
                                min="<?= $minDate ?>" value="<?= $selected_date ?>" onchange="reloadWithDate()">
                        </div>
                        
                        <div>
                            <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">Appointment Time</label>
                            <select name="appointment_time" id="appointment_time" required 
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none">
                                <option value="">-- Select Time Slot --</option>
                                <?php foreach ($available_slots as $time => $label): ?>
    <?php
        $hour = substr($time, 0, 2);
        $count = $booked_times[$hour] ?? 0;
        $remaining = 10 - $count;
    ?>
    <?php if ($remaining > 0): ?>
        <option value="<?= $time ?>">
            <?= $label ?> (<?= $remaining ?> slot<?= $remaining > 1 ? 's' : '' ?> left)
        </option>
    <?php endif; ?>
<?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <button type="submit" class="btn-gradient w-full py-3 text-white font-semibold rounded-lg text-lg">
                            Schedule Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Contact Us Section with modern icons -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Contact Us</h2>
                <div class="h-1 w-24 bg-green-500 mx-auto mt-4 rounded-full"></div>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Have questions? Get in touch with our team</p>
            </div>
            
            <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-xl shadow-md text-center">
                    <div class="inline-block p-4 rounded-full bg-green-100 mb-4">
                        <i class="fas fa-map-marker-alt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Our Location</h3>
                    <p class="text-gray-600">School Campus<br>Health Building, Room 101</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl shadow-md text-center">
                    <div class="inline-block p-4 rounded-full bg-green-100 mb-4">
                        <i class="fas fa-phone-alt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Phone Number</h3>
                    <p class="text-gray-600">+123 456 7890<br>Mon-Fri: 8am - 5pm</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl shadow-md text-center">
                    <div class="inline-block p-4 rounded-full bg-green-100 mb-4">
                        <i class="fas fa-envelope text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Email Address</h3>
                    <p class="text-gray-600">clinic@school.com<br>health@school.com</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer with pattern background -->
    <footer class="bg-green-600 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <a href="#" class="text-2xl font-bold flex items-center">
                        <!-- <i class="fas fa-heartbeat mr-2"></i> -->
                        <img src ="Images/Zelene_Logo.png" alt= "Zelene logo" width="35" height="auto" style="margin-right:10px">
                        <span>School Clinic</span>
                    </a>
                    <p class="mt-2 text-green-100">Taking care of your health needs</p>
                </div>
                
                <div class="flex space-x-4">
                    <a href="#" class="footer-link h-10 w-10 flex items-center justify-center bg-green-700 rounded-full">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="footer-link h-10 w-10 flex items-center justify-center bg-green-700 rounded-full">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="footer-link h-10 w-10 flex items-center justify-center bg-green-700 rounded-full">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
            
            <div class="border-t border-green-500 mt-6 pt-6 text-center md:flex md:justify-between md:text-left">
                <p>&copy; 2025 School Clinic. All Rights Reserved.</p>
                <div class="mt-4 md:mt-0">
                    <a href="#" class="inline-block mx-2 footer-link">Privacy Policy</a>
                    <a href="#" class="inline-block mx-2 footer-link">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80, // Offset for sticky navbar
                        behavior: 'smooth'
                    });
                    
                    // Update active nav link
                    document.querySelectorAll('nav a').forEach(navLink => {
                        navLink.classList.remove('nav-active');
                    });
                    this.classList.add('nav-active');
                }
            });
        });
        
        // Highlight current section in navbar based on scrolling
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('nav a');
            
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                const sectionHeight = section.clientHeight;
                
                if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('nav-active');
                if (link.getAttribute('href') === '#' + current || (current === '' && link.getAttribute('href') === '#')) {
                    link.classList.add('nav-active');
                }
            });
        });
    </script>
</body>
</html>