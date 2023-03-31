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
                        <button id="btn" class="bg-primary hover:bg-primary-light text-white font-bold py-2 px-4 rounded">Add Event</button>
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
            <img id="event-image" src="" alt="Event image">

        </div>
    </template>

    <!-- Event Form Modal -->
    <div id="event-form-modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>


            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <form id="event-form">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Event</h3>
                        <div class="mt-2">
                            <div class="mb-4">
                                <label for="event-name" class="block text-sm font-medium text-gray-700">Event Name</label>
                                <input type="text" id="event-name" class="mt-1 block w-full border-gray-300 focus:ring-primary focus:border-primary rounded-md shadow-sm text-sm">
                            </div>
                            <div class="mb-4">
                                <label for="event-description" class="block text-sm font-medium text-gray-700">Event Description Image</label>
                                <input type="file" id="event-description" class="mt-1 block w-full border-gray-300 focus:ring-primary focus:border-primary rounded-md shadow-sm text-sm">
                            </div>


                        </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button id="save-event" type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:text-sm">
                        Save
                    </button>
                </div>
                <div class="mt-2 sm:mt-3">
                    <button id="close-event-form-modal" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-300 text-base font-medium text-black hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm">
                        Cancel
                    </button>
                </div>
                </form>
            </div>

        </div>
    </div>


    <script>
        window.addEventListener("load", () => {
            getEvents();
        });
        document.getElementById("btn").addEventListener("click", showEventForm);

        function showEventForm() {
            const eventFormModal = document.getElementById("event-form-modal");
            eventFormModal.classList.remove("hidden");

            document.getElementById("close-event-form-modal").addEventListener("click", () => {
                eventFormModal.classList.add("hidden");
            });
        }

        const form = document.querySelector('#event-form');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData();
            formData.append("name", document.getElementById('event-name').value);
            formData.append("description", document.getElementById('event-description').files ? document.getElementById('event-description')
                .files[0] : null);

            fetch(`${window.location.origin}/api/event/add`, {
                    method: "POST",
                    body: formData
                })
                .then(async (res) => {
                    if (res.ok) {
                        ToastSuccess("Event added");
                    } else {
                        ToastError((await res.json())?.msg);
                    }
                })
                .catch((res) => {});

            const eventFormModal = document.getElementById("event-form-modal");
            eventFormModal.classList.add("hidden");

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
                            showEventForm();
                            document.getElementById("event-name").value = event.name;
                            document.getElementById("save-event").removeEventListener("click", saveEvent);
                            document.getElementById("save-event").addEventListener("click", () => {
                                updateEvent();
                            });
                        });
                        eventBox.querySelector(".event-name").innerHTML = event.name;
                        
                        if (event?.description) {
                            const description = document.getElementById('event-image');
                            description.src =  getImage(event?.description);
                        }

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

        function updateEvent() {
            const params = new URLSearchParams(window.location.search)
            const formData = new FormData();
            formData.append("name", document.getElementById('event-name').value);
            formData.append("description", document.getElementById('event-description').files ? document.getElementById('event-description')
                .files[0] : null);

            fetch(`${window.location.origin}/api/event/edit?id=${params.get("id")}`, {
                    method: "POST",
                    body: formData
                })
                .then(async (res) => {
                    if (res.ok) {
                        ToastSuccess("Event updated");
                        getEvents();
                    } else {
                        ToastError((await res.json())?.msg);
                    }
                })
                .catch((res) => {});

            const eventFormModal = document.getElementById("event-form-modal");
            eventFormModal.classList.add("hidden");
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