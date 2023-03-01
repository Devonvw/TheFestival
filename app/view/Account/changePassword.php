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
    <div class="max-w-md mx-auto mt-24">
        <!-- Change Password section -->
        <section class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="border-b-2 border-gray-600 text-lg font-bold pb-4 mb-4">Change Password</h2>
            <form id="change_password_form" class="mb-4">
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 font-bold mb-2">Current Password</label>
                    <input id="current_password" name="current_password" type="password" class="w-full px-4 py-2 border border-gray-600 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700 font-bold mb-2">New Password</label>
                    <input id="new_password" name="new_password" type="password" class="w-full px-4 py-2 border border-gray-600 rounded-lg">
                </div>
                <div class="mb-8">
                    <label for="confirm_password" class="block text-gray-700 font-bold mb-2">Confirm New Password</label>
                    <input id="confirm_password" name="confirm_password" type="password" class="w-full px-4 py-2 border border-gray-600 rounded-lg">
                </div>
                <div class="text-right">
                    <button id="change_password" type="submit" class="bg-teal-500 text-white py-2 px-4 rounded font-bold">Change password</button>

                </div>
            </form>
        </section>
    </div>

</body>