<?php 
/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /");
    exit;
}*/
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script>
window.addEventListener("load", (event) => {
    getUser();
    var frm = document.getElementById("editForm");

    frm.addEventListener("submit", editUser);
});

function editUser(e) {
    e.preventDefault();
    const params = new URLSearchParams(window.location.search)

    fetch(`${window.location.origin}/api/account?id=${params.get("id")}`, {
        method: "PUT",
        body: JSON.stringify({
            first_name: document.getElementById('firstName').value,
            last_name: document.getElementById('lastName').value,
            email: document.getElementById('email').value
        })
    }).then(async (res) => {
        if (res.ok) window.location = "/dashboard/accounts";
        document.getElementById('error').innerHTML = (await res.json())?.msg;
        document.getElementById('errorWrapper').classList.remove('hidden');
    }).catch((res) => {});
}

function getUser() {
    const params = new URLSearchParams(window.location.search)
    fetch(`${window.location.origin}/api/account?id=${params.get("id")}`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (!res.ok) {
            window.location = "/dashboard/accounts";
        }
        const data = await res.json();
        document.getElementById('firstName').value = data?.first_name;
        document.getElementById('lastName').value = data?.last_name;
        document.getElementById('email').value = data?.email;
    }).catch((res) => {});
}
</script>
<header>
    <link rel="stylesheet" href="../../styles/globals.css">
    <title>Edit Account - The Festival</title>
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
    <div class="">
        <div class="w-screen relative">
            <?php include __DIR__ . '../../../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">
                <div class="shadow-xl border-black w-full p-4 px-8 mb-10">
                    <h2 class="text-2xl font-semibold">Edit account </h2>
                </div>
                
                <div class="px-4 md:px-6 lg:px-8">
                    
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        
                        <div class="bg-red-200 p-2 w-full rounded-lg flex text-red-700 items-center text-sm hidden"
                            id="errorWrapper"><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            
                            <p id="error"></p>
                        </div>
                        <button onclick="window.history.back()" class="bg-primary text-white py-2 px-4 rounded-md mb-4 mt-2">Go Back</button>
                        <form id="editForm" class="space-y-4 md:space-y-6">
                            <div>
                                <label for="firstName" class="block mb-2 text-sm font-medium text-gray-900">
                                    First name</label>
                                <input maxlength="255" type="text" name="firstName" id="firstName"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="First name..." required="">
                            </div>
                            <div>
                                <label for="lastName" class="block mb-2 text-sm font-medium text-gray-900">
                                    Last name</label>
                                <input maxlength="255" type="text" name="lastName" id="lastName"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Last name..." required="">
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                                    Email</label>
                                <input maxlength="255" type="text" name="email" id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Email..." required="">
                            </div>
                            <div><button type="submit" class="w-full text-white bg-primary p-2 rounded-lg">
                                    Save
                                </button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>