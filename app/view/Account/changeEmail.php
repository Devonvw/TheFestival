<?php
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: /");
    exit;
}
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<script src="/utils/handleImageUpload.js"></script>
<script>
    const newEmail = document.getElementById('new_email');
    const newEmailConfirmation = document.getElementById('new_email_confirmation');
    const password = document.getElementById('password');

    function updateEmail() {
        fetch(`${window.location.origin}/api/me/change-email`, {
            method: "PUT",
            body: JSON.stringify({
                new_email: document.getElementById('new_email').value,
                new_email_confirmation: document.getElementById('new_email_confirmation').value,
                password: document.getElementById('password').value
            })
        }).then(async (res) => {
            if (res.ok) {
                ToastSucces((await res.json())?.msg);

            } else {
                ToastError((await res.json())?.msg);
            }
        }).catch((res) => {});
    }
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
                <div class="text-right">
                    <button onclick="updateEmail()" id="change_email_button" type="button" class="bg-primary text-white font-bold py-2 px-4 rounded-lg">Change Email</button>
                </div>
            </div>
        </section>
    </div>


</body>

</html>