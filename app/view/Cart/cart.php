<?php
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script>
window.addEventListener("load", (event) => {
    getCart();
});

const formatDate = (input) => {
    const date = new Date(input);

    return `${date?.getDate()}-${date?.getMonth()}-${date?.getFullYear()} ${date?.getHours() < 10 ? `0${date?.getHours()}` : date?.getHours()}:${date?.getMinutes() < 10 ? `0${date?.getMinutes()}` : date?.getMinutes()}`;
}

function getCart() {
    fetch(`${window.location.origin}/api/cart`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();
            console.log(data)
            var cartItemsHTML = "";

            data?.cart_items?.forEach((cartItem) => cartItemsHTML +=
                `
            <div class="w-full flex flex-wrap gap-x-4 gap-y-4 border-b border-black pb-4 mb-4">
                            <div class="h-24 w-24 rounded-full bg-gray-300 my-auto"></div>
                            <div class="mr-auto">
                                <ul>
                                    <li>
                                        <p>${cartItem?.ticket?.event_name}</p>
                                    </li>
                                    <li>
                                        <p>${cartItem?.ticket?.event_item_name}</p>
                                    </li>
                                    <li>
                                        <p>${formatDate(cartItem?.ticket?.start)} - ${formatDate(cartItem?.ticket?.end)}</p>
                                    </li>
                                    <li>
                                        <p>${cartItem?.quantity}x ${cartItem?.ticket?.persons} person(s)</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="flex">
                                <div class="mr-8">
                                    <ul>
                                        <li>
                                            <p class="font-medium">Per ticket / person</p>
                                        </li>
                                        <li>
                                            <p>${cartItem?.ticket?.price},-</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mr-4">
                                    <ul>
                                        <li>
                                            <p class="font-medium">Total</p>
                                        </li>
                                        <li>
                                            <p>${cartItem?.ticket?.price * cartItem?.quantity},-</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    `
            )

            document.getElementById("cartItems").innerHTML = cartItemsHTML;

            document.getElementById("subtotal").innerHTML = `€${data?.subtotal?.toFixed(2)}`;
            document.getElementById("vat").innerHTML = `€${data?.vat?.toFixed(2)}`;
            document.getElementById("total").innerHTML = `€${data?.total?.toFixed(2)}`;
        }
    }).catch((res) => {
        console.log(res)
    });
}
</script>
<header>
    <title>Cart - Social</title>
    <link rel="stylesheet" href="../styles/globals.css">
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
        <div class="container mx-auto px-4 py-32">
            <a href="#" class="text-black text-sm font-medium">Back to Events</a>
            <h1 class="text-black text-3xl font-bold mt-6">Your Cart</h1>
            <div class="flex flex-col md:flex-row justify-between">
                <div class="w-full md:w-1/2 lg:w-3/4 pt-4 mt-4 border-t border-black">
                    <!-- Cart items -->
                    <div id="cartItems">
                        <div class="w-full flex flex-wrap gap-x-4 gap-y-4 border-b border-black pb-4">
                            <div class="h-24 w-24 rounded-full bg-gray-300 my-auto"></div>
                            <div class="mr-auto">
                                <ul>
                                    <li>
                                        <p>Yummie!</p>
                                    </li>
                                    <li>
                                        <p>Reservation for Restaurant ML</p>
                                    </li>
                                    <li>
                                        <p>Saturday July 28, 19:00 - 21:00</p>
                                    </li>
                                    <li>
                                        <p>4 persons</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="flex">
                                <div class="mr-8">
                                    <ul>
                                        <li>
                                            <p class="font-medium">Per person</p>
                                        </li>
                                        <li>
                                            <p>10,-</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="">
                                    <ul>
                                        <li>
                                            <p class="font-medium">Total</p>
                                        </li>
                                        <li>
                                            <p>40,-</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/4 md:ml-10 lg:ml-20 mt-8 md:mt-4">
                    <div class="bg-white border-2 border-primary rounded-lg p-4">
                        <h2 class="text-gray-800 text-xl font-bold mb-4">Order Summary</h2>
                        <div class="flex justify-between border-b border-gray-300 pb-2">
                            <p class="text-gray-700">Subtotal</p>
                            <p id="subtotal" class="text-gray-800">$100.00</p>
                        </div>
                        <div class="flex flex-wrap justify-between border-b border-gray-300 mt-2 pb-2">
                            <p class="text-gray-700">VAT</p>
                            <p id="vat" class="text-gray-800">$20.00</p>
                        </div>
                        <div class="flex flex-wrap justify-between pt-4">
                            <p class="text-gray-700 font-bold">Total</p>
                            <p id="total" class="text-gray-800 font-bold">$120.00</p>
                        </div>
                        <button
                            class="mt-4 p-3 rounded-md w-full bg-primary hover:scale-[1.02] duration-300 text-white font-medium">Checkout</button>
                    </div>
                    <div class="bg-white border-2 border-primary rounded-lg p-4 mt-4">
                        <h2 class="text-gray-800 text-xl font-bold mb-4">Contact</h2>
                        <div class="flex items-center gap-x-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            <a href="tel:+31612345678">+31 6 12345678</a>
                        </div>
                        <div class="flex items-center gap-x-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <a href="mailto:festivalteamhaarlem@gmail.com">festivalteamhaarlem@gmail.com</a>
                        </div>
                    </div>
                    <div class="text-gray-800 text-sm flex items-center justify-between mt-2">
                        <p class="text-black font-bold text-base">Payment methods</p>
                        <div class="flex items-center h-8">
                            <img src="/assets/icons8-ideal-96.png" class="h-full w-full" />
                            <img src="/assets/icons8-paypal-144.png" class="h-full w-full" />

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>