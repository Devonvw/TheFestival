<!DOCTYPE HTML>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/utils/getImage.js"></script>
<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<script src="/packages/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

<header>
    <title>Event - Slots</title>
    <link rel="stylesheet" href="../../../styles/globals.css">

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

<body>
    <div class="overflow-hidden">
        <div class="w-screen relative">
            <?php include __DIR__ . '/../../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">

                <div class="mx-auto w-full max-w-screen-xl px-4">
                    <button onclick="window.location.href='slot/add'" class="bg-primary text-white py-2 px-4 rounded-md mb-4 absolute top-0 right-0 mt-4 mr-10">Add Slot</button>
                    <button onclick="window.history.back()" class="bg-primary text-white py-2 px-4 rounded-md mb-4 mt-4">Go Back</button>
                    <h1 class="text-3xl font-semibold mb-6">Slots</h1>

                    <!-- Filters -->
                    <div class="bg-white p-4 rounded-lg shadow mb-6">
                        <div class="flex flex-wrap gap-4">
                            <div>
                                <label for="stock_filter" class="block text-sm font-medium text-gray-700">Stock Capacity</label>
                                <select id="stock_filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">All</option>
                                    <option value="sold_out">Sold Out</option>
                                </select>
                            </div>
                            <!-- Event Item Filter -->
                            <div>
                                <label for="event_item_filter" class="block text-sm font-medium text-gray-700">Event</label>
                                <select id="event_item_filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">All</option>
                                    <!-- Add event item options here -->
                                </select>
                            </div>

                            <!-- Start Date Filter -->
                            <div>
                                <label for="start_date_filter" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start_date_filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <!-- End Date Filter -->
                            <div>
                                <label for="end_date_filter" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" id="end_date_filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <!-- Search Filter -->
                            <div>
                                <label for="search_filter" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" id="search_filter" placeholder="Search slots" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <!-- Filter Button -->
                            <div class="flex items-end">
                                <button id="reset_filters" class="bg-primary text-white py-2 px-6 rounded-md">Reset Filters</button>

                            </div>
                        </div>
                    </div>
                    <!-- Slots Table -->
                    <div class="bg-white rounded-lg p-6 shadow">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Event name</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Event item name</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Start</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">End</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Capacity</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Add rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        window.addEventListener("load", () => {
            updateSlotsTable();
            getEvents();
        });


        function getEvents() {
            fetch(`${window.location.origin}/api/event/main-events`, {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    method: "GET",
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    const eventItemFilter = document.getElementById('event_item_filter');
                    data.forEach(event => {
                        const option = document.createElement('option');
                        option.value = event.name;
                        option.textContent = event.name;
                        eventItemFilter.appendChild(option);
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        }

        function updateSlotsTable() {
            // Get filter values
            const eventItemFilter = document.getElementById('event_item_filter').value;
            const startDateFilter = document.getElementById('start_date_filter').value;
            const endDateFilter = document.getElementById('end_date_filter').value;
            const searchFilter = document.getElementById('search_filter').value;
            const stockFilter = document.getElementById('stock_filter').value;

            // Constructing the API URL
            const apiUrl = `/api/events/event-items/slots?event_name=${eventItemFilter}&start_date=${startDateFilter}&end_date=${endDateFilter}&search=${searchFilter}&stock=${stockFilter}`;

            // Fetching slots data based on filter values
            fetch(apiUrl)
                .then((response) => response.json())
                .then((eventItemSlots) => {
                    console.log(eventItemSlots);
                    const slotsTableBody = document.querySelector('tbody');
                    slotsTableBody.innerHTML = '';

                    eventItemSlots.forEach((slot) => {
                        const row = `
<tr>
  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${slot.eventName}</td>
  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${slot.eventItemName}</td>
  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${slot.start}</td>
  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${slot.end}</td>
  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${slot.stock}</td>
  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${slot.capacity}</td>
  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
    <div class="flex flex-col space-y-2">
      <a href="slot/edit?id=${slot.slotId}"><button class="bg-indigo-500 text-white py-1 px-4 rounded-md hover:bg-indigo-600">Edit</button></a>
      <button onclick="deleteEventItemSlot(${slot?.slotId})" class="bg-red-500 text-white py-1 px-4 rounded-md hover:bg-red-600">Delete</button>
    </div>
  </td>
</tr>
`;
                        slotsTableBody.insertAdjacentHTML('beforeend', row);
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        }


        function deleteEventItemSlot(id) {
            fetch(`${window.location.origin}/api/event/event-item/slot?id=${id}`, {
                headers: {
                    'Content-Type': 'application/json'
                },
                method: "DELETE",
            }).then(async (res) => {
                if (res.ok) {
                    ToastSucces((await res.json())?.msg);
                    updateSlotsTable();
                    getEvents();
                }
            }).catch((res) => {});
        }

        function resetFilters() {
            document.getElementById('event_item_filter').value = '';
            document.getElementById('start_date_filter').value = '';
            document.getElementById('end_date_filter').value = '';
            document.getElementById('search_filter').value = '';
            document.getElementById('stock_filter').value = '';

            updateSlotsTable();
        }

        document.getElementById('event_item_filter').addEventListener('change', updateSlotsTable);
        document.getElementById('start_date_filter').addEventListener('change', updateSlotsTable);
        document.getElementById('end_date_filter').addEventListener('change', updateSlotsTable);
        document.getElementById('search_filter').addEventListener('input', updateSlotsTable);
        document.getElementById('stock_filter').addEventListener('change', updateSlotsTable);

        document.getElementById('reset_filters').addEventListener('click', resetFilters);
    </script>
</body>

</html>