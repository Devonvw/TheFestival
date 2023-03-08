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
    <title>Home - Food</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Food - Home" />
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
<?php include __DIR__ . '/../../../../components/nav.php' ?>

<body>
    <div class="flex flex-col relative w-screen -mt-10">
        <img src="../assets/food-homepage-image.svg" class="h-15 w-screen" />
    </div>

    <div class="flex flex-col pt-10 px-40 -mt-10 bg-[url('../assets/scribble.svg')] bg-no-repeat w-screen" style="background-size:100%;">
        <div class="flex flex-col items-center">
            <h2 class="text-7xl text-cyan-900">Haarlem For Foodies  </h2>
        </div>
        <div class="flex flex-row">
            <div class="basis-1/2 py-8">
                <img src="../assets/plate-icon.svg" class="h-5/6 w-screen" />
            </div>
            <div class="basis-1/2 py-8">
                
               <div class="bg-gray-100 rounded-lg h-4/6">
                <div class="ml-6 mr-24 py-4">
                    <h1 class="text-6xl pt-8">Foodie</h1>
                    <h2 class="text-4xl mt-20">When one thinks of Haarlem, culinary experiences come to mind. 
                                                From fancy dining to a quick bite at one of the many food cafes,
                                                 or relaxing in a trendy coffee bar, tasting room or brewery.</h2>
                </div>
               </div>
            </div>
        </div>
    </div>



    <?php include __DIR__ . '/../../../../components/footer.php' ?>
</body>



</html>