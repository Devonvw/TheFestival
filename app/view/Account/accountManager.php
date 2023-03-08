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
    <link rel="stylesheet" href="../../../styles/globals.css">
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
    <img id="test" alt=""></img>
    <h1 class="max-w-md mx-auto text-2xl font-bold mt-5">Manage Account</h1>

    <form id="manage_account_form">
        <div class="max-w-md mx-auto">
            <section class="bg-white rounded-lg shadow-lg p-12 mb-10 mt-5">
                <div class="text-center">
                    <label class="block text-gray-700 font-bold mb-1">Profile picture</label>

                </div>

                <div class="text-center mb-2">
                    <p class="text-sm font-small text-gray-500">Click the circle to upload your profile picture</p>
                </div>
                <div class="relative w-40 h-40 rounded-full overflow-hidden max-w-md mx-auto mb-3">
                    <input id="profile_picture_upload" name="profile_picture_upload" type="file" class="absolute inset-0 w-full h-full opacity-0 z-50 cursor-pointer">
                    <div id="profile_picture_placeholder" class="absolute inset-0 w-full h-full flex justify-center items-center text-center cursor-pointer z-10 hover:text-blue-500 hover:bg-blue-100">
                        <svg class="w-12 h-12 text-gray-400 fill-current mb-1" viewBox="0 0 24 24">
                            <path d="M16 6h-3.5c-.83 0-1.57.33-2.12.88L6.71 12.29a1 1 0 0 0 0 1.42l2.83 2.83a1 1 0 0 0 1.42 0l4.41-4.41c.55-.55.88-1.28.88-2.12V8a4 4 0 0 0-4-4H4a1 1 0 0 0 0 2h8a2 2 0 0 1 2 2v.5c0 .28.22.5.5.5s.5-.22.5-.5V8a1 1 0 0 0-1-1H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a1 1 0 0 0 0-2H4a1 1 0 0 1-1-1V8h11.5c.28 0 .5-.22.5-.5s-.22-.5-.5-.5z" />
                            <path d="M0 0h24v24H0z" fill="none" />
                        </svg>
                        <span class="text-xs font-medium">Edit Profile Picture</span>
                    </div>
                    <img id="profile_picture_preview" src="" class="absolute inset-0 h-full w-full object-cover rounded-full border-2 border-gray-300 shadow-md z-0">

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
                <div class="bg-red-200 p-2 w-full rounded-lg flex text-red-700 items-center text-sm hidden" id="errorWrapper"><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <p id="error"></p>
                </div>
                


                <div class="text-right">
                    <button id="update_account_button" type="submit" class="bg-primary text-white py-2 px-4 rounded font-bold">Update
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

                const firstName = document.getElementById('first_name').value;
                const lastName = document.getElementById('last_name').value;
                const profilePicture = document.getElementById('profile_picture_upload').files[0];

                const formData = new FormData();
                formData.append('first_name', firstName);
                formData.append('last_name', lastName);
                formData.append('profile_picture', profilePicture);


                fetch(`${window.location.origin}/api/update-account`, {
                    method: "POST",
                    body: formData
                }).then(async (res) => {
                    if (res.ok) {
                        

                    } else {
                        document.getElementById('error').innerHTML = (await res.json())?.msg;
                        document.getElementById('errorWrapper').classList.remove('hidden');
                    }
                }).catch((res) => {});
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

        fetch(`${window.location.origin}/api/account/user`, {
            headers: {
                'Content-Type': 'application/json'
            },
            method: "GET",
        }).then(async (res) => {
            if (res.ok) {
                const data = await res.json();
                console.log(data);

                // Set the value of the first_name and last_name input fields
                document.getElementById('first_name').value = data.first_name;
                document.getElementById('last_name').value = data.last_name;

                // Decode the base64-encoded profile picture and set the src attribute of the profile_picture_preview element
                const profile_picture_preview = document.getElementById('profile_picture_preview');
                profilePicturePlaceholder.classList.add('hidden');
                profile_picture_preview.src = getImage(data.profile_picture);
            }
        }).catch((res) => {
            console.log(res)
        });

        const getImage = (file) => {
            if (typeof file == "string") return `data:image/jpg;base64, ${file}`;
            if (typeof file == "blob") return `data:image/jpg;base64, ${file}`;

            //create the preview
            const objectUrl = URL.createObjectURL(file);

            return objectUrl;
        };
    </script>
</body>


</html>