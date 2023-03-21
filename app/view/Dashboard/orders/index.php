<?php 
/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /");
    exit;
}*/
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@6.0"></script>
<script>
window.addEventListener("load", (event) => {
    getOrders()
});

function downloadInvoice(id) {
    fetch(`${window.location.origin}/api/invoice?orderId=${id}`, {
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();

            var a = document.createElement("a"); //Create <a>
            a.href = "data:application/pdf;base64," + data?.file; //Image Base64 Goes here
            a.download = `invoice-${data?.id}.pdf`; //File name Here
            a.click(); //Downloaded file
        }
    }).catch((res) => {});
}

function setActiveAccount(id) {
    fetch(`${window.location.origin}/api/account/active?id=${id}`, {
        method: "PUT",
        body: null
    }).then(async (res) => {
        if (res.ok) getAccounts();
    }).catch((res) => {});
}

function getOrders() {
    fetch(`${window.location.origin}/api/order/all`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();

            const dataArray = data.map(item => Object.values(item).concat([false]));

            new simpleDatatables.DataTable("table", {
                data: {
                    headings: ["Id", "Account ID", "Name", "Total", "Created At", ""],
                    data: dataArray,
                },
                columns: [{
                    select: 3,
                    render: (value, _td, _rowIndex, _cellIndex) =>
                        `€${value.toFixed(2)}`
                }, {
                    select: 5,
                    sortable: false,
                    render: (value, _td, _rowIndex, _cellIndex) => {
                        return `
                        <div class="ml-auto flex flex-row gap-x-2">
                            <a href="/dashboard/order/edit?id=${dataArray[_rowIndex][0]}" class="bg-gray-800 h-[1.7rem] w-[1.7rem] flex items-center">
                                <img src="../assets/icons8-pencil-drawing-100.png" class="w-full scale-[0.80] h-[1.5rem] mx-auto" />
                            </a>
                            <button button onclick="downloadInvoice(${dataArray[_rowIndex][0]})" class="bg-black h-[1.7rem] w-[1.7rem] flex items-center">
                                <img src="../assets/download-icon.png" class="w-3/4 h-[1.5rem] mx-auto" />
                            </button>
                        </div>`
                    }
                }]
            })
        }
    }).catch((res) => {});
}
</script>
<header>
    <link rel="stylesheet" href="../styles/globals.css">
    <link rel="stylesheet" href="../styles/simple-datatables.css">
    <title>Orders - The Festival</title>
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
            <?php include __DIR__ . '/../../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">
                <div class="shadow-xl border-black w-full p-4 px-8 mb-10">
                    <h2 class="text-2xl font-semibold">Orders</h2>
                </div>
                <div class="px-4 md:px-6 lg:px-8">
                    <table class="table"></table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>