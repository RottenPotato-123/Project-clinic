<?php
require_once 'Connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = $_POST["email"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phoneNumber = $_POST['phone_number'];
    $userType = "Client"; // Add this line
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (empty($email) || empty($password) || empty($name) || empty($address) || empty($phoneNumber) || empty($userType)) {
        echo "Please fill in all fields.";
        exit;
    }
// Check if the email already exists in the database
$query = "SELECT * FROM user WHERE Email = '$email'";
$result = mysqli_query($mysqli, $query);
if (mysqli_num_rows($result) > 0) {
    ?>
    <script>
        alert("Email already exists. Please use a different email address.");
        window.location.href = "register.php"; // redirect to register page
    </script>
    <?php
    exit;
}

// Check if the phone number already exists in the database
$query = "SELECT * FROM user WHERE Phone = '$phoneNumber'";
$result = mysqli_query($mysqli, $query);
if (mysqli_num_rows($result) > 0) {
    ?>
    <script>
        alert("Phone number already exists. Please use a different phone number.");
        window.location.href = "register.php"; // redirect to register page
    </script>
    <?php
    exit;
} // Check if the phone number is 11 digits long
    if (strlen($phoneNumber) != 11) {
        echo "Invalid phone number. Please enter an 11-digit number.";
        exit;
    }
    $query = "INSERT INTO user ( Email, Password ,  Fname, Address, Phone, UserType) VALUES (?, ?, ?, ?, ?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssss",  $email, $hashedPassword , $name, $address, $phoneNumber,$userType);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {
        echo "User data saved successfully";
    } else {
        echo "Error saving user data";
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .body-bg {
            background-color: #2AAA8A;
        }
        
    </style>
    <title>Clinic</title>
</head>
<body>
    <div>
        <div class=" body-bg min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <img class="mx-auto h-10 w-auto" src="https://www.svgrepo.com/show/301692/login.svg" alt="Workflow">
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    Create a new account
                </h2>
                <p class="mt-4 text-lg text-center text-sm leading-5 text-white max-w ">
                    Or
                    <a href="#"
                        class="login-button underline font-medium text-green-600 hover:text-green-500 focus:outline-none focus:underline transition ease-in-out duration-150"onclick="redirectToLogin() " >
                        login to your account
                    </a>
                </p>
            </div>
        
            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                    <form method="POST" action="#">
                        <div>
                            <label for="email" class="block text-sm font-medium leading-5  text-gray-700">Full Name</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input id="name" name="name" placeholder="John Doe" type="text" required="" value="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                <div class="hidden absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
       
                        <div class="mt-6">
                            <label for="email" class="block text-sm font-medium leading-5  text-gray-700">
                    Email address
                  </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input id="email" name="email" placeholder="user@example.com" type="email" required="" value="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5
                        ">
                                <div class="hidden absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <label for="address" class="block text-sm font-medium leading-5 text-gray-700">
                                Address
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input id="address" name="address" placeholder="123 Main St, Anytown, USA" type="text" required="" value="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>
                        
                        <div class="mt-6">
    <label for="phone_number" class="block text-sm font-medium leading-5 text-gray-700">
        Phone Number
    </label>
    <div class="mt-1 relative rounded-md shadow-sm">
        <input id="phone_number" name="phone_number" placeholder="09xxxxxxxxx" type="tel" required="" value=""  maxlength="11" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
    </div>
</div>
                        <div class="mt-6">
                            <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                        Password
                    </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="password" name="password" type="password" required="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>
        
                        <div class="mt-6">
                            <label for="password_confirmation" class="block text-sm font-medium leading-5 text-gray-700">
                        Confirm Password
                    </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="password_confirmation" name="password_confirmation" type="password" required="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>
        
                        <div class="mt-6">
                            <span class="block w-full rounded-md shadow-sm">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                      Create account
                    </button>
                  </span>
                        </div>
                    </form>
        
                </div>
            </div>
        </div>
    </div>
    <script>
         function redirectToLogin() {
            window.location.href = "login.php";
        }
        const phoneNumberInput = document.getElementById('phone_number');

phoneNumberInput.addEventListener('input', (e) => {
    const inputValue = phoneNumberInput.value;
    phoneNumberInput.value = inputValue.replace(/\D+/g, ''); // only allow digits
    if (inputValue.length > 11) {
        phoneNumberInput.value = inputValue.slice(0, 11);
    }
});


const form = document.getElementById('user-form');

form.addEventListener('submit', (e) => {
  e.preventDefault();
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const address = document.getElementById('address').value;
  const phoneNumber = document.getElementById('phone_number').value;
  const password = document.getElementById('password').value;

  fetch('/save-user', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      name: name,
      email: email,
      address: address,
      phone_number: phoneNumber,
      password: password
    })
  })
  .then((response) => response.json())
  .then((data) => console.log(data))
  .catch((error) => console.error(error));
});
    </script>
</body>
</html>