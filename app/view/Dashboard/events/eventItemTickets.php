<!DOCTYPE HTML>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/utils/getImage.js"></script>
<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<script src="/packages/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    function updateTicketsTable() {
        // Get filter values
        const eventItemFilter = document.getElementById('event_item_filter').value;
        const dateFilter = document.getElementById('date_filter').value;
        const statusFilter = document.getElementById('status_filter').value;
        const searchFilter = document.getElementById('search_filter').value;

        // Fetch tickets data based on filter values
        fetch(`/api/event/event-item/slots?event_item=${eventItemFilter}&date=${dateFilter}&status=${statusFilter}&search=${searchFilter}`)
            .then((response) => response.json())
            .then((eventItemSlots) => {
                const ticketsTableBody = document.querySelector('tbody');
                ticketsTableBody.innerHTML = '';

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
<button class="text-indigo-600 hover:text-indigo-900">Edit</button>
<button class="text-red-600 hover:text-red-900 ml-4">Delete</button>
</td>
</tr>
`;
                    ticketsTableBody.insertAdjacentHTML('beforeend', row);
                });
            });
    }
    updateTicketsTable();
    document.getElementById('event_item_filter').addEventListener('change', updateTicketsTable);
    document.getElementById('date_filter').addEventListener('change', updateTicketsTable);
    document.getElementById('status_filter').addEventListener('change', updateTicketsTable);
    document.getElementById('search_filter').addEventListener('input', updateTicketsTable);
</script>
<header>
    <title>Event - Tickets</title>
    <link rel="stylesheet" href="../../../styles/globals.css">

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


    <div class="container mx-auto p-6">
        
        <h1 class="text-3xl font-semibold mb-6">Manage Event Item Tickets</h1>

        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="flex flex-wrap gap-4">
                <!-- Event Item Filter -->
                <div>
                    <label for="event_item_filter" class="block text-sm font-medium text-gray-700">Event Item</label>
                    <select id="event_item_filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All</option>
                        <!-- Add event item options here -->
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <label for="date_filter" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="date_filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Ticket Status Filter -->
                <div>
                    <label for="status_filter" class="block text-sm font-medium text-gray-700">Ticket Status</label>
                    <select id="status_filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All</option>
                        <!-- Add ticket status options here -->
                    </select>
                </div>

                <!-- Search Filter -->
                <div>
                    <label for="search_filter" class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" id="search_filter" placeholder="Search slots" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <!-- Filter Button -->
                <div class="flex items-end">
                    <button id="apply_filters" class="bg-primary text-white py-2 px-6 rounded-md">Apply Filters</button>
                </div>
            </div>
        </div>
        <!-- Tickets Table -->
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
                    <!-- Add ticket rows here -->
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>