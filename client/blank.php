<?php
session_start();

// Determine the user type
$user_type = $_GET['role'] ?? (isset($_SESSION['userType']) ? $_SESSION['userType'] : null);

// Function to check if user is client


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
        .bg-sidebar { background: #3d68ff; }
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
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
            <a href="#" class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center justify-center py-4">
                <i class="fas fa-arrow-circle-up mr-3"></i> Upgrade to Pro!
            </a>
        </aside>

        <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
            <!-- Desktop Header -->
            <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
                <div class="w-1/2"></div>
                <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                    <button @click="isOpen = !isOpen" class="relative z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                        <img src="https://source.unsplash.com/uJ8LNVCBjFQ/400x400" alt="Profile">
                    </button>
                    <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                    <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                        <a href="#" class="block px-4 py-2 account-link hover:text-white">Account</a>
                        <a href="#" class="block px-4 py-2 account-link hover:text-white">Support</a>
                        <a href="logout.php" class="block px-4 py-2 account-link hover:text-white">Sign Out</a>
                    </div>
                </div>
            </header>

            <!-- Mobile Header & Nav -->
            <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
                <div class="flex items-center justify-between">
                    <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
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
                    <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-user mr-3"></i> My Account
                    </a>
                    <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-sign-out-alt mr-3"></i> Sign Out
                    </a>
                   
                </nav>
            </header>

            <div class="bg-white md:py-8 px-4 lg:max-w-7xl lg:mx-auto lg:px-8">
    <p class="text-4xl font-bold text-gray-800 mb-8" id="month-year"></p>
    <div class="inline-flex flex-col space-y-1 items-start justify-start h-full w-full">
        <!-- days of the week -->
        <div class="inline-flex space-x-28 items-start justify-start pr-24 h-full w-full">
            <p class="w-12 h-full text-sm font-medium text-gray-800 uppercase">M</p>
            <p class="w-12 h-full text-sm font-medium text-gray-800 uppercase">T</p>
            <p class="w-12 h-full text-sm font-medium text-gray-800 uppercase">W</p>
            <p class="w-12 h-full text-sm font-medium text-gray-800 uppercase">T</p>
            <p class="w-12 h-full text-sm font-medium text-gray-800 uppercase">F</p>
            <p class="w-12 h-full text-sm font-medium text-gray-800 uppercase">S</p>
            <p class="w-12 h-full text-sm font-medium text-gray-800 uppercase">S</p>
        </div>
        <!-- calendar days -->
        <div class="flex flex-wrap items-start justify-start" id="calendar-days">
            <!-- generate calendar days here -->
        </div>
    </div>
</div>

<!-- add a modal window for the appointment form -->
<div class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden" id="modal-overlay">
  <div class="bg-white w-1/2 h-1/2 p-4 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">New Appointment</h2>
    <form>
      <label for="title">Title:</label>
      <input type="text" id="title" name="title"><br><br>
      <label for="description">Description:</label>
      <textarea id="description" name="description"></textarea><br><br>
      <label for="service">Service:</label>
      <select id="service" name="service">
        <option value="Counselling">Counselling</option>
        <option value="Family Planning">Family Planning</option>
        <option value="Ear Piercing">Ear Piercing</option>
        <option value="Immunization">Immunization</option>
        <option value="Acid Wash">Acid Wash</option>
      </select><br><br>
      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
    </form>
    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded absolute top-0 right-0" onclick="document.getElementById('modal-overlay').classList.toggle('hidden')">Close</button>
  </div>
</div>       

</body>
<script>
const currentDate = new Date();
const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

document.getElementById("month-year").textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

// generate calendar days
const calendarDays = [];
for (let i = 1; i <= 31; i++) {
    const day = new Date(currentDate.getFullYear(), currentDate.getMonth(), i);
    if (day.getMonth() === currentDate.getMonth()) {
        calendarDays.push(day.getDate());
    }
}

// update calendar days in HTML
const calendarContainer = document.getElementById("calendar-days");
calendarDays.forEach((day) => {
    const dayElement = document.createElement("div");
    dayElement.className = "w-40 h-20 pl-2 pr-32 pt-2.5 pb-24 border border-gray-200";
    if (day === currentDate.getDate()) {
        dayElement.className += " bg-red-100"; // add a highlighted class for the current date
    }
    dayElement.innerHTML = `<p class="text-sm font-medium text-gray-800">${day}</p>`;
    dayElement.addEventListener("click", () => {
        // show the modal window when a day is clicked
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
