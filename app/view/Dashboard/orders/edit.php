<?php 
/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /");
    exit;
}*/
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script>
window.addEventListener("load", (event) => {
    getOrderStatus();
});

function editOrderStatus(e) {
    e.preventDefault();
    const params = new URLSearchParams(window.location.search)

    fetch(`${window.location.origin}/api/payment/status?id=${params.get("id")}`, {
        method: "POST",
        body: JSON.stringify({
            id: params.get("id"),
            status: document.getElementById('statusses').value,
        })
    }).then(async (res) => {
        if (res.ok) window.location = "/dashboard/orders";

        ToastError((await res.json())?.msg);
    }).catch((res) => {});
}

function getOrderStatus() {
    const params = new URLSearchParams(window.location.search)
    fetch(`${window.location.origin}/api/order/status?id=${params.get("id")}`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        const data = await res.json();

        if (!res.ok) {
            ToastError((await res.json())?.msg);
            window.location = "/dashboard/orders";
        }

        document.getElementById('statusses').value = data?.status;
        document.getElementById('orderId').innerHTML = `Edit order ${data?.id}`;
    }).catch((res) => {});
}
</script>
<header>
    <link rel="stylesheet" href="../../styles/globals.css">
    <title>Edit Order - The Festival</title>
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

<body>
    <div class="">
        <div class="w-screen relative">
            <?php include __DIR__ . '../../../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">
                <div class="shadow-xl border-black w-full p-4 px-8 mb-10">
                    <h2 id="orderId" class="text-2xl font-semibold">Edit order </h2>
                </div>
                <div class="px-4 md:px-6 lg:px-8">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 id="orderId"
                            class="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Edit order
                        </h1>
                        <form id="editForm" class="space-y-4 md:space-y-6" onsubmit="editOrderStatus(event)">
                            <div class="mt-4" id="statussesWrapper"><label for="statusses">Choose new
                                    status</label>
                                <select name="statusses" id="statusses"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="paid">Paid</option>
                                    <option value="waiting for payment">Waiting for payment</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div><button type="submit" class="w-full text-white bg-primary p-2 rounded-lg">
                                    Save
                                </button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>