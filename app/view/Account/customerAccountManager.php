<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: /");
    exit;
}
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    const form = document.querySelector('#manage_account_form');
    const submitButton = document.querySelector('#update_account_button');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const firstName = document.querySelector('#first-name').value;
        const lastName = document.querySelector('#last-name').value;
        const email = document.querySelector('#email').value;
        const password = document.querySelector('#password').value;
        const profilePicture = document.querySelector('#profile_picture_upload').files[0];

        const formData = new FormData();
        formData.append('first_name', firstName);
        formData.append('last_name', lastName);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('profile_picture', profilePicture);

        const response = await fetch('/api/update-account', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            alert('Account updated successfully!');
            if (email !== currentUser.email) {
                if (!confirmationResponse.ok) {
                    console.error('Failed to send confirmation email:', confirmationResponse);
                }
            }
        } else {
            console.error('Failed to update account:', response);
        }
    });
</script>
<header>
    <title>Account - Social</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Login - Social" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://socialdevon.000webhostapp.com/" />
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
  <h1 class="text-2xl font-bold mb-4">Manage Account</h1>
  <div class="mb-4">
    <label for="first_name" class="block text-gray-700 font-bold mb-2">First Name</label>
    <input id="first_name" name="first_name" type="text" value="<?php echo $account->first_name ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
  </div>
  <div class="mb-4">
    <label for="last_name" class="block text-gray-700 font-bold mb-2">Last Name</label>
    <input id="last_name" name="last_name" type="text" value="<?php echo $account->last_name ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
  </div>
  <div class="mb-4">
    <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
    <input id="email" name="email" type="email" value="<?php echo $account->email ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
  </div>
  <div class="mb-4">
    <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
    <input id="password" name="password" type="password" autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
  </div>
  <div class="mb-4">
    <label for="profile_picture_upload" class="block text-gray-700 font-bold mb-2">Profile Picture</label>
    <input id="profile_picture_upload" name="profile_picture_upload" type="file" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
  </div>
  <div class="mb-4">
    <button id="update_account_button" type="submit" class="py-2 px-4 font-semibold rounded-lg shadow-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">Update Account</button>
  </div>
</form>

</body>

</html>