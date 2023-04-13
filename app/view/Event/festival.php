<?php
// if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
//     header("location: /");
//     exit;
// }

?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/utils/getImage.js"></script>
<script>
    window.addEventListener("load", () => {
            getMainEvents();
        });
    function getMainEvents() {
        fetch(`${window.location.origin}/api/event/main-events`, {
                headers: {
                    'Content-Type': 'application/json'
                },
                method: "GET",
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                const smallHeaderImageDance = document.getElementById('small-header-image-dance');
                const smallHeaderImageJazz = document.getElementById('small-header-image-jazz');
                const smallHeaderImageYummie = document.getElementById('small-header-image-yummie');
                if (data.length > 0) {
                    smallHeaderImageDance.src = getImage(data[1]?.description);
                    smallHeaderImageYummie.src = getImage(data[0]?.description);
                    smallHeaderImageJazz.src = getImage(data[2]?.description);
                }
            })
            .catch((error) => {
                console.log(error);
            });
    }
</script>
<header>
    <title>Festival - Haarlem</title>
    <link rel="stylesheet" href="../../styles/globals.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Login - The Festival" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://the-festival-haarlem.000webhostapp.com/" />
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</header>

<script>
    window.addEventListener("load", (event) => {

    });
</script>

<body class="bg-gray-100 font-sans">
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v16.0&appId=4731276436960002&autoLogAppEvents=1" nonce="z6VwweeS"></script>
    <?php include __DIR__ . '/../../components/nav.php' ?>
    <div class="relative h-80" style="background-image: url('https://source.unsplash.com/featured/?concert'); background-size: cover; background-position: center; margin-top:110px;">
        <div class="absolute inset-0 backdrop-blur-md"></div>
        <div class="container mx-auto px-4 md:px-6 lg:px-8 text-white relative">
            <div class="flex flex-col items-center justify-end text-center h-full pb-4">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                    Festival
                </h1>
            </div>
        </div>
    </div>
    <section class="py-20 text-center">

        <div class="mx-auto" style="max-width: 600px;">
            <h3 class="">The Festival is a summer event, taking place over four days from Thursday 28th July to Sunday 31st July in Haarlem. It targets a wide audience, including families, culinary enthusiasts, music lovers and anyone looking to experience the great city of Haarlem.

                There are five events taking place, including Haarlem Jazz, DANCE!, Yummie!, A Stroll Through History and The Secret of Dr Teyler. Find out more by reading below!</h3>
        </div>
    </section>
    <div class="bg-primary py-20 text-center">
        <h1 class="text-5xl font-bold text-white mb-4">The secret of dr. Teyler</h1>
        <h2 class="text-xl text-white">Discover the backstory of professor Teyler</h2>
        <h3 class="text-white">Challenges, achievements, rewards and much more</h3>
        <button class="py-2 px-4 mt-4 rounded-md" style="background-color: #E8BF56;">Visit app</button>
    </div>

    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 mt-10">
        <div>
            <img id="small-header-image-dance" src="" alt="Concert" class="w-full h-96 object-cover rounded-md">
        </div>
        <div>
            <h2 class="text-3xl font-bold mb-4">Dance!</h2>
            <p class="mb-4">A new addition to the festival is Haarlem Dance, which focuses on the latest dance, house, techno, and trance music. Six of the world's top DJs will entertain their audiences in back-to-back sessions, as well as in smaller experimental (club) sessions.</p>
            <a id="scroll-to-event-list" href="/events/music/dance" class="bg-primary text-white py-2 px-4 rounded-md">Read more</a>
        </div>
    </section>
    <div class="bg-primary py-20 text-center">
        <h1 class="text-5xl font-bold text-white mb-4">History</h1>
        <a id="scroll-to-event-list" href="#" class="bg-yellow-500 text-white py-2 px-4 rounded-md">Read more</a>
    </div>
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 mt-10">
        <div>
            <img id="small-header-image-jazz" src="" alt="Concert" class="w-full h-96 object-cover rounded-md">
        </div>
        <div>
            <h2 class="text-3xl font-bold mb-4">Jazz!</h2>
            <p class="mb-4">One of the haarlem festival events is the Haarlem Jazz event. From July 26 to 29, jazz can be heard in the Patronaat and on the Grote Markt. The Patronaat has several venues open with prices ranging from 10 to 15 euros. The Grote Markt is open for jazz on July 29 with free admission. The Haarlem Jazz event features a variety of artists, including the Gumbo Kings, Gare du Nord and Evolve.</p>

            <a id="scroll-to-event-list" href="#" class="bg-primary text-white py-2 px-4 rounded-md">Read more</a>

        </div>
    </section>
    <div class="bg-primary py-20">
    <div class="container mx-auto text-center">
        <h1 class="text-5xl font-bold text-white mb-4">Yummie</h1>
        <div class="flex items-center justify-center mt-8">
            <img id="small-header-image-yummie" class="w-1/2" src="" alt="Yummie Image">
            <div class="text-white ml-8">
                <h2 class="text-2xl font-bold mb-4">Haarlem Festival</h2>
                <p>Although Haarlem is not known for its food or culinary traditions, there are many restaurants worth visiting. From French to Asian and fish to vegetarian. Haarlem has it all. During the Haarlem festival, there are some restaurants that have created a special Haarlem festival menu for a reduced price. From 27 to 31 July, seven restaurants will have 2 or 3 sessions per day open for reservations.</p>
                <div class="mt-4">
                  <a id="scroll-to-event-list" href="#" class="bg-yellow-500 text-white py-2 px-4 rounded-md">Read more</a>
                </div>
            </div>
        </div>
    </div>
</div>



    <div class="calendar-container mt-10">
        <div id="calendar" class="mx-auto mb-10"></div>
    </div>
    <div class="bg-primary py-20 text-center">
        <h1 class="text-5xl font-bold text-white mb-4">Share The Fun</h1>
        <p class="text-xl text-white">Spread the word about our events with your friends</p>
        <div class="container mx-auto mt-4">
            <div class="fb-share-button" data-href="" data-layout="" data-size=""></div>
        </div>
    </div>
    
    <?php include __DIR__ . '/../../components/footer.php' ?>
</body>


</html>