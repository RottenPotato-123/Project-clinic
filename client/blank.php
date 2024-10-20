<?php
session_start();

// Determine the user type
$user_type = $_GET['role'] ?? (isset($_SESSION['userType']) ? $_SESSION['userType'] : null);

// Function to check if user is client
if ($user_type !== 'Client') {
    // Redirect to an unauthorized access page or display an error message
    header('Location: Project-clinic/login.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #2AAA8A; }
        .cta-btn { color: #2AAA8A; }
        .upgrade-btn { background: #50C878; }
        .upgrade-btn:hover { background: #fcfcfc; }
        .active-nav-link { background: #50C878; }
        .nav-item:hover { background: #50C878; }
        .account-link:hover { background: #2AAA8A; }
    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">

        <!-- Blank page content for clients -->
        <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
            <div class="p-6">
                <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Client</a>
                <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-plus mr-3"></i> New Report
                </button>
            </div>
            <nav class="text-white text-base font-semibold pt-3">
                <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>
                <a href="blank.php" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i> Blank Page
                </a>
               
              
               
                <a href="calendar.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-calendar mr-3"></i> Calendar
                </a>
            </nav>
           
        </aside>

        <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
            <!-- Desktop Header -->
            <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
                <div class="w-1/2"></div>
                <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen" class="relative z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none bg-gray-300 flex items-center justify-center text-white font-bold text-xl">
    <?php 
    // Initialize the initials variable
    $initials = "?"; // Fallback if no name is available

    // Check if session variable is set
    if (isset($_SESSION['name'])) {
        // Get the full name from the session
        $full_name = htmlspecialchars($_SESSION['name']); 

        // Get the first letter of the first name
        $first_name = strtok($full_name, ' '); // Get the first part of the full name

        // Check if $first_name is set
        if ($first_name) {
            $initials = strtoupper(substr($first_name, 0, 1)); // First name initial
        }
    }
    echo $initials; // Display the initials in the button
    ?>
</button>
                    <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                    <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                        <a href="userSetting.php" class="block px-4 py-2 account-link hover:text-white">Account</a>
                        <a href="#" class="block px-4 py-2 account-link hover:text-white">Support</a>
                        <a href="logout.php" class="block px-4 py-2 account-link hover:text-white">Sign Out</a>
                    </div>
                </div>
            </header>

            <!-- Mobile Header & Nav -->
            <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
                <div class="flex items-center justify-between">
                    <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Client</a>
                    <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                        <i x-show="!isOpen" class="fas fa-bars"></i>
                        <i x-show="isOpen" class="fas fa-times"></i>
                    </button>
                </div>
                <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                    <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                    <a href="blank.php" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
                        <i class="fas fa-sticky-note mr-3"></i> Blank Page
                    </a>
                   
                    <a href="calendar.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-calendar mr-3"></i> Calendar
                    </a>
                    <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-cogs mr-3"></i> Support
                    </a>
                    <a href="userSetting.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-user mr-3"></i> My Account
                    </a>
                    <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-sign-out-alt mr-3"></i> Sign Out
                    </a>
                   
                </nav>
            </header>
<main>
<div class="bg-white py-8 px-2 sm:px-4 lg:max-w-7xl lg:mx-auto lg:px-8">
    <!-- Month-Year Title -->
    <p class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4 text-center" id="month-year"></p>
    
    <!-- Days of the Week (abbreviated to fit mobile) -->
    <div class="grid grid-cols-7 gap-1 text-center mb-2">
        <p class="text-xs sm:text-sm md:text-base font-medium text-gray-800 uppercase">M</p>
        <p class="text-xs sm:text-sm md:text-base font-medium text-gray-800 uppercase">T</p>
        <p class="text-xs sm:text-sm md:text-base font-medium text-gray-800 uppercase">W</p>
        <p class="text-xs sm:text-sm md:text-base font-medium text-gray-800 uppercase">T</p>
        <p class="text-xs sm:text-sm md:text-base font-medium text-gray-800 uppercase">F</p>
        <p class="text-xs sm:text-sm md:text-base font-medium text-gray-800 uppercase">S</p>
        <p class="text-xs sm:text-sm md:text-base font-medium text-gray-800 uppercase">S</p>
    </div>

    <!-- Calendar Days -->
    <div class="grid grid-cols-3 sm:grid-cols-7 gap-1 sm:gap-2" id="calendar-days">
        <!-- dynamically generated days will go here -->
    </div>
</div>




<div class="fixed top-0 left-0 w-full h-full bg-gray-200 bg-opacity-50 hidden" id="modal-overlay">
  <!-- Modal Content -->
  <div class="bg-white rounded shadow-md w-full sm:w-4/5 md:w-1/2 lg:w-1/3 h-auto p-4 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
    <!-- Header -->
    <h2 class="text-3xl font-bold text-gray-800 mb-4">New Appointment</h2>
    <!-- Form -->
    <form action="add_appointment.php" method="post">
      <!-- Input Fields -->
      <input type="hidden" id="appointment_date" name="appointment_date" />

      <div class="mb-4">
        <label for="FirstName" class="block mb-2 text-gray-700">First Name:</label>
        <input type="text" id="FirstName" name="FirstName" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded" required>
      </div>
      <div class="mb-4">
        <label for="MiddleName" class="block mb-2 text-gray-700">Middle Name:</label>
        <input type="text" id="MiddleName" name="MiddleName" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="LastName" class="block mb-2 text-gray-700">Last Name:</label>
        <input type="text" id="LastName" name="LastName" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded" required>
      </div>
      <div class="mb-4">
        <label for="Age" class="block mb-2 text-gray-700">Age:</label>
        <input type="number" id="Age" name="Age" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded" required>
      </div>
      <div class="mb-4">
        <label for="civilstatus" class="block mb-2 text-gray-700">Civil status:</label>
        <select id="civilstatus" name="civilstatus" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded" required>
          <option value="Single">Single</option>
          <option value="Married">Married</option>
          <option value="Separated">Separated</option>
          <option value="Widowed">Widowed</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="date" class="block mb-2 text-gray-700">Birthdate:</label>
        <input type="date" id="date" name="date" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded" required>
      </div>
      <div class="mb-4">
        <label for="Birthplace" class="block mb-2 text-gray-700">Birthplace:</label>
        <input type="text" id="Birthplace" name="Birthplace" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded" required>
      </div>
      <!-- Select Field -->
      <div class="mb-4">
        <label for="service" class="block mb-2 text-gray-700">Service:</label>
        <select id="service" name="service" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded" required>
          <option value="Counselling">Counselling</option>
          <option value="Family Planning">Family Planning</option>
          <option value="Ear Piercing">Ear Piercing</option>
          <option value="Immunization">Immunization</option>
          <option value="Acid Wash">Acid Wash</option>
        </select>
      </div>
      <!-- Submit Button -->
      <button type="submit" name="add_appointment" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Book Appointment</button>
    </form>
    <!-- Close Button -->
    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded absolute top-0 right-0" onclick="document.getElementById('modal-overlay').classList.toggle('hidden')">Close</button>
  </div>
</div>
 
</main>
</body>
<script>
const monthNames = ["January", "February", "March", "April", "May", "June", 
                    "July", "August", "September", "October", "November", "December"];

// Get the current date
const currentDate = new Date();

// Get the date 4 days from now
const fourDaysFromNow = new Date(currentDate);
fourDaysFromNow.setDate(currentDate.getDate() + 4);

// Display the month and year
document.getElementById("month-year").textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

// Generate calendar days
const calendarDays = [];
for (let i = 1; i <= 31; i++) { 
    const day = new Date(currentDate.getFullYear(), currentDate.getMonth(), i);
    if (day.getMonth() === currentDate.getMonth()) {
        calendarDays.push(day.getDate());
    }
}

// Update calendar days in HTML
const calendarContainer = document.getElementById("calendar-days");
calendarDays.forEach((day) => {
    const dayElement = document.createElement("div");
    dayElement.className = "w-full h-16 sm:h-20 p-2 border border-gray-200 flex items-center justify-center";

    // Create a paragraph element for the date
    const dayText = document.createElement("p"); // Define dayText here
    dayText.className = "text-sm font-medium text-gray-800"; // Text styling

    // Highlight the current date
    if (day === currentDate.getDate()) {
        dayElement.classList.add("bg-red-100"); // Highlight current date in red
        dayText.textContent = `${day} Today`; // Add "Today" text
    } 
    // Highlight the date 4 days from now
    else if (day === fourDaysFromNow.getDate() && currentDate.getMonth() === fourDaysFromNow.getMonth()) {
        dayElement.classList.add("bg-green-100"); // Add a green background for the date 4 days from now
        dayText.textContent = `${day} BookThisDay and onwards`; // Add "In 4 Days" text
    } 
    // Default case for other dayss
    else {
        dayText.textContent = `${day}`; // Just display the day
    }

    // Append the text to the day element
    dayElement.appendChild(dayText);

    dayElement.addEventListener("click", () => {
        const selectedDate = `${monthNames[currentDate.getMonth()]} ${day}, ${currentDate.getFullYear()}`;
        console.log('Selected date:', selectedDate);
        document.getElementById("appointment_date").value = selectedDate;

        // Send the selected date to your PHP script using AJAX or form submission
        fetch('date.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'date=' + encodeURIComponent(selectedDate)
        })
        .then(response => response.text())
        .then(data => console.log('Response from PHP script:', data));

        const modalOverlay = document.getElementById("modal-overlay");
        modalOverlay.classList.remove("hidden");
    });

    calendarContainer.appendChild(dayElement);
});

// add an event listener to close the modal window
document.getElementById("close-modal").addEventListener("click", () => {
    const modalOverlay = document.getElementById("modal-overlay");
    modalOverlay.classList.add("hidden");
});
</script>
 <!-- AlpineJS -->
 <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <!-- Font Awesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</html>
