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

<header>
    <title>Event - Edit</title>
    <link rel="stylesheet" href="../../../styles/globals.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Login - The Festival" />
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

        <div class="w-64">
            <?php include __DIR__ . '/../../../components/dashboard/sidebar.php' ?>
        </div>

        <div class="dashboard-right flex-1 min-h-screen">

            <div class="container mx-auto px-4 py-10">
                <h1 class="text-3xl font-semibold mb-6">Event item</h1>
                



                <!-- Edit Form -->
                <div class="bg-white rounded-lg p-6 shadow mb-10">
                    <h2 class="text-xl font-semibold mb-4">Add event item</h2>
                    <form onsubmit="editEventItem(event)" id="editForm" class="space-y-4 md:space-y-6">
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
                        <button type="submit" class="mt-6 bg-primary text-white py-2 px-6 rounded-md">Edit event item</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    window.addEventListener("load", () => {
        getEventItem();
    });

    function getEventItem() {
        const params = new URLSearchParams(window.location.search)
        fetch(`${window.location.origin}/api/event/event-item?id=${params.get("id")}`, {
                headers: {
                    'Content-Type': 'application/json'
                },
                method: "GET",
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                // Update the form fields with the fetched data
                document.getElementById('event_item_name').value = data.name;
                document.getElementById('location').value = data.location;
                document.getElementById('cousine').value = data.cousine;
                document.getElementById('venue').value = data.venue;
                tinymce.get('description').setContent(data.description);

            })
            .catch((error) => {
                console.log(error);
            });
    }


    const editEventItem = (e) => {
        e.preventDefault();
        const urlParams = new URLSearchParams(window.location.search);
        const eventId = urlParams.get('id');

        const formData = new FormData();
        formData.append("name", document.getElementById('event_item_name').value);

        formData.append("location", document.getElementById('location').value);
        formData.append("venue", document.getElementById('venue').value);
        formData.append("cousine", document.getElementById('cousine').value);
        formData.append("image", document.getElementById('image').files ? document.getElementById('image')
            .files[0] : null);
        formData.append("description", tinymce.get('description').getContent());
        fetch(`${window.location.origin}/api/event/event-item/edit?id=${params.get("id")}`, {
            method: "POST",
            body: formData
        }).then(async (res) => {
            if (!res.ok) {
                ToastError((await res.json())?.msg);

            }

        }).catch((res) => {});
    }
    
</script>
</body>

</html>