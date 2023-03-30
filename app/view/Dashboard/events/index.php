<?php
// if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
//     header("location: /");
//     exit;
// }

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
    <div class="">
        <div class="w-screen relative">
            <?php include __DIR__ . '/../../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">

                <header class="bg-primary py-5">
                    <h1 class="text-center text-white text-3xl font-bold">Event Dashboard</h1>
                </header>


                <div class="flex flex-col items-center h-screen bg-gray-100">
                    <div class="flex justify-center mt-10">
                        <button id="redirectToSlotsManager" class="bg-primary text-white py-2 px-4 rounded-md mb-6 mr-4">Manage slots</button>
                        <button id="redirectToTickets" class="bg-primary text-white py-2 px-4 rounded-md mb-6">Manage tickets</button>
                    </div>


                    <h1 class="text-3xl font-bold mt-8 mb-8">Current Events</h1>
                    <div class="flex items-center justify-end mb-8">
                        <button id="btn" class="bg-primary hover:bg-primary-light text-white font-bold py-2 px-4 rounded"><a href="/dashboard/events/event-items">Add Event</a></button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="event-grid">

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
                <button class="bg-transparent p-1 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 delete-button" type="button" aria-label="Delete">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </div>
            <h2 class="text-xl font-bold mb-2 event-name"></h2>
            <p class="text-gray-500 mb-2 event-description"></p>

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

                data.forEach(event => {
                    const eventBox = eventBoxTemplate.content.cloneNode(true);

                    eventBox.querySelector(".view-event-items").addEventListener("click", function() {
                        window.location.href = `events/event-items?id=${event.id}`;
                    });
                    eventBox.querySelector(".event-name").innerHTML = event.name;
                    eventBox.querySelector(".event-description").textContent = event.description;

                    eventBox.querySelector(".delete-button").addEventListener("click", function() {
                        deleteEvent(event.id);
                    });


                    eventGrid.appendChild(eventBox);
                });
            })
            .catch((error) => {
                console.log(error);
            });
    }

    function deleteEvent(id) {
        fetch(`${window.location.origin}/api/event?id=${id}`, {
                headers: {
                    'Content-Type': 'application/json'
                },
                method: "DELETE",
            })
            .then((res) => {
                if (res.ok)
                    ToastSuccess("Event deleted");
                getEvents();
            })
            .catch((error) => {
                console.log(error);
            });
    }
    //event listener for the "Slots Manager" button
    document.getElementById('redirectToSlotsManager').addEventListener('click', redirectToSlotsManager);

    // Function to redirect to the slots manager
    function redirectToSlotsManager() {
        window.location.href = `events/event-items/slots`;
    }
</script>
</body>

</html>