<?php 
/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    eader("location: /");
    exit;
}*/
?>

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

<body>
<?php include __DIR__ . '/../../components/navbar.php' ?>
    <div class="">
        <div class="w-screen relative">
            <?php include __DIR__ . '/../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">
                <div class="shadow-xl border-black w-full p-4 px-8">
                    <h2 class="text-2xl font-semibold">Dashboard</h2>
                </div>
                <div class="px-4 md:px-6 lg:px-8 mt-10">
                    <div class="grid grid-cols-12 gap-12">
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
    <?php include __DIR__ . '/../../components/footer.php' ?>
</body>



</html>

