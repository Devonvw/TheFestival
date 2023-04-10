<?php
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/utils/getImage.js"></script>
<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<header>
    <title>Event- Index</title>
    <link rel="stylesheet" href="../../styles/globals.css">

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
    <div class="min-h-screen">
        <div class="w-screen relative">
            <?php include __DIR__ . '/../../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">

                <header class="bg-primary py-5">
                    <h1 class="text-center text-white text-3xl font-bold">Event Dashboard</h1>
                </header>


                <div class="flex flex-col items-center h-screen bg-gray-100">
                    <div class="flex flex-wrap justify-center mt-10">
                        <button id="redirectToSlotsManager" class="bg-primary text-white py-2 px-4 rounded-md mb-6 mr-4">Manage slots</button>
                        <button id="redirectToTickets" class="bg-primary text-white py-2 px-4 rounded-md mb-6">Manage tickets</button>
                    </div>


                    <h1 class="text-3xl font-bold mt-8 mb-8">Current Events</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full px-4" id="event-grid">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Box Template -->
    <template id="event-box-template">
        <div class="bg-white rounded-lg shadow p-6 relative">
            <div class="absolute top-0 right-0 m-2 flex items-center">
                <a class="hover:text-blue-500 flex items-center view-event-items"><span id="email" class="mr-2"></span><i class="fas fa-pencil-alt"></i></a>
            </div>
            <h2 class="text-xl font-bold mb-2 event-name"></h2>
            <img id="event-image" src="" alt="Event image" class="max-h-40 w-full object-cover rounded"> <!-- Changed max-h-48 to max-h-40 and added rounded class -->
        </div>
    </template>
    <script>
        window.addEventListener("load", () => {
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
                    const eventGrid = document.getElementById("event-grid");
                    eventGrid.innerHTML = "";

                    const eventBoxTemplate = document.getElementById("event-box-template");

                    data.forEach((event) => {
                        const eventBox = eventBoxTemplate.content.cloneNode(true);

                        eventBox.querySelector(".view-event-items").addEventListener("click", function(e) {
                            e.preventDefault();
                            window.location.href = `events/event-items?id=${event.id}`; // Redirect to the specific event page with eventid
                        });

                        eventBox.querySelector(".event-name").innerHTML = event.name;

                        if (event?.description) {
                            const description = eventBox.querySelector('#event-image');
                            description.src = getImage(event?.description);
                        }

                        eventGrid.appendChild(eventBox);
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        }



        //event listener for the slots manager button
        document.getElementById('redirectToTickets').addEventListener('click', redirectToTicketsManager);

        //function to redirect to the slots manager
        function redirectToTicketsManager() {
            window.location.href = `events/event-items/tickets`;
        }
        //event listener for the slots manager button
        document.getElementById('redirectToSlotsManager').addEventListener('click', redirectToSlotsManager);

        //function to redirect to the slots manager
        function redirectToSlotsManager() {
            window.location.href = `events/event-items/slots`;
        }
    </script>
</body>

</html>


</html>