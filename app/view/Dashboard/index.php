<html>
<script src="https://cdn.tailwindcss.com"></script>
<header>
    <link rel="stylesheet" href="styles/globals.css">
    <title>Dashboard - The Festival</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Dashboard - The Festival" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:image" itemProp="image" content="/og_image.png" />
    <meta property="og:description" content="" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
    <link rel="icon" type="image/png" href="/favicon.ico" />
    <link rel="manifest" href="/site.webmanifest" />
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />
</header>
<script>
    window.addEventListener("load", (event) => {
        getEventOrders();
    });

    function getEventOrders() {
        fetch(`${window.location.origin}/api/order/event/all`, {
            headers: {
                'Content-Type': 'application/json'
            },
            method: "GET",
        }).then(async (res) => {
            if (res.ok) {
                const data = await res.json();

                var dashboardItemsHTML = "";

                dashboardItemsHTML +=
                    `<div class="col-span-12 md:col-span-6 lg:col-span-4">
                            <div class="bg-white shadow-lg border border-gray-200 rounded-md overflow-hidden">
                                <h4 class="font-medium text-white text-lg p-4 border-b bg-primary">Total sold tickets</h4>
                                <p class="text-xl px-4 py-8">${data?.total}</p>
                            </div>
                        </div>`

                data?.events?.forEach((event, index) => {
                    dashboardItemsHTML +=
                        `<div class="col-span-12 md:col-span-6 lg:col-span-4">
                            <div class="bg-white shadow-lg border border-gray-200 rounded-md overflow-hidden">
                                <h4 class="font-medium text-white text-lg p-4 border-b bg-primary">${event?.name} sold tickets</h4>
                                <p class="text-xl px-4 py-8">${event?.tickets}</p>
                            </div>
                        </div>`
                });

                document.getElementById("dashboardItems").innerHTML = dashboardItemsHTML;
            }
        }).catch((res) => {
            console.log(res)
        });
    }
</script>

<body>
    <div class="">
        <div class="w-screen relative">
            <?php include __DIR__ . '/../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">
                <header class="bg-primary py-5">
                    <div class="container mx-auto">
                        <div class="flex items-center justify-between">
                            <a href="/" class="h-3/5 w-3/5">
                                <img src="../assets/festival_logo.png" alt="Festival Logo" class="text-teal-800 font-black uppercase text-4xl leading-tight tracking-tight pr-16 md:px-8 h-3/5 lg:h-4/5" />
                            </a>
                            
                            <a href="/customer/manage-account">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white my-auto mr-4 hover:scale-105">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </header>
                <div class="px-4 md:px-6 lg:px-8 mt-10">
                    <div class="grid grid-cols-12 gap-12" id="dashboardItems">
                        <div class="col-span-12 md:col-span-6 lg:col-span-4">
                            <div class="bg-white shadow-lg border border-gray-200 rounded-md overflow-hidden">
                                <h4 class="font-medium text-white text-lg p-4 border-b bg-primary">Bought tickets</h4>
                                <p class="text-xl px-4 py-8">112</p>
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-6 lg:col-span-4">
                            <div class="bg-white shadow-lg border border-gray-200 rounded-md overflow-hidden">
                                <h4 class="font-medium text-white text-lg p-4 border-b bg-primary">Restaurant
                                    reservations</h4>
                                <p class="text-xl px-4 py-8">44</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>



</html>