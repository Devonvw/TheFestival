<?php
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script>
window.addEventListener("load", (event) => {
    getCart();
    getAccountInfo();
    getIdealIssuers();
});

const formatDate = (input) => {
    const date = new Date(input);

    return `${date?.getDate()}-${date?.getMonth()}-${date?.getFullYear()} ${date?.getHours() < 10 ? `0${date?.getHours()}` : date?.getHours()}:${date?.getMinutes() < 10 ? `0${date?.getMinutes()}` : date?.getMinutes()}`;
}

const getAccountInfo = () => {
    fetch(`${window.location.origin}/api/me`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();

            document.getElementById('name').value = `${data.first_name} ${data.last_name}`;
            document.getElementById('email').value = data.email;
        }
    }).catch((res) => {
        console.log(res)
    });
}

const createPayment = () => {
    const params = new URLSearchParams(window.location.search)

    fetch(`${window.location.origin}/api/payment?token=${params.get('token')}`, {
        method: "POST",
        body: JSON.stringify({
            method: document.querySelector('input[name="paymentMethod"]:checked')?.value,
            issuer: document.getElementById("idealIssuers")?.value,
            name: document.getElementById("name").value,
            email: document.getElementById("email").value,
            country: document.getElementById("country").value,
            city: document.getElementById("city").value,
            zipcode: document.getElementById("zipcode").value,
            address: document.getElementById("address").value,
        })
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();
            window.location = data?.link;
        } else {
            document.getElementById('error').innerHTML = (await res.json())?.msg;
            document.getElementById('errorWrapper').classList.remove('hidden');

        }
    }).catch((res) => {
        console.log(res);
    });
}

const getIdealIssuers = () => {
    fetch(`${window.location.origin}/api/payment/ideal-issuers`, {
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();

            const issuerSelect = document.getElementById("idealIssuers");

            Object.keys(data).forEach((issuer) => {
                const newOption = new Option(data[issuer]?.name, data[issuer]?.id);
                issuerSelect.add(newOption, undefined);
            });
        }
    }).catch((res) => {});
}

const handleIdeal = (e) => {
    if (e?.value == "Ideal")
        document.getElementById("idealIssuersWrapper").style.display = "block";
    else
        document.getElementById("idealIssuersWrapper").style.display = "none";
}

function getCart() {
    const params = new URLSearchParams(window.location.search)

    fetch(`${window.location.origin}/api/cart?token=${params.get('token')}`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();
            var cartItemsHTML = "";


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
    <title>Checkout - The Festival</title>
    <link rel="stylesheet" href="../styles/globals.css">
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
</header>

<body>
    <div class="">
        <?php include __DIR__ . '/../../components/nav.php' ?>
        <div class="container mx-auto px-4 py-32">
            <a href="/cart" class="text-black text-sm font-medium">Back to Cart</a>
            <h1 class="text-black text-3xl font-bold mt-6">Checkout</h1>
            <div class="flex flex-col md:flex-row justify-between">
                <div class="w-full md:w-1/2 lg:w-[63%] pt-4 mt-4 border-t border-black">
                    <form class="flex flex-col gap-y-10">
                        <div>
                            <div class="flex items-center gap-x-2 mb-4"><span
                                    class="h-6 w-6 text-white flex items-center justify-center rounded-full bg-primary">1</span>
                                <h4 class="font-medium text-lg">Payment Information</h4>
                            </div>
                            <div class="bg-red-200 p-2 w-full rounded-lg flex text-red-700 items-center text-sm my-3 hidden"
                                id="errorWrapper"><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <p id="error"></p>
                            </div>
                            <div class="grid grid-cols-12 gap-x-4 gap-y-2">
                                <div class="col-span-12 md:col-span-6">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                                        Name</label>
                                    <input maxlength="255" type="text" name="name" id="name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Name..." required="">
                                </div>
                                <div class="col-span-12 md:col-span-6">
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                                        Email</label>
                                    <input maxlength="255" type="text" name="email" id="email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Email..." required="">
                                </div>
                                <div class="col-span-12 md:col-span-6">
                                    <label for="country" class="block mb-2 text-sm font-medium text-gray-900">
                                        Country</label>
                                    <input maxlength="255" type="text" name="country" id="country"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Country..." required="">
                                </div>
                                <div class="col-span-12 md:col-span-6">
                                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900">
                                        City</label>
                                    <input maxlength="255" type="text" name="city" id="city"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="City..." required="">
                                </div>
                                <div class="col-span-12 md:col-span-6">
                                    <label for="zipcode" class="block mb-2 text-sm font-medium text-gray-900">
                                        Zipcode</label>
                                    <input maxlength="255" type="text" name="zipcode" id="zipcode"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Zipcode..." required="">
                                </div>
                                <div class="col-span-12 md:col-span-6">
                                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900">
                                        Address</label>
                                    <input maxlength="255" type="text" name="address" id="address"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Address..." required="">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-x-2 mb-4"><span
                                    class="h-6 w-6 text-white flex items-center justify-center rounded-full bg-primary">2</span>
                                <h4 class="font-medium text-lg">Payment Methods</h4>
                            </div>
                            <div class="flex flex-col w-fit"><label class="w-full">
                                    <input onclick="handleIdeal(this)" type="radio" name="paymentMethod" value="Ideal">
                                    <span class="value flex items-center gap-x-2">Ideal <img
                                            src="/assets/icons8-ideal-96.png"
                                            class="ml-auto h-6 w-8 object-contain" /></span>
                                </label>
                                <label>
                                    <input onclick="handleIdeal()" type="radio" name="paymentMethod" value="Paypal">
                                    <span class="value flex items-center gap-x-2">Paypal <img
                                            src="/assets/icons8-paypal-144.png"
                                            class="ml-auto h-6 w-8 object-contain" /></span>
                                </label>
                            </div>
                            <div class="mt-4 hidden" id="idealIssuersWrapper"><label for="idealIssuers">Ideal
                                    issuers</label>
                                <select name="idealIssuers" id="idealIssuers">
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="w-full md:w-1/2 lg:w-[37%] md:ml-10 lg:ml-20 mt-8 md:mt-4">
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
                        <button onclick="createPayment()"
                            class="mt-4 p-3 rounded-md w-full bg-primary hover:scale-[1.02] duration-300 text-white font-medium">Order
                            and pay</button>
                    </div>
                    <div class="bg-white border-2 border-primary rounded-lg p-4 mt-4">
                        <h2 class="text-gray-800 text-xl font-bold mb-4">Contact</h2>
                        <div class="flex items-center flex-wrap gap-x-2"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            <a href="tel:+31612345678">+31 6 12345678</a>
                        </div>
                        <div class="flex items-center flex-wrap gap-x-2"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5">
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