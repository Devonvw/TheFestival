<html>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<script>
    window.addEventListener("DOMContentLoaded", function() {
        var frm = document.getElementById("createForm");
        frm.addEventListener("submit", addEventItem);

        var e_frm = document.getElementById("e_createForm");
        e_frm.addEventListener("submit", addEvent);
    });

    function addEventItem(e) {
        e.preventDefault();


        const event_id = document.querySelector('#event_id').value;
        const name = document.querySelector('#name').value;
        const description = document.querySelector('#description').value;
        const location = document.querySelector('#location').value;
        const venue = document.querySelector('#venue').value;
        const cousine = document.querySelector('#cousine').value;
        const seats = document.querySelector('#seats').value;

        const formData = new FormData();
        formData.append('event_id', event_id);
        formData.append('name', name);
        formData.append('description', description);
        formData.append('location', location);
        formData.append('venue', venue);
        formData.append('cousine', cousine);
        formData.append('seats', seats);

        const body = {
            event_id,
            name,
            description,
            location,
            venue,
            cousine,
            seats
        }
        
            console.log(body)
        fetch(`${window.location.origin}/api/event/item`, {
                method: "POST",
                body: JSON.stringify(body),

            })
            .then((res) => {
               console.log(res)
                //  window.location = "/";
                 alert('Event created successfully!');
                 window.location = "/dashboard/events";

            }).catch((res) => {
            })
    }

    function addEvent(e) {
        e.preventDefault();

        const e_name = document.querySelector('#e_name').value;
        const e_description = document.querySelector('#e_description').value;

        const formData = new FormData();
        formData.append('name', e_name);
        formData.append('description', e_description);
      
        const body = {
            e_name,
            e_description,
         
        }
        
            console.log(body)
        fetch(`${window.location.origin}/api/event`, {
                method: "POST",
                body: JSON.stringify(body),

            })
            .then((res) => {
                console.log(res)
                //  window.location = "/";
                alert('Event created successfully!');
                document.getElementById('success').innerHTML = "Event created, you can now login";
                 window.location = "/dashboard/events";

            }).catch((res) => {
            })
    }
</script>
<header>
    <title>Add - Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:name" content="New Post - Social" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://socialdevon.000webhostapp.com/" />
    <meta property="og:description" itemProp="description" content="/og_description.png" />
    <meta property="og:description" content="" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="icon" type="description/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="description/png" sizes="16x16" href="/favicon-16x16.png" />
    <link rel="icon" type="description/png" href="/favicon.ico" />
    <link rel="manifest" href="/site.webmanifest" />
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />
</header>

<body>
    <div class="flex flex-row justify-center items-center">
        <div class="flex flex-row m-12">
            <div class="max-w-xl">
                <div class="w-80 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-teal-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-sm text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                            Create a new event item
                        </h1>
                        <div class="bg-red-200 p-2 w-full rounded-lg flex text-red-700 items-center text-sm hidden" id="errorWrapper"><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <p id="error"></p>
                        </div>
                        <form id="createForm" enctype=”multipart/form-data” class="space-y-4 md:space-y-6">

                            <div>
                                <label for="event_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    id</label>
                                <input maxlength="255" type="number" name="event_id" id="event_id" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="id..." required="">
                            </div>
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    name</label>
                                <input maxlength="255" type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name..." required="">
                            </div>
                            <div>
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    description</label>
                                <input type="text" name="description" id="description" class="mb-0.5 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="description..." required="">
                                <span class="text-white text-xs">*Max 2MB</span>
                            </div>
                            <div>
                                <label for="location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    location</label>
                                <input maxlength="255" type="text" name="location" id="location" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="location..." required="">
                            </div>
                            <div>
                                <label for="venue" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    venue</label>
                                <input maxlength="255" type="text" name="venue" id="venue" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="venue..." required="">
                            </div>
                            <div>
                                <label for="cousine" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    cousine</label>
                                <input maxlength="255" type="text" name="cousine" id="cousine" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="cousine..." required="">
                            </div>
                            <div>
                                <label for="seats" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    seats</label>
                                <input maxlength="255" type="number" name="seats" id="seats" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="seats..." required="">
                            </div>

                            <button type="submit" class="border border-white w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                Create Event Item
                            </button>
                        </form>
                        <p id="success"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-row m-12">
            <div class="max-w-xl">
                <div class="w-80 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-teal-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-2xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                            Create a new event
                        </h1>
                        <div class="bg-red-200 p-2 w-full rounded-lg flex text-red-700 items-center text-sm hidden" id="errorWrapper"><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <p id="error"></p>
                        </div>
                        <form id="e_createForm" enctype=”multipart/form-data” class="space-y-4 md:space-y-6">

                            <div>
                                <label for="e_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    name</label>
                                <input maxlength="255" type="text" name="e_name" id="e_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name..." required="">
                            </div>
                            <div>
                                <label for="e_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    description</label>
                                <input type="text" name="e_description" id="e_description" class="mb-0.5 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="description..." required="">
                                <span class="text-white text-xs">*Max 2MB</span>
                            </div>
                

                            <button type="submit" class="border border-white w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                Create Event
                            </button>
                        </form>
                        <p id="success"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>

<!-- <html>
<script src="https://cdn.tailwindcss.com"></script>
<header>
    <link rel="stylesheet" href="styles/globals.css">
    <name>Dashboard - The Festival</name>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:name" content="Dashboard - The Festival" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:description" itemProp="description" content="/og_description.png" />
    <meta property="og:description" content="" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="icon" type="description/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="description/png" sizes="16x16" href="/favicon-16x16.png" />
    <link rel="icon" type="description/png" href="/favicon.ico" />
    <link rel="manifest" href="/site.webmanifest" />
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />
</header>


<body>
    <div class=" flex flex-col w-screen -mt-10">
    <img src="../assets/walrus-restaurant.png" class="h-15 w-screen bg-gradient-to-b from-white to-black" />
    <div class="flex flex-col items-center">
        <h2 class="text-7xl text-cyan-900">Yummie!</h2>
    </div>
    </div>
    
    <div class="flex flex-col pt-10 px-40">
        <div class="flex flex-row">
            <div class="basis-1/2 py-10">
                <h1 class="text-6xl mb-5">What is <span class="text-indigo-600">Yummie</span>!?</h1>
                <h2 class="text-2xl mr-60">While Haarlem may not be known for its food or culinary traditions, 
                    it has many restaurants worth visiting, offering a diverse range of cuisines from French to Asian and everything in between.
                    During the Haarlem Festival, some restaurants have created special Haarlem Festival menus at a reduced price. From July 27th to 31st,
                     seven restaurants will have 2 or 3 sessions per day available for reservations. For more information on participating restaurants, please click on one of the links below. Bon appétit!</h2>
            </div>
            <div class="basis-1/2 py-10">
            <img src="../assets/intersect-food.png" class="h-15 w-screen" />
            </div>
        </div>
    </div>

    

 
</body>



</html> -->