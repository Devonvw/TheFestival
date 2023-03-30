<!DOCTYPE HTML>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/utils/getImage.js"></script>
<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<script src="/packages/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#description',
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image',
        plugins: 'image',
        image_class_list: [{
                title: 'Left',
                value: ''
            },
            {
                title: 'Right',
                value: 'md:float-right'
            }
        ]
    });
</script>
<script>
    window.addEventListener("load", () => {
        getEventItems();
    });


    function getEventItems() {
        const params = new URLSearchParams(window.location.search)
        fetch(`${window.location.origin}/api/event/event-items?id=${params.get("id")}`, {
                headers: {
                    'Content-Type': 'application/json'
                },
                method: "GET",
            })
            .then((response) => response.json())
            .then((data) => {
                const eventItemsList = document.getElementById('event-item-list');

                data.forEach((eventItem) => {

                    const row = createEventItemRow(eventItem);
                    eventItemsList.appendChild(row);
                });

                document.getElementById('search').addEventListener('input', filterEventItems);
            })
            .catch((error) => {
                console.log(error);
            });
    }

    function createEventItemRow(eventItem) {
        const row = document.createElement('tr');
        row.setAttribute('data-event-item-id', eventItem.id);

        row.innerHTML = `
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            ${eventItem.name}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            ${eventItem.description}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            ${eventItem.location}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            ${eventItem.venue}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            ${eventItem.cousine}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <img src="data:image/jpeg;base64,${eventItem.image}" alt="Event Item Image" class="w-16 h-16 rounded">
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <div class="flex flex-col space-y-2">
  <a href="event-item/edit?id=${eventItem.id}"><button class="bg-indigo-500 text-white py-1 px-11 rounded-md hover:bg-indigo-600">Edit</button></a>
  <button class="bg-red-500 text-white py-1 px-4 rounded-md hover:bg-red-600">Delete</button>
</div>

        </td>
    `;
        return row;
    }

    function filterEventItems() {
        const searchInput = document.getElementById('search');
        const searchValue = searchInput.value.toLowerCase().trim();
        const eventItemsList = document.getElementById('event-item-list');
        const eventItems = eventItemsList.querySelectorAll('tr[data-event-item-id]');

        eventItems.forEach((eventItem) => {
            const eventName = eventItem.querySelector('td:nth-child(1)').textContent.toLowerCase().trim();
            if (eventName.includes(searchValue)) {
                eventItem.style.display = '';
            } else {
                eventItem.style.display = 'none';
            }
        });
    }





    const addEventItem = (e) => {
        e.preventDefault();
        const urlParams = new URLSearchParams(window.location.search);
        const eventId = urlParams.get('id');

        const formData = new FormData();
        formData.append("name", document.getElementById('event_item_name').value);
        formData.append("event_id", eventId);

        formData.append("location", document.getElementById('location').value);
        formData.append("venue", document.getElementById('venue').value);
        formData.append("cousine", document.getElementById('cousine').value);
        formData.append("image", document.getElementById('image').files ? document.getElementById('image')
            .files[0] : null);
        formData.append("description", tinymce.get('description').getContent());
        fetch(`${window.location.origin}/api/event/event-item/add`, {
            method: "POST",
            body: formData
        }).then(async (res) => {
            if (!res.ok) {
                ToastError((await res.json())?.msg);

            }

        }).catch((res) => {});
    }
</script>
<header>
    <title>Event - event items</title>
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

<body class="bg-gray-100 overflow-x-hidden">
    <div class="h-screen flex">

        <div class="w-80">
            <?php include __DIR__ . '/../../../components/dashboard/sidebar.php' ?>
        </div>

        <div class="dashboard-right flex-1 min-h-screen">
            <div class="container mx-auto px-10 py-10">
                <h1 class="text-3xl font-semibold mb-6">Event item</h1>

                <!-- Add event item Form -->
                <div class="bg-white rounded-lg p-6 shadow mb-10">
                    <h2 class="text-xl font-semibold mb-4">Add event item</h2>
                    <form onsubmit="addEventItem(event)" id="addForm" class="space-y-4 md:space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <label for="event_item_name" class="block text-sm font-medium text-gray-700">Event name</label>
                                <input type="text" name="event_item_name" id="event_item_name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="col-span-1">
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" name="location" id="location" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-1">
                                <label for="cousine" class="block text-sm font-medium text-gray-700">Cousine</label>
                                <input type="text" name="cousine" id="cousine" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="col-span-1">
                                <label for="venue" class="block text-sm font-medium text-gray-700">Venue</label>
                                <input type="text" name="venue" id="venue" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="col-span-1">
                                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" name="image" id="image" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="description">Description:</label>
                            <textarea id="description" name="description"></textarea>
                        </div>
                        <button type="submit" class="mt-6 bg-primary text-white py-2 px-6 rounded-md">Add Event item</button>

                    </form>
                </div>

                <!-- Search/filter bar -->
                <div class="mb-6">
                    <input type="text" name="search" id="search" placeholder="Search event items..." class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- event item List -->
                <div class="bg-white rounded-lg p-6 shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr data-venue-id="${eventItem.id}">
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Venue
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cousine
                                </th>
                                <th scope="col" class="px-6 py-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edit/Delete</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="event-item-list" class="bg-white divide-y divide-gray-200 text-left">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</body>

</html>