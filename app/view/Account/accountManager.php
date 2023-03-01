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
    <script src="https://kit.fontawesome.com/4bec1cfbcc.js" crossorigin="anonymous"></script>
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />

</header>

<body>

    <h1 class="max-w-md mx-auto text-2xl font-bold mt-5">Manage Account</h1>

    <form id="manage_account_form">
        <div class="max-w-md mx-auto">
            <section class="bg-white rounded-lg shadow-lg p-12 mb-10 mt-5">
                <div class="relative w-40 h-40 rounded-full overflow-hidden max-w-md mx-auto mb-3">
                    <input id="profile_picture_upload" name="profile_picture_upload" type="file" class="absolute inset-0 w-full h-full opacity-0 z-50 cursor-pointer">
                    <div id="profile_picture_placeholder" class="absolute inset-0 w-full h-full flex justify-center items-center text-center cursor-pointer z-10 hover:text-blue-500 hover:bg-blue-100">
                        <svg class="w-12 h-12 text-gray-400 fill-current mb-1" viewBox="0 0 24 24">
                            <path d="M16 6h-3.5c-.83 0-1.57.33-2.12.88L6.71 12.29a1 1 0 0 0 0 1.42l2.83 2.83a1 1 0 0 0 1.42 0l4.41-4.41c.55-.55.88-1.28.88-2.12V8a4 4 0 0 0-4-4H4a1 1 0 0 0 0 2h8a2 2 0 0 1 2 2v.5c0 .28.22.5.5.5s.5-.22.5-.5V8a1 1 0 0 0-1-1H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a1 1 0 0 0 0-2H4a1 1 0 0 1-1-1V8h11.5c.28 0 .5-.22.5-.5s-.22-.5-.5-.5z" />
                            <path d="M0 0h24v24H0z" fill="none" />
                        </svg>
                        <span class="text-xs font-medium">Edit Profile Picture</span>
                    </div>
                    <img src="<?php echo $account['profile_picture'] ?>" id="profile_picture_preview" class="absolute inset-0 h-full w-full object-cover rounded-full border-2 border-gray-300 shadow-md z-0">
                </div>
                <div class="mb-3">
                    <label for="first_name" class="block text-gray-700 font-bold mb-1">First Name</label>
                    <input id="first_name" name="first_name" type="text" value="<?php echo $_SESSION['first_name'] ?>" class="w-full px-4 py-2 border border-gray-600 rounded-lg">
                </div>
                <div class="mb-3">
                    <label for="last_name" class="block text-gray-700 font-bold mb-1">Last Name</label>
                    <input id="last_name" name="last_name" type="text" value="<?php echo $_SESSION['last_name'] ?>" class="w-full px-4 py-2 border border-gray-600 rounded-lg">
                </div>

                <label for="email" class="text-gray-700 font-bold mr-4">Email</label>
                <div class="flex items-center mb-3">
                    <span id="email" class="block py-1 mr-4"><?php echo $_SESSION['email'] ?></span>
                    <a href="/customer/manage-account/change-email" class="text-gray-600 hover:text-blue-500"><i class="fas fa-pencil-alt"></i></a>
                </div>
                <label for="password" class="text-gray-700 font-bold mr-4">Password</label>
                <div class="flex items-center mb-3">
                    <a href="/customer/manage-account/change-password" class="border-b border-gray-500 hover:text-blue-500 flex items-center">
                        <span class="mr-2">Change password</span>
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </div>




                <div class="text-right">
                    <button id="update_account_button" type="submit" class="bg-teal-500 text-white py-2 px-4 rounded font-bold">Update
                        Account</button>
                </div>
            </section>
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
                    const profilePicture = document.querySelector('#profile_picture_upload').files[0];

                    const formData = new FormData();
                    formData.append('first_name', firstName);
                    formData.append('last_name', lastName);
                    formData.append('profile_picture', profilePicture);

                    const response = await fetch(
                        `${window.location.origin}/api/update-account`, {

                            method: 'POST',
                            body: formData
                        });

                    if (response.ok) {
                        alert('Account updated successfully!');

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