<?php
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/utils/getImage.js"></script>
<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<script src="/utils/handleImageUpload.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>

<head>
    <title>Music - Dance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta property="og:title" content="Music - Event" />
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
    <style>
        @media (max-width: 767px) {

            .fc-button-timeGridWeek,
            .fc-button-timeGridDay {
                display: none;
            }
        }

        .bg-pattern {
            background-image: url('https://www.transparenttextures.com/patterns/45-degree-fabric-light.png');
            background-repeat: repeat;
            background-size: auto;
        }

        .fc-event {
            background-color: #008080;
            border-color: #008080;
            color: #fff;
        }

        .fc-col-header {
            border-right: none;
        }

        .fc-scroller-harness {
            border-right: none;
        }

        :root {
            --fc-border-color: #008080;
            --fc-daygrid-event-dot-width: 8px;

        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }


        .calendar-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }

        #calendar {
            height: 80%;
            width: 80%;
        }


        .fc-scrollgrid {
            border-top: none !important;
            border-right: none !important;
            border-left: none !important;
        }


        .fc-scrollgrid td:last-of-type {
            border-right: none !important;
            border-bottom: none !important;
        }

        .fc-scrollgrid-header .fc-scrollgrid-header-row {
            border-top: none !important;
            border-right: none !important;
            border-left: none !important;
        }
    </style>

</head>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v16.0&appId=4731276436960002&autoLogAppEvents=1" nonce="z6VwweeS"></script>
<div class="">
    <?php include __DIR__ . '/../../../components/nav.php' ?>

    <body class="bg-gray-100" style="margin-top: 110px;">
        <div class="relative h-80" style="background-image: url('https://source.unsplash.com/featured/?concert'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 backdrop-blur-md"></div>
            <div class="container mx-auto px-4 md:px-6 lg:px-8 text-white relative">
                <div class="flex flex-col items-center justify-end text-center h-full pb-4">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                        Dance
                    </h1>
                    <p class="text-xl md:text-2xl lg:text-3xl">
                        Discover upcoming events and book your tickets now!
                    </p>
                </div>
            </div>
        </div>

        <section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 mt-10">
            <div>
                <img id="small-header-image" src="" alt="Concert" class="w-full h-96 object-cover rounded-md">
            </div>
            <div>
                <h2 class="text-3xl font-bold mb-4">Dance!</h2>
                <p class="mb-4">Join us for an exciting event featuring some of the best performers in the industry! Get ready to dance, sing, and have the time of your life at this unforgettable experience.</p>
                <button id="scroll-to-event-list" class="bg-primary text-white py-2 px-4 rounded-md">Buy Tickets</button>
            </div>
        </section>



        <div class="bg-primary">
            <header class="text-center py-20">
                <h1 class="text-5xl font-bold text-white">Upcoming Events</h1>
                <p class="text-xl text-white mt-2">Discover the latest events happening in your city</p>
            </header>
        </div>
        <h1 id="filter-tickets-header" class="mt-4 text-center mt-6 text-4xl font-bold">Filter tickets</h1>

        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow mb-6 mt-3">
            <div class="flex flex-wrap gap-4">
                <!-- artist Filter -->
                <div>
                    <label for="artist_filter" class="block text-sm font-medium text-gray-700">Artist</label>
                    <select id="artist_filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All</option>
                        <!-- Add artist options here -->
                    </select>
                </div>
                <div>
                    <label for="price_filter" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" id="price_filter" placeholder="Enter maximum price" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
                    <input type="text" id="search_filter" placeholder="Search" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <!-- Filter Button -->
                <div class="flex items-end">
                    <button id="reset_filters" class="bg-primary text-white py-2 px-6 rounded-md">Reset Filters</button>

                </div>
            </div>
        </div>

        <div class="flex justify-end items-center space-x-2 mr-4 mt-4">
            <label for="items_per_page_filter" class="font-semibold">Tickets per page:</label>
            <select id="items_per_page_filter" class="rounded-md border border-gray-300 text-gray-700 p-2 focus:border-primary focus:ring-1 focus:ring-primary">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>

        <section class="mt-10">

            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="eventGrid">
                    <!-- Event cards will be added here -->
                </div>
            </div>
        </section>
        <div class="bg-primary">
            <header class="text-center py-20">
                <h1 class="text-5xl font-bold text-white">Schedulde</h1>
                <p class="text-xl text-white mt-2"></p>
            </header>
        </div>
        <div class="calendar-container">
            <div id="calendar"></div>
        </div>
        <div class="container mx-auto">
            <div class="fb-share-button" data-href="" data-layout="" data-size=""></div>
        </div>
        <?php include __DIR__ . '/../../../components/footer.php' ?>
</div>
<script>
    document.getElementById('scroll-to-event-list').addEventListener('click', function() {
        document.getElementById('filter-tickets-header').scrollIntoView({
            behavior: 'smooth'
        });
    });

    function addTicket(event) {
        const eventCard = event.target.closest('[data-ticket-id]');
        if (!eventCard) return;
        const ticketId = eventCard.dataset.ticketId;

        fetch(`${window.location.origin}/api/cart/ticket?id=${ticketId}`, {
            method: "POST",
            body: null
        }).then(async (res) => {
            if (res.ok)ToastSucces("Ticket added to cart");
            else ToastError((await res.json())?.msg);
        }).catch((res) => {});
    }


    function getMainEvents() {
        fetch(`${window.location.origin}/api/event/main-events`, {
                headers: {
                    'Content-Type': 'application/json'
                },
                method: "GET",
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                const smallHeaderImage = document.getElementById('small-header-image');
                if (data.length > 0) {
                    smallHeaderImage.src = getImage(data[1]?.description);
                }
            })
            .catch((error) => {
                console.log(error);
            });
    }

    async function fetchCalendarEvents() {
        try {
            const response = await fetch(`${window.location.origin}/api/event/event-item/tickets`, {
                headers: {
                    "Content-Type": "application/json",
                },
                method: "GET",
            });
            const data = await response.json();
            const events = data.map((ticket) => {
                return {
                    title: `${ticket.event_name} - ${ticket.event_item_name}`,
                    start: ticket.start,
                    end: ticket.end,
                };
            });
            return events;
        } catch (error) {
            console.error("Failed to fetch calendar events:", error);
            return [];
        }
    }

    async function fetchTickets(filters = {}) {
        const nonEmptyFilters = {};
        for (const [key, value] of Object.entries(filters)) {
            if (value) {
                nonEmptyFilters[key] = value;
            }
        }

        const queryParams = new URLSearchParams(nonEmptyFilters).toString();
        const response = await fetch(`${window.location.origin}/api/event/event-item/tickets?${queryParams}`);
        return await response.json();
    }

    async function fetchArtists() {
        try {
            const response = await fetch(`${window.location.origin}/api/event/event-items?id=2`, {
                headers: {
                    "Content-Type": "application/json",
                },
                method: "GET",
            });
            const data = await response.json();
            const artistFilter = document.getElementById('artist_filter');
            data.forEach(event => {
                const optionEvent = document.createElement('option');
                optionEvent.value = event.name;
                optionEvent.textContent = event.name;
                artistFilter.appendChild(optionEvent);

            });
        } catch (error) {
            console.error("Failed to fetch tickets:", error);
            return [];
        }
    }

    function updateTicketsTable() {
        const artistFilter = document.getElementById("artist_filter").value;
        const priceFilter = document.getElementById("price_filter").value;
        const startDateFilter = document.getElementById("start_date_filter").value;
        const endDateFilter = document.getElementById("end_date_filter").value;
        const searchFilter = document.getElementById("search_filter").value;
        const itemsPerPage = parseInt(document.getElementById("items_per_page_filter").value);

        const filters = {
            artist: artistFilter,
            price: priceFilter,
            start: startDateFilter,
            end: endDateFilter,
            search: searchFilter,
        };

        fetchTickets(filters).then((tickets) => {
            const eventGrid = document.getElementById("eventGrid");
            eventGrid.innerHTML = "";

            // Remove duplicates
            const uniqueTickets = Array.from(
                new Set(tickets.map((ticket) => ticket.event_item_slot_id))
            ).map((id) => tickets.find((ticket) => ticket.event_item_slot_id === id));

            const currentPage = parseInt(getQueryParam("page")) || 1;
            const totalPages = Math.ceil(uniqueTickets.length / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, uniqueTickets.length);
            let displayedItems = 0;
            for (let i = startIndex; i < endIndex; i++) {
                createEventCard(uniqueTickets[i]);
                displayedItems++;
            }

            const paginationContainer = document.createElement("div");
            paginationContainer.className =
                "flex justify-center space-x-2 mt-4 mb-4 pagination-top";

            if (totalPages > 1) {
                if (currentPage > 1) {
                    const prevPageLinkTop = document.createElement("a");
                    prevPageLinkTop.className =
                        "rounded-md border border-gray-300 text-gray-700 p-2 focus:border-primary focus:ring-1 focus:ring-primary";
                    prevPageLinkTop.href = `${window.location.pathname}?page=${
          currentPage - 1
        }#eventGrid`;
                    prevPageLinkTop.textContent = "Prev";
                    paginationContainer.appendChild(prevPageLinkTop);
                }

                for (let i = 1; i <= totalPages; i++) {
                    const pageLinkTop = document.createElement("a");
                    pageLinkTop.className =
                        "rounded-md border border-gray-300 text-gray-700 p-2 focus:border-primary focus:ring-1 focus:ring-primary";
                    pageLinkTop.href = `${window.location.pathname}?page=${i}#eventGrid`;
                    pageLinkTop.textContent = i;
                    if (i === currentPage) {
                        pageLinkTop.classList.add("bg-primary", "text-white");
                    }
                    paginationContainer.appendChild(pageLinkTop);
                }

                if (currentPage < totalPages) {
                    const nextPageLinkTop = document.createElement("a");
                    nextPageLinkTop.className =
                        "rounded-md border border-gray-300 text-gray-700 p-2 focus:border-primary focus:ring-1 focus:ring-primary";
                    nextPageLinkTop.href = `${window.location.pathname}?page=${
          currentPage + 1
        }#eventGrid`;
                    nextPageLinkTop.textContent = "Next";
                    paginationContainer.appendChild(nextPageLinkTop);
                }

                const paginationTops = document.querySelectorAll(".pagination-top");
                paginationTops.forEach((paginationTop) => {
                    paginationTop.parentNode.removeChild(paginationTop);
                });

                eventGrid.parentNode.insertBefore(
                    paginationContainer.cloneNode(true),
                    eventGrid
                );
                eventGrid.parentNode.insertBefore(paginationContainer, eventGrid.nextSibling);
            }
        });
    }



    function getQueryParam(paramName) {
        const searchParams = new URLSearchParams(window.location.search);
        return searchParams.get(paramName);
    }



    function createEventCard(ticket) {
        const eventGrid = document.getElementById("eventGrid");
        const eventCard = `
        <div class="bg-white shadow-md rounded-md overflow-hidden" data-event-id="${ticket.event_item_slot_id}" data-ticket-id="${ticket.id}">

            <img src="${ticket.image ? 'data:image/jpeg;base64,' + ticket.image : ''}" alt="event-image" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-xl font-bold mb-2">${ticket.event_item_name}</h3>
                <p class="text-gray-500 mb-2" id="eventVenue${ticket.event_item_slot_id}">Venue: ${ticket.location}</p>
                <p class="text-gray-500 mb-2" id="eventDate${ticket.event_item_slot_id}">Date: ${new Date(ticket.start).toLocaleDateString()}</p>
                <p class="text-gray-500 mb-4" id="eventTime${ticket.event_item_slot_id}">Time: ${new Date(ticket.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })} - ${new Date(ticket.end).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })}</p>
                <div class="flex justify-between">
                    <p class="text-lg font-bold mb-2" id="eventPrice${ticket.event_item_slot_id}">Price: €${ticket.price}</p>
                    <button class="bg-primary hover:bg-primary-light text-white py-2 px-4 rounded" onclick="addTicket(event)">Add to Cart</button>

                </div>
            </div>
        </div>`;
        eventGrid.innerHTML += eventCard;
    }
    document.addEventListener('DOMContentLoaded', async function() {
        getMainEvents();
        fetchArtists();
        const calendarEvents = await fetchCalendarEvents();

        var calendarEl = document.getElementById("calendar");
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay",
            },
            eventTimeFormat: { // only show event title, not start/end times
                hour: 'numeric',
                minute: '2-digit',
                meridiem: false
            },
            eventDisplay: 'block', // only show event title, not start/end times
            eventColor: 'bg-primary', // use a single event color
            eventSources: [{
                events: calendarEvents,
            }, ],
        });

        calendar.render();

        await updateTicketsTable();

    });
    // Add event listeners to the filters and reset button
    document.getElementById('artist_filter').addEventListener('change', updateTicketsTable);
    document.getElementById('price_filter').addEventListener('input', updateTicketsTable);
    document.getElementById('start_date_filter').addEventListener('change', updateTicketsTable);
    document.getElementById('end_date_filter').addEventListener('change', updateTicketsTable);
    document.getElementById('search_filter').addEventListener('input', updateTicketsTable);
    document.getElementById('items_per_page_filter').addEventListener('change', updateTicketsTable);

    document.getElementById('reset_filters').addEventListener('click', () => {
        document.getElementById('artist_filter').value = '';
        document.getElementById('price_filter').value = '';
        document.getElementById('start_date_filter').value = '';
        document.getElementById('end_date_filter').value = '';
        document.getElementById('search_filter').value = '';

        updateTicketsTable();
    });
</script>
</body>

</html>