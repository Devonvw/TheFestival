<?php 
/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /");
    exit;
}*/
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
<script>
window.addEventListener("load", (event) => {
    getUsers()
});



function getUsers() {
    fetch(`${window.location.origin}/api/accounts`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();
            new window.simpleDatatables.DataTable("table", {
                data: {
                    headings: Object.keys(data[0]),
                    data: data.map(item => Object.values(item))
                },
            })
            console.log(data.map(item => Object.values(item)))
            console.log(Object.keys(data[0]))

        }
    }).catch((res) => {});
}
</script>
<header>
    <link rel="stylesheet" href="../styles/globals.css">
    <link rel="stylesheet" href="../styles/simple-datatables.css">
    <title>Users - The Festival</title>
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
            <?php include __DIR__ . '/../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">
                <div class="shadow-xl border-black w-full p-4 px-8">
                    <h2 class="text-2xl font-semibold">Accounts</h2>
                </div>
                <div class="px-4 md:px-6 lg:px-8">
                    <table class="table"></table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>