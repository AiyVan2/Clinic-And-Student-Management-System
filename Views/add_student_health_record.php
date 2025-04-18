<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Health Record</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-green-600 py-4 px-6">
                <h1 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-file-medical mr-3"></i>Add Student Health Record
                </h1>
            </div>
            
            <form action="../Controllers/add_health_record.php" method="POST" class="py-6 px-8">
                <!-- Form divided into sections -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information Section -->
                    <div class="col-span-2 border-b border-gray-200 pb-4 mb-4">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-user-circle text-green-600 mr-2"></i>Personal Information
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="student_id" class="block text-gray-700 text-sm font-medium mb-2">Student ID <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                    <input type="number" name="student_id" id="student_id" required class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" id="email" required class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="first_name" class="block text-gray-700 text-sm font-medium mb-2">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" id="first_name" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            </div>

                            <div class="mb-4">
                                <label for="last_name" class="block text-gray-700 text-sm font-medium mb-2">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" id="last_name" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            </div>

                            <div class="mb-4">
                                <label for="gender" class="block text-gray-700 text-sm font-medium mb-2">Gender <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-venus-mars text-gray-400"></i>
                                    </div>
                                    <select name="gender" id="gender" required class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="date_of_birth" class="block text-gray-700 text-sm font-medium mb-2">Date of Birth <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input type="date" name="date_of_birth" id="date_of_birth" required class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="blood_type" class="block text-gray-700 text-sm font-medium mb-2">Blood Type</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tint text-gray-400"></i>
                                    </div>
                                    <select type="text" name="blood_type" id="blood_type" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                    <option value="">Select</option>
                                    <option value="A+">A+</option>
                                    <option value="O+">O+</option>
                                    <option value="B+">B+</option>
                                    <option value="AB+">AB+</option>
                                    <option value="A-">A-</option>
                                    <option value="O-">O-</option>
                                    <option value="B-">B-</option>
                                    <option value="AB-">AB-</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Information Section -->
                    <div class="col-span-2 border-b border-gray-200 pb-4 mb-4">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-notes-medical text-green-600 mr-2"></i>Medical Information
                        </h2>

                        <div class="mb-4">
                            <label for="allergies" class="block text-gray-700 text-sm font-medium mb-2">Allergies</label>
                            <textarea name="allergies" id="allergies" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="List any allergies here..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="medical_conditions" class="block text-gray-700 text-sm font-medium mb-2">Medical Conditions</label>
                            <textarea name="medical_conditions" id="medical_conditions" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="List any existing medical conditions..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="vaccinations" class="block text-gray-700 text-sm font-medium mb-2">Vaccinations</label>
                            <textarea name="vaccinations" id="vaccinations" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="List vaccinations received..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="last_checkup_date" class="block text-gray-700 text-sm font-medium mb-2">Last Checkup Date</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-stethoscope text-gray-400"></i>
                                    </div>
                                    <input type="date" name="last_checkup_date" id="last_checkup_date" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="block text-gray-700 text-sm font-medium mb-2">Status <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-check-circle text-gray-400"></i>
                                    </div>
                                    <select name="status" id="status" required class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                        <option value="Fit For School">Fit For School</option>
                                        <option value="For Monitoring">For Monitoring</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="health_status" class="block text-gray-700 text-sm font-medium mb-2">Health Status</label>
                            <textarea name="health_status" id="health_status" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="Additional health status information..."></textarea>
                        </div>
                    </div>

                    <!-- Emergency Contacts Section -->
                    <div class="col-span-2">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                            <i class="fas fa-phone-alt text-green-600 mr-2"></i>Emergency & Medical Contacts
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="emergency_contact_name" class="block text-gray-700 text-sm font-medium mb-2">Emergency Contact Name</label>
                                <input type="text" name="emergency_contact_name" id="emergency_contact_name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            </div>

                            <div class="mb-4">
                                <label for="emergency_contact_phone" class="block text-gray-700 text-sm font-medium mb-2">Emergency Contact Phone</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="physician_name" class="block text-gray-700 text-sm font-medium mb-2">Physician Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user-md text-gray-400"></i>
                                    </div>
                                    <input type="text" name="physician_name" id="physician_name" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="physician_phone" class="block text-gray-700 text-sm font-medium mb-2">Physician Phone</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel" name="physician_phone" id="physician_phone" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end">
                    <a href="admin_dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2 inline-flex items-center transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i> Cancel
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center transition duration-200">
                        <i class="fas fa-save mr-2"></i> Submit Record
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Auto-format phone number inputs
    document.querySelectorAll('input[type="tel"]').forEach(function(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 3) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.slice(0, 3) + '-' + value.slice(3);
                } else {
                    value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                }
                e.target.value = value;
            }
        });
    });
    </script>
</body>
</html>