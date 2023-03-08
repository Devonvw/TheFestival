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
    <title>Home - Festival</title>
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
    <div class="flex flex-col relative w-screen -mt-10 overflow-x-hidden">
        <img src="../assets/festival-image.svg" class="h-15 w-screen" />
    </div>

    <div class="flex flex-col items-center">
            <h2 class="text-8xl text-cyan-900">The Festival</h2>
        </div>

    <div class="relative container mx-auto w-full">
        <div class="flex flex-col items-center justify-center py-10 ">
           <h1 class="text-4xl text-center pt-32 px-52">The Festival is a summer event, taking place over four days from Thursday 28th July to Sunday 31st July in Haarlem. 
            It targets a wide audience, including families, culinary enthusiasts, music lovers and anyone looking to experience the great city of Haarlem.</h1>
            <h1 class="text-4xl text-center pt-32 px-52"> here are five events taking place, including Haarlem Jazz, DANCE!, Yummie!, A Stroll Through History and The Secret of Dr Teyler. Find out more by reading below!</h1>
        </div>
    </div>

   




    <?php include __DIR__ . '/../../../../components/footer.php' ?>
</body>



</html>