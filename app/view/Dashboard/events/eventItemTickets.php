<!DOCTYPE HTML>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/utils/getImage.js"></script>
<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<script src="/packages/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

<header>
    <title>Event - Tickets</title>
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
                    <button onclick="window.location.href='ticket/add'" class="bg-primary text-white py-2 px-4 rounded-md mb-4 absolute top-0 right-0 mt-4 mr-4">Add Ticket</button>
                    <button onclick="window.history.back()" class="bg-primary text-white py-2 px-4 rounded-md mb-4 mt-3">Go Back</button>
                    <h1 class="text-3xl font-semibold mb-6">Tickets</h1>

                    <!-- Filters -->
                    <div class="bg-white p-4 rounded-lg shadow mb-6">
                        <div class="flex flex-wrap gap-4">
                            <!-- Event Filter -->
                            <div>
                                <label for="event_filter" class="block text-sm font-medium text-gray-700">Event</label>
                                <select id="event_filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">All</option>
                                    <!-- Add event options here -->
                                </select>
                            </div>
                            <div>
                                <label for="price_filter" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" id="price_filter" placeholder="Enter maximum price" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <!-- Persons Filter -->
                            <div>
                                <label for="persons_filter" class="block text-sm font-medium text-gray-700">Persons</label>
                                <input type="number" id="persons_filter" placeholder="Enter number of persons" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <!-- Search Filter -->
                            <div>
                                <label for="search_filter" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" id="search_filter" placeholder="Search tickets" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <!-- Filter Button -->
                            <div class="flex items-end">
                                <button id="reset_filters" class="bg-primary text-white py-2 px-6 rounded-md">Reset Filters</button>
                            </div>
                        </div>
                    </div>
                    <!-- Tickets Table -->
                    <div class="bg-white rounded-lg p-6 shadow">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Event Item Name</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Start Location</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">End Location</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Persons</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Add ticket rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <script>
            window.addEventListener("load", () => {
                getTicketsData();
                updateTicketsTable();
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
                        const eventFilter = document.getElementById('event_filter');

                        data.forEach(event => {
                            const optionEvent = document.createElement('option');
                            optionEvent.value = event.name;
                            optionEvent.textContent = event.name;
                            eventFilter.appendChild(optionEvent);

                        });
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            let allTickets = [];



            function getTicketsData() {
                const apiUrl = `/api/event/event-item/tickets`;

                fetch(apiUrl)
                    .then((response) => response.json())
                    .then((tickets) => {
                        allTickets = tickets;
                        updateTicketsTable();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }

            function updateTicketsTable() {
                const eventFilterValue = document.getElementById('event_filter').value;
                const priceFilterValue = document.getElementById('price_filter').value;
                const personsFilterValue = document.getElementById('persons_filter').value;
                const searchFilterValue = document.getElementById('search_filter').value;

                const ticketsTableBody = document.querySelector('tbody');
                ticketsTableBody.innerHTML = '';

                allTickets.forEach((ticket) => {
                    let isEventMatch = eventFilterValue === '' || eventFilterValue === ticket.event_name;
                    let isPriceMatch = priceFilterValue === '' || ticket.price <= parseFloat(priceFilterValue);
                    let isPersonsMatch = personsFilterValue === '' || ticket.persons === parseInt(personsFilterValue);
                    let isSearchMatch = searchFilterValue === '' || ticket.event_name.toLowerCase().includes(searchFilterValue.toLowerCase()) || ticket.event_item_name.toLowerCase().includes(searchFilterValue.toLowerCase());

                    if (isEventMatch && isPriceMatch && isPersonsMatch && isSearchMatch) {
                        const row = `
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${ticket.event_name}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${ticket.event_item_name}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${ticket.start}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${ticket.end}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${ticket.persons}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">${ticket.price}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                        <div class="flex flex-col space-y-2">
                            <a href="ticket/edit?id=${ticket.id}"><button class="bg-indigo-500 text-white py-1 px-4 rounded-md hover:bg-indigo-600">Edit</button></a>
                            <button onclick="deleteEventItemSlotTicket(${ticket?.id})" class="bg-red-500 text-white py-1 px-4 rounded-md hover:bg-red-600">Delete</button>
                        </div>
                    </td>
                </tr>
            `;
                        ticketsTableBody.insertAdjacentHTML('beforeend', row);
                    }
                });
            }

            function deleteEventItemSlotTicket(id) {
                fetch(`${window.location.origin}/api/event/event-item/slot/ticket?id=${id}`, {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    method: "DELETE",
                }).then(async (res) => {
                    if (res.ok) {
                        ToastSucces((await res.json())?.msg);

                        //remove the deleted ticket from the allTickets array
                        allTickets = allTickets.filter(ticket => ticket.id !== id);

                        updateTicketsTable();
                        getEvents();
                    }
                }).catch((res) => {});
            }


            function resetFilters() {
                document.getElementById('event_filter').value = '';
                document.getElementById('price_filter').value = '';
                document.getElementById('persons_filter').value = '';
                document.getElementById('search_filter').value = '';

                updateTicketsTable();
            }

            document.getElementById('event_filter').addEventListener('change', updateTicketsTable);

            document.getElementById('price_filter').addEventListener('change', updateTicketsTable);
            document.getElementById('persons_filter').addEventListener('change', updateTicketsTable);
            document.getElementById('search_filter').addEventListener('input', updateTicketsTable);
            document.getElementById('price_filter').addEventListener('input', updateTicketsTable);
            document.getElementById('persons_filter').addEventListener('input', updateTicketsTable);

            document.getElementById('reset_filters').addEventListener('click', resetFilters);
        </script>

</body>

</html>