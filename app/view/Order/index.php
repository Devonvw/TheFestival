<?php
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
<script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
<script>
window.addEventListener("load", (event) => {
    getOrder();
});

const formatDate = (input) => {
    const date = new Date(input);

    return `${date?.getDate()}-${date?.getMonth() + 1}-${date?.getFullYear()} ${date?.getHours() < 10 ? `0${date?.getHours()}` : date?.getHours()}:${date?.getMinutes() < 10 ? `0${date?.getMinutes()}` : date?.getMinutes()}`;
}

const createPayment = () => {
    fetch(`${window.location.origin}/api/payment`, {
        method: "POST",
        body: JSON.stringify({
            method: document.querySelector('input[name="rate"]:checked').value,
            issuer: document.getElementById("idealIssuers").value,
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
        }
    }).catch((res) => {});
}

const handleIdeal = (e) => {
    if (e?.value == "Ideal")
        document.getElementById("idealIssuersWrapper").style.display = "block";
    else
        document.getElementById("idealIssuersWrapper").style.display = "none";
}

function getOrder() {
    const params = new URLSearchParams(window.location.search)

    fetch(`${window.location.origin}/api/order/status?id=${params.get("id")}`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();
            if (data?.status != 'paid') window.location = "/cart";

            fetch(`${window.location.origin}/api/order?id=${params.get("id")}`, {
                headers: {
                    'Content-Type': 'application/json'
                },
                method: "GET",
            }).then(async (res) => {
                if (res.ok) {
                    const data = await res.json();
                    var orderItemsHTML = "";

                    data?.order_items?.forEach((orderItem) => orderItemsHTML += `
            <div class="w-full flex flex-wrap gap-x-4 gap-y-4 border-b border-black pb-4 mb-4">
                            <div class="h-24 w-24 rounded-full bg-gray-300 my-auto"></div>
                            <div class="mr-auto">
                                <ul>
                                    <li>
                                        <p>${orderItem?.ticket?.event_name}</p>
                                    </li>
                                    <li>
                                        <p>${orderItem?.ticket?.event_item_name}</p>
                                    </li>
                                    <li>
                                        <p>${formatDate(orderItem?.ticket?.start)} - ${formatDate(orderItem?.ticket?.end)}</p>
                                    </li>
                                    <li class="flex gap-x-2">
                                    <p>${orderItem?.quantity} x ${orderItem?.ticket?.persons} person(s)</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
            `);

                    document.getElementById("orderItems").innerHTML = orderItemsHTML;

                    var Calendar = window.tui.Calendar;

                    var cal = new Calendar('#calendar', {
                        defaultView: 'week',
                        isReadOnly: true,
                        week: {
                            startDayOfWeek: 3,
                            taskView: false,
                            dayNames: ["Zo", "Ma", "Di", "Woe", "Do", "Vr", "Za"],
                        },

                        template: {
                            timegridDisplayPrimaryTime: function({
                                time
                            }) {
                                const date = new Date(time);
                                return `${date.getHours() < 10 ? `0${date.getHours()}` : date.getHours()}:00`;
                            },

                        }
                    });
                    cal.setDate("2023-07-27");

                    cal.createEvents(data?.order_items?.map((orderItem, index) => ({
                        id: index,
                        calendarId: '1',
                        title: orderItem?.ticket?.event_item_name,
                        category: 'time',
                        start: orderItem?.ticket?.start,
                        end: orderItem?.ticket?.end,
                        backgroundColor: "#008080",
                        color: "#FFF",
                        customStyle: {
                            display: "flex",
                            flexWrap: "wrap"
                        }
                    })));
                }
            }).catch((res) => {
                console.log(res)
            });
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
            <h1 class="text-black text-3xl font-bold mt-6">Order was successful!</h1>
            <div class="flex flex-col md:flex-row justify-between">
                <div class="w-full md:w-1/2 lg:w-[63%] pt-4 mt-4 border-t border-black">
                    <div id="calendar"></div>
                </div>
                <div class="w-full md:w-1/2 lg:w-[37%] md:ml-10 lg:ml-20 mt-8 md:mt-4">
                    <div class="bg-white border-2 border-primary rounded-lg p-4">
                        <h2 class="text-gray-800 text-xl font-bold mb-4">Order Summary</h2>
                        <div id="orderItems"></div>
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
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/../../components/footer.php' ?>
    </div>
</body>

</html>