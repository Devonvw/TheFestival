<?php


?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script>

</script>
<header>
    <title>Login - Social</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta property="og:title" content="Login - Social" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://socialdevon.000webhostapp.com/" />
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
        <?php include __DIR__ . '/../../components/nav.php' ?>
        <div class="container mx-auto px-4 py-32">
            <a href="#" class="text-black text-sm font-medium">Back to Events</a>
            <h1 class="text-black text-3xl font-bold mt-6">Your Cart</h1>
            <hr class="mt-6 w-8/12 border-t border-black opacity-50">
            <div class="flex flex-col md:flex-row items-end md:items-center justify-between">
                <div class="w-full md:w-1/2 lg:w-2/3">
                    <!-- Cart items -->
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 md:ml-10 lg:ml-20 mt-8 md:mt-0">
                    <div class="bg-white border border-black rounded-lg p-4">
                        <h2 class="text-gray-800 text-xl font-bold mb-4">Order Summary</h2>
                        <div class="flex justify-between border-b border-gray-300 pb-4">
                            <p class="text-gray-700">Subtotal</p>
                            <p class="text-gray-800">$100.00</p>
                        </div>
                        <div class="flex justify-between border-b border-gray-300 pb-4">
                            <p class="text-gray-700">VAT</p>
                            <p class="text-gray-800">$20.00</p>
                        </div>
                        <div class="flex justify-between pt-4">
                            <p class="text-gray-700 font-bold">Total</p>
                            <p class="text-gray-800 font-bold">$120.00</p>
                        </div>
                    </div>
                    <div class="bg-white border border-black rounded-lg p-4 mt-8">
                        <h2 class="text-gray-800 text-xl font-bold mb-4">Contact</h2>

                    </div>
                    <div class="text-gray-800 text-sm">
                        <p class="mb-2 text-black">Payment methods</p>
                        <div class="flex items-center mb-4">


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>