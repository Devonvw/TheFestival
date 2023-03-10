<html>
<script src="https://cdn.tailwindcss.com"></script>



<header>
    <link rel="stylesheet" href="../styles/globals.css">
    <link rel="stylesheet" href="../styles/simple-datatables.css">
    <title>Accounts - The Festival</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Dashboard - The Festival" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:image" itemProp="image" content="/og_image.png" />
    <meta property="og:description" content="" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
    <link rel="icon" type="image/png" href="/favicon.ico" />
    <link rel="manifest" href="/site.webmanifest" />
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />
</header>


    
<body>
   
    <form id="manage_account_form" class="max-w-md mx-auto my-8">

    <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Name</label>
            <input id="name" name="name" type="name" autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Description</label>
            <input id="description" name="description" type="description" autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Location</label>
            <input id="location" name="location" type="location" autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Venue</label>
            <input id="venue" name="venue" type="venue" autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Cousine</label>
            <input id="cousine" name="cousine" type="cousine" autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Seats</label>
            <input id="seats" name="seats" type="seats" autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
        </div>



        <div class="mb-4">
            <button id="update_account_button" type="submit" class="py-2 px-4 font-semibold rounded-lg shadow-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">Update
                Account</button>
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.querySelector('#manage_account_form');
            const submitButton = document.querySelector('#update_account_button');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const name = document.querySelector('#name').value;
                const description = document.querySelector('#description').value;
                const location = document.querySelector('#location').value;
                const venue = document.querySelector('#venue').value;
                const cousine = document.querySelector('#cousine').value;
                const seats = document.querySelector('#seats').value;

                const formData = new FormData();
                formData.append('name', name);
                formData.append('description', description);
                formData.append('location', location);
                formData.append('venue', venue);
                formData.append('cousine', cousine);
                formData.append('seats', seats);

                const response = await fetch(
                    `${window.location.origin}/api/update-event`, {

                        method: 'POST',
                        body: formData
                    });

                if (response.ok) {
                    alert('Account updated successfully!');

                    // Update the form fields with the new input
                    const updatedData = await response.json();
                    document.querySelector('#name').value = updatedData.first_name;
                    document.querySelector('#last_name').value = updatedData.last_name;
                    document.querySelector('#email').value = updatedData.email;
                    document.querySelector('#password').value = '';
                } else {
                    console.error('Failed to update account:', response);
                }
            });
        });
        
    </script>
</body>


</html>