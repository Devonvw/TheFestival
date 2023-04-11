<?php
?>

<!DOCTYPE HTML>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/utils/getImage.js"></script>
<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<script src="/packages/tinymce/tinymce.min.js" referrerpolicy="origin"></script>


<header>
    <title>Event ticket - Edit</title>
    <link rel="stylesheet" href="../../../../styles/globals.css">

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

<body class="bg-gray-100 overflow-x-hidden">
    <div class="h-screen flex">
        <div class="w-64">
            <?php include __DIR__ . '/../../../components/dashboard/sidebar.php' ?>
        </div>
        <div class="dashboard-right flex-1 min-h-screen">
            <div class="container mx-auto px-4 py-10">
                <button onclick="window.history.back()" class="bg-primary text-white py-2 px-4 rounded-md mb-4">Go Back</button>
                <h1 class="text-3xl font-semibold mb-6">Edit Ticket</h1>
                <!-- Edit Form -->
                <div class="bg-white rounded-lg p-6 shadow mb-10">
                    <h2 class="text-xl font-semibold mb-4">Edit Ticket</h2>
                    <form onsubmit="editTicket(event)" id="editForm" class="space-y-4 md:space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" step="0.01" name="price" id="price" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>
                            <div class="col-span-1">
                                <label for="persons" class="block text-sm font-medium text-gray-700">Persons</label>
                                <input type="number" name="persons" id="persons" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>
                        </div>
                        <button type="submit" class="mt-6 bg-primary text-white py-2 px-6 rounded-md">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener("load", () => {
            getTicket();
        });

        function getTicket() {
            const params = new URLSearchParams(window.location.search)
            fetch(`${window.location.origin}/api/event/event-item/ticket?id=${params.get("id")}`, {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    method: "GET",
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    // Update the form fields with the fetched data
                    document.getElementById('price').value = data.price;
                    document.getElementById('persons').value = data.persons;
                })
                .catch((error) => {
                    console.log(error);
                });
        }

        const editTicket = (e) => {
            e.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);

            const formData = new FormData();
            formData.append("price", document.getElementById('price').value);
            formData.append("persons", document.getElementById('persons').value);

            fetch(`${window.location.origin}/api/event/event-item/ticket/edit?id=${urlParams.get("id")}`, {
                method: "POST",
                body: formData
            }).then(async (res) => {
                if (res.ok) {
                    ToastSucces("Updated ticket");
                } else {
                    ToastError((await res.json())?.msg);
                }
            }).catch((res) => {
                console.error("Error:", res);
                ToastError("Failed to update ticket");
            });
        }
    </script>
</body>

</html>