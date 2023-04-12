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
    <title>Event Slot - Add</title>
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
                <button onclick="window.history.back()" class="bg-primary text-white py-2 px-4 rounded-md mb-4 mt-2">Go Back</button>

                <!-- Add Form -->
                <div class="bg-white rounded-lg p-6 shadow mb-10">
                    <h2 class="text-xl font-semibold mb-4">Add Event Item Slot</h2>
                    <form onsubmit="addEventItemSlot(event)" id="addForm" class="space-y-4 md:space-y-6">
                        <div class="col-span-2">
                            <label for="event" class="block text-sm font-medium text-gray-700">Event</label>
                            <select name="event" id="event" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></select>
                        </div>
                        <div class="col-span-2">
                            <label for="eventItem" class="block text-sm font-medium text-gray-700">Event Item</label>
                            <select name="eventItem" id="eventItem" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <label for="start" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="datetime-local" name="start" id="start" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>
                            <div class="col-span-1">
                                <label for="end" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="datetime-local" name="end" id="end" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                <input type="number" name="stock" id="stock" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>
                            <div class="col-span-1">
                                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                                <input type="number" name="capacity" id="capacity" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>
                        </div>
                        <button type="submit" class="mt-6 bg-primary text-white py-2 px-6 rounded-md">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        async function addEventItemSlot(event) {
            event.preventDefault();

            const eventItemId = document.getElementById('eventItem').value;
            const start = document.getElementById('start').value;
            const end = document.getElementById('end').value;
            const stock = document.getElementById('stock').value;
            const capacity = document.getElementById('capacity').value;
            const formData = new FormData();
            formData.append('eventItemId', eventItemId);
            formData.append('start', start);
            formData.append('end', end);
            formData.append('stock', stock);
            formData.append('capacity', capacity);
            try {
                const response = await fetch(`${window.location.origin}/api/event/event-item/slot/add`, {
                    method: 'POST',
                    body: formData
                });
                if (response.ok) {
                    ToastSucces("Added event item slot");
                } else {
                    ToastError((await response.json())?.msg);
                }

            } catch (error) {
                console.error(error);
            }
        }

        // Fetch main events
        async function fetchMainEvents() {
            try {
                const response = await fetch(`${window.location.origin}/api/event/main-events`);
                if (!response.ok) {
                    throw new Error('Failed to fetch main events');
                }
                return await response.json();
            } catch (error) {
                console.error(error);
            }
            return [];
        }

        // Fetch event items
        async function fetchEventItems(mainEventId) {
            try {
                const response = await fetch(`${window.location.origin}/api/event/event-items?id=${mainEventId}`);
                if (!response.ok) {
                    throw new Error('Failed to fetch event items');
                }
                return await response.json();
            } catch (error) {
                console.error(error);
            }
            return [];
        }

        // Initialize main events select
        async function initializeMainEventsSelect() {
            const mainEvents = await fetchMainEvents();
            const mainEventsSelect = document.getElementById('event');
            mainEventsSelect.innerHTML = '';

            mainEvents.forEach(mainEvent => {
                const option = document.createElement('option');
                option.value = mainEvent.id;
                option.textContent = mainEvent.name;
                mainEventsSelect.appendChild(option);
            });

            mainEventsSelect.dispatchEvent(new Event('change'));


        }

        // Initialize event items select
        async function initializeEventItemsSelect(eventItems) {
            const eventItemsSelect = document.getElementById('eventItem');
            eventItemsSelect.innerHTML = '';

            eventItems.forEach(eventItem => {
                const option = document.createElement('option');
                option.value = eventItem.id;
                option.textContent = eventItem.name;
                eventItemsSelect.appendChild(option);
            });

            eventItemsSelect.dispatchEvent(new Event('change'));


        }

        // Main event dropdown event listener
        document.getElementById('event').addEventListener('change', async (event) => {
            const mainEventId = event.target.value;
            const eventItems = await fetchEventItems(mainEventId);
            initializeEventItemsSelect(eventItems);
        });
        // Event item dropdown event listener
        document.getElementById('eventItem').addEventListener('change', async (event) => {
            const startInput = document.getElementById('start');
            const endInput = document.getElementById('end');
            const stockInput = document.getElementById('stock');
            const capacityInput = document.getElementById('capacity');
            const eventItemId = event.target.value;
            if (eventItemId) {
                startInput.disabled = false;
                endInput.disabled = false;
                stockInput.disabled = false;
                capacityInput.disabled = false;
            } else {
                startInput.disabled = true;
                endInput.disabled = true;
                stockInput.disabled = true;
                capacityInput.disabled = true;
            }
        });
        // Initialize main events dropdown on page load
        window.addEventListener('load', () => {
            initializeMainEventsSelect();
        });
    </script>
</body>

</html>