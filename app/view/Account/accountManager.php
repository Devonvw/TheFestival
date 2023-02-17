<?php
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: /");
    exit;
}

?>
<html>
<script src="https://cdn.tailwindcss.com"></script>

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
        <div class="relative w-40 h-40 rounded-full overflow-hidden">
            <input id="profile_picture_upload" name="profile_picture_upload" type="file" class="absolute inset-0 w-full h-full opacity-0 z-50 cursor-pointer">
            <div id="profile_picture_placeholder" class="absolute inset-0 w-full h-full flex justify-center items-center text-center cursor-pointer z-10 hover:text-blue-500 hover:bg-blue-100">
                <svg class="w-12 h-12 text-gray-400 fill-current mb-1" viewBox="0 0 24 24">
                    <path d="M16 6h-3.5c-.83 0-1.57.33-2.12.88L6.71 12.29a1 1 0 0 0 0 1.42l2.83 2.83a1 1 0 0 0 1.42 0l4.41-4.41c.55-.55.88-1.28.88-2.12V8a4 4 0 0 0-4-4H4a1 1 0 0 0 0 2h8a2 2 0 0 1 2 2v.5c0 .28.22.5.5.5s.5-.22.5-.5V8a1 1 0 0 0-1-1H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a1 1 0 0 0 0-2H4a1 1 0 0 1-1-1V8h11.5c.28 0 .5-.22.5-.5s-.22-.5-.5-.5z" />
                    <path d="M0 0h24v24H0z" fill="none" />
                </svg>
                <span class="text-xs font-medium">Edit Profile Picture</span>
            </div>
            <img id="profile_picture_preview" src="" alt="" class="absolute inset-0 h-full w-full object-cover rounded-full border-2 border-gray-300 shadow-md z-0">
        </div>


        <div class="mb-4">
            <label for="first_name" class="block text-gray-700 font-bold mb-2">First Name</label>
            <input id="first_name" name="first_name" type="text" value="<?php echo $_SESSION['first_name'] ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
        </div>
        <div class="mb-4">
            <label for="last_name" class="block text-gray-700 font-bold mb-2">Last Name</label>
            <input id="last_name" name="last_name" type="text" value="<?php echo $_SESSION['last_name'] ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input id="email" name="email" type="email" value="<?php echo $_SESSION['email'] ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 sm:text-sm sm:leading-5">
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

                const firstName = document.querySelector('#first_name').value;
                const lastName = document.querySelector('#last_name').value;
                const email = document.querySelector('#email').value;
                const password = document.querySelector('#password').value;
                const profilePicture = document.querySelector('#profile_picture_upload').files[0];

                const formData = new FormData();
                formData.append('first_name', firstName);
                formData.append('last_name', lastName);
                formData.append('email', email);
                formData.append('password', password);
                formData.append('profile_picture', profilePicture);

                const response = await fetch(
                    `${window.location.origin}/api/update-account`, {

                        method: 'POST',
                        body: formData
                    });

                if (response.ok) {
                    alert('Account updated successfully!');

                    // Update the form fields with the new input
                    const updatedData = await response.json();
                    document.querySelector('#first_name').value = updatedData.first_name;
                    document.querySelector('#last_name').value = updatedData.last_name;
                    document.querySelector('#email').value = updatedData.email;
                    document.querySelector('#password').value = '';
                } else {
                    console.error('Failed to update account:', response);
                }
            });
        });
        const profilePictureUpload = document.getElementById('profile_picture_upload');
        const profilePicturePlaceholder = document.getElementById('profile_picture_placeholder');
        const profilePicturePreview = document.getElementById('profile_picture_preview');

        profilePictureUpload.addEventListener('change', () => {
            if (profilePictureUpload.files && profilePictureUpload.files[0]) {
                const reader = new FileReader();

                reader.onload = (event) => {
                    profilePicturePreview.src = event.target.result;
                }

                reader.readAsDataURL(profilePictureUpload.files[0]);
                profilePicturePlaceholder.classList.add('hidden');
            } else {
                profilePicturePreview.src = '';
                profilePicturePlaceholder.classList.remove('hidden');
            }
        });
    </script>
</body>


</html>