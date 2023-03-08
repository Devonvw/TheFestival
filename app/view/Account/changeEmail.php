<?php
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: /");
    exit;
}
echo $_SESSION['test'];
echo '</br>';
echo $_SESSION['test2'];
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
    <div class="max-w-md mx-auto mt-24">
        <section class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <!-- Change Email section -->
            <h2 class="border-b-2 border-gray-600 text-lg font-bold pb-4 mb-4">Change Email</h2>
            <div id="change_email_form">
                <div class="mb-4">
                    <label for="new_email" class="block text-gray-700 font-bold mb-2">New Email</label>
                    <input id="new_email" name="new_email" type="email" class="w-full px-4 py-2 border border-gray-600 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="new_email_confirmation" class="block text-gray-700 font-bold mb-2">Re-type Email</label>
                    <input id="new_email_confirmation" name="new_email_confirmation" type="email" class="w-full px-4 py-2 border border-gray-600 rounded-lg">
                </div>
                <div class="mb-8">
                    <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                    <input id="password" name="password" type="password" class="w-full px-4 py-2 border border-gray-600 rounded-lg">
                </div>
                <div class="mb-6 bg-red-200 p-2 w-full rounded-lg flex text-red-700 items-center text-sm hidden" id="errorWrapper"><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <p id="error"></p>
                </div>
                <div class="bg-green-200 p-2 w-full rounded-lg flex text-green-700 items-center text-sm hidden" id="success">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-6a1 1 0 112 0v2a1 1 0 11-2 0v-2zm1-9a1 1 0 00-1 1v5a1 1 0 102 0V4a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <p id="successMessage"></p>
                </div>
                <div class="text-right">
                    <button onclick="updateEmail()" id="change_email_button" type="button" class="bg-teal-500 text-white font-bold py-2 px-4 rounded-lg">Change Email</button>
                </div>
            </div>
        </section>
    </div>


</body>
<script>
    const submitButton = document.getElementById('change_email_button');
    const newEmail = document.getElementById('new_email');
    const newEmailConfirmation = document.getElementById('new_email_confirmation');
    const password = document.getElementById('password');

    function updateEmail() {
        fetch(`${window.location.origin}/api/change-email`, {
            method: "PUT",
            body: JSON.stringify({
                new_email: document.getElementById('new_email').value,
                new_email_confirmation: document.getElementById('new_email_confirmation').value,
                password: document.getElementById('password').value
            })
        }).then(async (res) => {
            if (res.ok){

            }
            else{
            document.getElementById('error').innerHTML = (await res.json())?.msg;
            document.getElementById('errorWrapper').classList.remove('hidden');
            }
        }).catch((res) => {});
    }
</script>