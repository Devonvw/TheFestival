<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: /");
    exit;
}
?>
<html>
<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<script src="/utils/handleImageUpload.js"></script>
<script>
    function checkPasswords() {
        const newPassword = document.getElementById('password').value;
        const confirmPassword = document.getElementById('passwordConfirm').value;
        if (newPassword === confirmPassword) {

            return true; //allow form submission to proceed
        } else {

            ToastError("Passwords do not match");

            return false; //prevent form submission
        }
    }

    function signUp() {
        if (checkPasswords()) {
            grecaptcha.enterprise.execute('6LcjQBwlAAAAALbMpWmrTVTRtkVBuOmA6zhYebFI', {
                action: 'signup'
            }).then(function(token) {
                    fetch(`${window.location.origin}/api/account/sign-up`, {
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        method: "POST",
                        body: JSON.stringify({
                            first_name: document.getElementById('first_name').value,
                            last_name: document.getElementById('last_name').value,
                            email: document.getElementById('email').value,
                            password: document.getElementById('password').value,
                            recaptchaToken: token // Add the reCAPTCHA token to the request body

                        })
                    }).then(async (res) => {
                        if (res.ok) {
                            ToastSucces((await res.json())?.msg);
                            //Redirect to login page after 3 seconds
                            setTimeout(() => {
                                window.location = "/login";
                            }, 3000);
                        } else {
                            ToastError((await res.json())?.msg);
                        }
                    }).catch((res) => {});
                });
            }
        }
</script>
<script src="https://cdn.tailwindcss.com"></script>



<html>
<header>
    <title>Sign Up - Social</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Sign Up - Social" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://socialdevon.000webhostapp.com/" />
    <meta property="og:image" itemProp="image" content="/og_image.png" />
    <meta property="og:description" content="" />
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LcjQBwlAAAAALbMpWmrTVTRtkVBuOmA6zhYebFI"></script>
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
    <div class="">
        <?php include __DIR__ . '/../../components/nav.php' ?>
        <div class="h-[90vh] flex justify-center items-center mt-16">
            <div class="max-w-sm">
                <div class="w-80 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-sm xl:p-0 dark:bg-teal-800 dark:border-gray-700">
                    <div class="p-3 md:p-4 space-y-2 md:space-y-3 sm:p-6">
                        <h1 class="text-lg md:text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
                            Create an account
                        </h1>
                        <div class="mb-2">
                            <label for="first_name" class="block mb-1.5 text-xs font-medium text-gray-900 dark:text-white">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="..." required>
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="block mb-1.5 text-xs font-medium text-gray-900 dark:text-white">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="..." required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="block mb-1.5 text-xs font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="you@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="block mb-1.5 text-xs font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordConfirm" class="block mb-1.5 text-xs font-medium text-gray-900 dark:text-white">Confirm new Password</label>
                            <input type="password" name="passwordConfirm" id="passwordConfirm" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required>
                        </div>

                        <button type="button" onclick="signUp()" class="w-full text-white border border-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-xs px-4 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create an account</button>

                        <p class="text-xs font-light text-gray-100 mt-3">
                            Already have an account? <a href="/login" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>