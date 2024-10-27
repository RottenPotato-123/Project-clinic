<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-teal-600 min-h-screen flex items-center justify-center">

    <main class="bg-white border-2 border-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <section>
            <h3 class="text-2xl font-bold text-center mb-6">Forgot Password</h3>
        </section>

        <section>
            <form method="post" action="sendcode.php">
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                    <input 
                        type="text" 
                        id="email" 
                        name="email" 
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-500 transition duration-300"
                    />
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-teal-500 text-white py-2 rounded hover:bg-teal-600 transition duration-300"
                >
                    Send
                </button>
            </form>
        </section>
    </main>

</body>
</html>
