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
    <title>Music - Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        /* Custom styles */

        .bg-pattern {
            background-image: url('https://www.transparenttextures.com/patterns/45-degree-fabric-light.png');
            background-repeat: repeat;
            background-size: auto;
        }

        .fc-event {
            background-color: #4299e1;
            border-color: #3182ce;
            color: #fff;
        }

        .fc-event:hover {
            background-color: #008080;
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

<body class="bg-gray-100">
    <div class="relative h-80" style="background-image: url('https://source.unsplash.com/featured/?concert'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 backdrop-blur-md"></div>
        <div class="container mx-auto px-4 md:px-6 lg:px-8 text-white relative">
            <div class="flex flex-col items-center justify-end text-center h-full pb-4">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                    Welcome to the Event Page
                </h1>
                <p class="text-xl md:text-2xl lg:text-3xl">
                    Discover upcoming events and book your tickets now!
                </p>
            </div>
        </div>
    </div>




    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 mt-10">
        <div>
            <img src="https://source.unsplash.com/featured/?Concert" alt="Concert" class="w-full h-96 object-cover rounded-md">
        </div>
        <div>
            <h2 class="text-3xl font-bold mb-4">Live Concert</h2>
            <p class="mb-4">Join us for a live concert featuring some of the hottest artists in the industry! Get ready to dance, sing, and have the time of your life at this unforgettable event.</p>
            <p class="mb-4">Date: April 15, 2023</p>
            <p class="mb-4">Location: Haarlem</p>
            <p class="mb-4">Price: $75</p>
            <button class="bg-primary text-white py-2 px-4 rounded">Buy Tickets</button>
        </div>
    </section>


    <div class="bg-primary">

        <header class="text-center py-20">
            <h1 class="text-5xl font-bold text-white">Upcoming Events</h1>
            <p class="text-xl text-white mt-2">Discover the latest events happening in your city</p>
        </header>
    </div>
    <section class="mt-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Repeat the following div for each event -->
                <div class="bg-white shadow-md rounded-md overflow-hidden">
                    <img src="https://source.unsplash.com/random/300x200?music" alt="event-image" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold mb-2">Music Festival</h3>
                        <p class="text-gray-500 mb-2">Venue: Downtown Arena</p>
                        <p class="text-gray-500 mb-2">Date: July 15, 2023</p>
                        <p class="text-gray-500 mb-4">Time: 6:00 PM</p>
                        <div class="flex justify-between">
                            <p class="text-lg font-bold mb-2">Price: €50</p>
                            <button class="bg-primary hover:bg-primary-light text-white py-2 px-4 rounded">Add to Cart</button>
                        </div>
                    </div>
                </div>
                <!-- End of event div -->

            </div>
        </div>
    </section>



    <div class="calendar-container">
        <div id="calendar"></div>
    </div>
    <script>
        function updateVisibleDays(view, events) {
            if (view.type === 'dayGridMonth') {
                view.el.querySelectorAll('.fc-daygrid-day-frame').forEach(function(dayFrame) {
                    dayFrame.style.display = 'none';
                });

                events.forEach(function(event) {
                    var date = event.startStr.split('T')[0];
                    var dayFrame = view.el.querySelector('.fc-daygrid-day[data-date="' + date + '"] .fc-daygrid-day-frame');
                    if (dayFrame) {
                        dayFrame.style.display = 'block';
                    }
                });
            } else if (view.type === 'timeGridWeek') {
                view.el.querySelectorAll('.fc-daygrid-day-frame').forEach(function(dayFrame) {
                    dayFrame.style.display = 'block';
                });
            }
        }
        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'monthButton,weekButton'
                },
                customButtons: {
                    monthButton: {
                        text: 'Month',
                        click: function() {
                            calendar.changeView('dayGridMonth');
                        }
                    },
                    weekButton: {
                        text: 'Week',
                        click: function() {
                            calendar.changeView('timeGridWeek');
                        }
                    }
                },
                initialView: 'dayGridMonth',
                initialDate: '2023-07-01',
                slotMinTime: '16:00:00',
                slotMaxTime: '20:00:00',
                dayHeaderFormat: {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long'
                },
                slotLabelFormat: [{
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: false
                }],
                columnHeaderFormat: {
                    weekday: 'short'

                },
                allDaySlot: false,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                events: [
                    // Dummy events
                    {
                        title: 'Event 1',
                        start: '2023-07-27T16:30:00',
                        end: '2023-07-27T18:00:00',
                    },
                    {
                        title: 'Event 2',
                        start: '2023-07-28T17:00:00',
                        end: '2023-07-28T19:30:00',
                    },
                    {
                        title: 'Event 3',
                        start: '2023-07-29T16:00:00',
                        end: '2023-07-29T18:00:00',
                    },
                    {
                        title: 'Event 4',
                        start: '2023-07-30T17:30:00',
                        end: '2023-07-30T19:30:00',
                    },
                    {
                        title: 'Event 5',
                        start: '2023-07-31T16:00:00',
                        end: '2023-07-31T18:30:00',
                    },
                ],

            });
            calendar.render();
        });

        window.addEventListener("load", (event) => {
            getEvent();
        });

        function getEvent() {
            fetch(`${window.location.origin}/api/event/all`, {
                    headers: {
                        "Content-Type": "application/json",
                    },
                    method: "GET",
                })
                .then((response) => response.json())
                .then((data) => {
                    const eventGrid = document.getElementById("eventGrid");
                    data.forEach((event) => {
                        eventGrid.innerHTML += `
          <div class="bg-white shadow-md rounded-md p-6">
            <img src="${event.imageUrl}" alt="${event.event_name}" class="w-full h-64 object-cover mb-4 rounded">
            <h2 class="text-xl font-bold mb-2">${event.event_name}</h2>
            <p class="text-gray-500 mb-2">Artist: ${event.name}</p>
            <p class="text-gray-500 mb-2">Venue: ${event.venue}</p>
            <p class="text-gray-500 mb-2">Date: ${event.date} at ${event.time}</p>
            <p class="text-gray-500 mb-4">${event.description}</p>
            <p class="text-lg font-bold mb-4">Price: €${event.ticketPrice}</p>
            <button class="bg-primary hover:bg-primary-light text-white py-2 px-4 rounded" onclick="addToCart(${event.event_id})">Add to Cart</button>
          </div>
        `;
                    });
                })
                .catch((res) => {});
        }

        function addToCart(eventId) {

        }
    </script>
</body>

</html>