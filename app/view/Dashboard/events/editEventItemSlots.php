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
    <title>Event slot - Edit</title>
    <link rel="stylesheet" href="../../../../styles/globals.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Login - The Festival" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://the-festival-haarlem.000webhostapp.com/" />
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
                <h1 class="text-3xl font-semibold mb-6">Event item slot</h1>

                <!-- Edit Form -->
                <div class="bg-white rounded-lg p-6 shadow mb-10">
                    <h2 class="text-xl font-semibold mb-4">Edit Slot</h2>
                    <form onsubmit="editEventItemSlot(event)" id="editForm" class="space-y-4 md:space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <label for="event_slot_start" class="block text-sm font-medium text-gray-700">Slot start</label>
                                <input type="datetime-local" name="event_slot_start" id="event_slot_start" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>


                            </div>
                            <div class="col-span-1">
                                <label for="event_slot_end" class="block text-sm font-medium text-gray-700">Slot end</label>
                                <input type="datetime-local" name="event_slot_end" id="event_slot_end" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>

                            <div class="col-span-1">
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                <input type="text" name="stock" id="stock" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>
                            <div class="col-span-1">
                                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                                <input type="text" name="capacity" id="capacity" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
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
            getEventItemSlot();
        });

        function getEventItemSlot() {
            const params = new URLSearchParams(window.location.search)
            fetch(`${window.location.origin}/api/event/event-item/slot?id=${params.get("id")}`, {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    method: "GET",
                })
                .then((response) => response.json())

                .then((data) => {
                    console.log(data);
                    // Update the form fields with the fetched data
                    document.getElementById('event_slot_start').value = formatDatetimeLocal(data.start);
                    document.getElementById('event_slot_end').value = formatDatetimeLocal(data.end);
                    document.getElementById('stock').value = data.stock;
                    document.getElementById('capacity').value = data.capacity;

                })
                .catch((error) => {
                    console.log(error);
                });
        }

        function formatDatetimeLocal(dateStr) {
            const date = new Date(dateStr);
            const year = date.getFullYear().toString().padStart(4, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            const hour = date.getHours().toString().padStart(2, '0');
            const minute = date.getMinutes().toString().
            padStart(2, '0');
            return `${year}-${month}-${day}T${hour}:${minute}`;
        }
        const editEventItemSlot = (e) => {
            e.preventDefault();
            const urlParams = new URLSearchParams(window.location.search);

            const formData = new FormData();
            formData.append("start", document.getElementById('event_slot_start').value);

            formData.append("end", document.getElementById('event_slot_end').value);
            formData.append("stock", document.getElementById('stock').value);
            formData.append("capacity", document.getElementById('capacity').value);
            fetch(`${window.location.origin}/api/event/event-item/slot/edit?id=${urlParams.get("id")}`, {
                method: "POST",
                body: formData
            }).then(async (res) => {
                if (res.ok) {
                    ToastSucces("Updated event item slot");
                } else {
                    ToastError((await res.json())?.msg);
                }

            }).catch((res) => {});
        }
    </script>
</body>

</html>