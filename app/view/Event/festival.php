<?php
// if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
//     header("location: /");
//     exit;
// }

?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/utils/getImage.js"></script>
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

<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v16.0&appId=4731276436960002&autoLogAppEvents=1" nonce="z6VwweeS"></script>
    <div class="">
        <?php include __DIR__ . '/../../components/nav.php' ?>

        <div class="flex flex-col information-page overflow-hidden" style="margin-top: 200px;" id="sections">
            <section class="py-10">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-6">Haarlem Jazz</h2>
                    <p class="text-lg leading-7">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra tristique tortor, id mollis tellus fringilla ac. Nullam nec gravida sapien. Nulla in ipsum in quam elementum ornare. Integer vitae ligula non est bibendum laoreet. Donec viverra sapien non elit eleifend congue. Fusce elementum diam a dolor faucibus, vel viverra odio lacinia. Sed quis blandit leo, vitae venenatis libero. Proin vel dapibus lorem, in pellentesque augue.
                    </p>
                </div>
            </section>
            <section class="bg-gray-100 py-10">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-6">The Secret of Dr. Teyler</h2>
                    <p class="text-lg leading-7">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra tristique tortor, id mollis tellus fringilla ac. Nullam nec gravida sapien. Nulla in ipsum in quam elementum ornare. Integer vitae ligula non est bibendum laoreet. Donec viverra sapien non elit eleifend congue. Fusce elementum diam a dolor faucibus, vel viverra odio lacinia. Sed quis blandit leo, vitae venenatis libero. Proin vel dapibus lorem, in pellentesque augue.
                    </p>
                </div>
            </section>
            <section class="py-10">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-6">Yummie</h2>
                    <p class="text-lg leading-7">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra tristique tortor, id mollis tellus fringilla ac. Nullam nec gravida sapien. Nulla in ipsum in quam elementum ornare. Integer vitae ligula non est bibendum laoreet. Donec viverra sapien non elit eleifend congue. Fusce elementum diam a dolor faucibus, vel viverra odio lacinia. Sed quis blandit leo, vitae venenatis libero. Proin vel dapibus lorem, in pellentesque augue.
                    </p>
                </div>
            </section>
            <section class="bg-gray-100 py-10">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-6">History</h2>
                    <p class="text-lg leading-7">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra tristique tortor, id mollis tellus fringilla ac. Nullam nec gravida sapien. Nulla in ipsum in quam elementum ornare. Integer vitae ligula non est bibendum laoreet. Donec viverra sapien non elit eleifend congue. Fusce elementum diam a dolor faucibus, vel viverra odio lacinia. Sed quis blandit leo, vitae venenatis libero. Proin vel dapibus lorem, in pellentesque augue.
                    </p>
                </div>
            </section>
            <section class="py-10">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-6">Dance</h2>
                    <p class="text-lg leading-7">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra tristique tortor, id mollis tellus fringilla ac. Nullam nec gravida sapien. Nulla in ipsum in quam elementum ornare. Integer vitae ligula non est bibendum laoreet. Donec viverra sapien non elit eleifend congue. Fusce elementum diam a dolor faucibus, vel viverra odio lacinia. Sed quis blandit leo, vitae venenatis libero. Proin vel dapibus lorem, in pellentesque augue.
                    </p>
                </div>
            </section>
            <section class="bg-gray-100 py-10">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-6">Schedule</h2>
                    <p class="text-lg leading-7">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra tristique tortor, id mollis tellus fringilla ac. Nullam nec gravida sapien. Nulla in ipsum in quam elementum ornare. Integer vitae ligula non est bibendum laoreet. Donec viverra sapien non elit eleifend congue. Fusce elementum diam a dolor faucibus, vel viverra odio lacinia. Sed quis blandit leo, vitae venenatis libero. Proin vel dapibus lorem, in pellentesque augue.
                    </p>
                </div>
            </section>
        </div>
        <div class="container mx-auto">
            <div class="fb-share-button" data-href="" data-layout="" data-size=""></div>
        </div>
        <?php include __DIR__ . '/../../components/footer.php' ?>
    </div>

</body>

</html>