<?php
session_start(); // Start the session

// Get user type and status from GET parameters or session
$user_type = $_GET['role'] ?? $_SESSION['userType'] ?? null; 
$status = $_GET['stats'] ?? $_SESSION['status'] ?? null;

// Function to check if user is a client and status is active
if ($user_type !== 'Client'|| $status !== 'active' ) {
    // Redirect to an unauthorized access page or display an error message
    header('Location: ../login.php');
    exit; // Ensure no further code is executed
}

// If the user is a client and active, continue with the page logic
// Your page content goes here
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
        .upgrade-btn:hover { background: #ffffff; }
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
                    <i ></i> Chit's Clinic
                </button>
            </div>
            <nav class="text-white text-base font-semibold pt-3">
                <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-hashtag mr-3"></i> Queuing
                </a>
                <a href="blank.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-calendar mr-3"></i> Calendar
                </a>
               
              
               
                <a href="calendar.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-table mr-3"></i> Appointments
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
                        <i class="fas fa-tachometer-alt mr-3"></i> Queuing
                    </a>
                    <a href="blank.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-sticky-note mr-3"></i> Calendar
                    </a>    
                   
                    <a href="calendar.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-calendar mr-3"></i> Calendar
                    </a>
                    
                    <a href="userSetting.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-user mr-3"></i> My Account
                    </a>
                    <a href="logout.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-sign-out-alt mr-3"></i> Sign Out
                    </a>
                   
                </nav>
            </header>
            <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Calendar</h1>

        <div class="w-full">
            <div class="antialiased sans-serif bg-gray-100">
                <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                    <div class="container py-2">
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="flex items-center justify-between py-2 px-6">
                                <div>
                                    <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                                    <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                                </div>
                                <div class="border rounded-lg px-1" style="padding-top: 2px;">
                                    <button 
                                        type="button"
                                        class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center" 
                                        :class="{'cursor-not-allowed opacity-25': month == 0 }"
                                        :disabled="month == 0 ? true : false"
                                        @click="month--; getNoOfDays()">
                                        <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>  
                                    </button>
                                    <div class="border-r inline-flex h-6"></div>		
                                    <button 
                                        type="button"
                                        class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex items-center cursor-pointer hover:bg-gray-200 p-1" 
                                        :class="{'cursor-not-allowed opacity-25': month == 11 }"
                                        :disabled="month == 11 ? true : false"
                                        @click="month++; getNoOfDays()">
                                        <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>									  
                                    </button>
                                </div>
                            </div>	

                            <div class="-mx-1 -mb-1">
                                <div class="flex flex-wrap" style="margin-bottom: -40px;">
                                    <template x-for="(day, index) in DAYS" :key="index">	
                                        <div style="width: 14.26%" class="px-2 py-2">
                                            <div
                                                x-text="day" 
                                                class="text-gray-600 text-sm uppercase tracking-wide font-bold text-center"></div>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex flex-wrap border-t border-l">
                                    <template x-for="blankday in blankdays">
                                        <div 
                                            style="width: 14.28%; height: 120px"
                                            class="text-center border-r border-b px-4 pt-2"	
                                        ></div>
                                    </template>	
                                    <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">	
                                        <div style="width: 14.28%; height: 120px" class="px-4 pt-2 border-r border-b relative">
                                            <div
                                                @click="showEventModal(date)"
                                                x-text="date"
                                                class="inline-flex w-6 h-6 items-center justify-center cursor-pointer text-center leading-none rounded-full transition ease-in-out duration-100"
                                                :class="{
                                                    'bg-blue-500 text-white': isToday(date),
                                                    'text-gray-700 hover:bg-blue-200': !isToday(date),
                                                    'bg-green-200': isWithinBookingRange(date) // New condition for booking days
                                                }"
                                            ></div>
                                            <div style="height: 80px;" class="overflow-y-auto mt-1">
                                                <template x-if="isWithinBookingRange(date)">
                                                    <p class="text-green-800 text-sm text-center">You Can Book This Day</p> <!-- Booking text -->
                                                </template>
                                                <template x-for="event in events.filter(e => new Date(e.event_date).toDateString() ===  new Date(year, month, date).toDateString() )">	
                                                    <div
                                                        class="px-2 py-1 rounded-lg mt-1 overflow-hidden border"
                                                        :class="{
                                                            'border-blue-200 text-blue-800 bg-blue-100': event.event_theme === 'blue',
                                                            'border-red-200 text-red-800 bg-red-100': event.event_theme === 'red',
                                                            'border-yellow-200 text-yellow-800 bg-yellow-100': event.event_theme === 'yellow',
                                                            'border-green-200 text-green-800 bg-green-100': event.event_theme === 'green',
                                                            'border-purple-200 text-purple-800 bg-purple-100': event.event_theme === 'purple'
                                                        }"
                                                    >
                                                        <p x-text="event.event_title" class="text-sm truncate leading-tight"></p>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fixed top-0 left-0 w-full h-full bg-gray-200 bg-opacity-50" x-show.transition.opacity="openEventModal">
                   




         <div class="bg-white rounded shadow-md w-full sm:w-4/5 md:w-1/2 lg:w-1/3 h-auto p-4 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <!-- Header -->
        <h2 class="text-3xl font-bold text-gray-800 mb-4">New Appointment</h2>
        <!-- Form -->
        <form action="add_appointment.php" method="post">
            <!-- Input Fields -->
            <input type="hidden" id="appointment_date" name="appointment_date" />

            <div class="mb-4">
                <label for="FirstName" class="block mb-2 text-gray-700">First Name:</label>
                <input type="text" id="FirstName" name="FirstName" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="MiddleName" class="block mb-2 text-gray-700">Middle Name:</label>
                <input type="text" id="MiddleName"  placeholder="optional" name="MiddleName" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="LastName" class="block mb-2 text-gray-700">Last Name:</label>
                <input type="text" id="LastName" name="LastName" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
    <label for="Age" class="block mb-2 text-gray-700"></label>
    <input type="hidden" id="Age" name="Age" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded" required readonly>
</div>
            <div class="mb-4">
                <label for="civilstatus" class="block mb-2 text-gray-700">Civil status:</label>
                <select id="civilstatus" name="civilstatus" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded" required>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Separated">Separated</option>
                    <option value="Widowed">Widowed</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="date" class="block mb-2 text-gray-700">Birthdate:</label>
                <input type="date" id="date" name="date" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="Birthplace" class="block mb-2 text-gray-700">Birthplace:</label>
                <input type="text" id="Birthplace" name="Birthplace" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="service" class="block mb-2 text-gray-700">Service:</label>
                <select id="service" name="service" class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded" required>
                    <option value="Counselling">Counselling</option>
                    <option value="Family Planning">Family Planning</option>
                    <option value="Ear Piercing">Ear Piercing
                    <option value="Immunization">Immunization</option>
          <option value="Acid Wash">Acid Wash</option>
        </select>
      </div>
      <!-- Submit Button -->
      <button type="submit" name="add_appointment" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Book Appointment</button>
    </form>
    <!-- Close Button -->
    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded absolute top-0 right-0" onclick="document.getElementById('modal-overlay').classList.toggle('hidden')"@click="openEventModal = false">Close</button>
  </div>
</div>
                           
                    
                        </div>
                    </div>
                   
                </div>
            </main>
    
            
    </body>
<script>
    
     document.getElementById('date').addEventListener('change', function () {
    const birthDate = new Date(this.value); // Get the selected birthdate

    // Adjust for GMT+8 timezone by adding 8 hours to the UTC date
    const utcOffset = 8 * 60 * 60 * 1000; // 8 hours in milliseconds
    const adjustedBirthDate = new Date(birthDate.getTime() + utcOffset); // Adjust the birth date

    const today = new Date(); // Current date
    const adjustedToday = new Date(today.getTime() + utcOffset); // Adjust the current date

    let age = adjustedToday.getFullYear() - adjustedBirthDate.getFullYear(); // Calculate year difference
    const monthDiff = adjustedToday.getMonth() - adjustedBirthDate.getMonth(); // Calculate month difference

    // Adjust if the birthday hasn't occurred yet this year
    if (monthDiff < 0 || (monthDiff === 0 && adjustedToday.getDate() < adjustedBirthDate.getDate())) {
        age--;
    }

    document.getElementById('Age').value = age >= 0 ? age : 0; // Display age or 0 if invalid
});

const MONTH_NAMES = [
    'January', 'February', 'March', 'April', 'May', 'June', 
    'July', 'August', 'September', 'October', 'November', 'December'
];
const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

function app() {
    return {
        month: '',
        year: '',
        no_of_days: [],
        blankdays: [],
        days: DAYS,
        events: [
            {
                event_date: new Date(2020, 3, 1),
                event_title: "April Fool's Day",
                event_theme: 'blue'
            },
            {
                event_date: new Date(2020, 3, 10),
                event_title: "Birthday",
                event_theme: 'red'
            },
            {
                event_date: new Date(2020, 3, 16),
                event_title: "Upcoming Event",
                event_theme: 'green'
            }
        ],
        event_title: '',
        event_date: '',
        event_theme: 'blue',
        themes: [
            { value: "blue", label: "Blue Theme" },
            { value: "red", label: "Red Theme" },
            { value: "yellow", label: "Yellow Theme" },
            { value: "green", label: "Green Theme" },
            { value: "purple", label: "Purple Theme" }
        ],
        openEventModal: false,
        datepickerValue: '',

        // Initialize the current month and year
        initDate() {
            let today = new Date();
            this.month = today.getMonth();
            this.year = today.getFullYear();
            this.datepickerValue = today.toDateString();
            this.getNoOfDays();
        },
        isWithinBookingRange(date) {
            const today = new Date();
            const bookingStart = new Date();
            bookingStart.setDate(today.getDate() + 0); // Tomorrow

            const bookingEnd = new Date();
            bookingEnd.setDate(today.getDate() + 4); // Four days from tomorrow

            const selectedDate = new Date(this.year, this.month, date);
            return selectedDate >= bookingStart && selectedDate <= bookingEnd;
        },

        // Check if the given date is today
        isToday(date) {
            const today = new Date();
            const d = new Date(this.year, this.month, date);
            return today.toDateString() === d.toDateString();
        },

        // Open the event modal and send the selected date
        showEventModal(day) {
            const selectedDate = new Date(this.year, this.month, day);
            const formattedDate = `${MONTH_NAMES[selectedDate.getMonth()]} ${selectedDate.getDate()}, ${selectedDate.getFullYear()}`;

            const isoDate = `${selectedDate.getFullYear()}-${String(selectedDate.getMonth() + 1).padStart(2, '0')}-${String(selectedDate.getDate()).padStart(2, '0')}`;

  console.log("ISO date:", isoDate);


            document.getElementById("appointment_date").value = isoDate; // Ensure this is set correctly

            // Send the selected date to your PHP script
            fetch('date.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'date=' + encodeURIComponent(formattedDate)
            })
            .then(response => response.text())
            .then(data => console.log('Response from PHP script:', data));

            this.openEventModal = true;
            const modalOverlay = document.getElementById("modal-overlay");
            modalOverlay.classList.remove("hidden");

            // Add event listener to close the modal when clicking outside the modal content
            modalOverlay.addEventListener('click', (event) => {
                if (event.target === modalOverlay) {
                    this.closeModal();
                }
            });
        },

        // Close the event modal
        closeModal() {
            this.openEventModal = false;
            const modalOverlay = document.getElementById("modal-overlay");
            modalOverlay.classList.add("hidden");
        },

        // Get the number of days and blank days for the current month
        getNoOfDays() {
            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
            let firstDayOfMonth = new Date(this.year, this.month, 1).getDay();

            this.blankdays = Array.from({ length: firstDayOfMonth }, (_, i) => i + 1);
            this.no_of_days = Array.from({ length: daysInMonth }, (_, i) => i + 1);
        }
    };
}
</script>
 <!-- AlpineJS -->
 <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <!-- Font Awesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</html>
