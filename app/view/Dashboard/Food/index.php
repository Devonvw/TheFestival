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
<?php include __DIR__ . '/../../../components/nav.php' ?>

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

    

    <?php include __DIR__ . '/../../../components/footer.php' ?>
</body>



</html>