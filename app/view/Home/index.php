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
window.addEventListener("load", (event) => {
    getHomePage();
    getInstagramFeed();
});

const getInstagramFeed = () => {
    fetch(`${window.location.origin}/api/instagram-feed`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();
            console.log(data)

            var feedHTML = "";

            data?.data?.forEach((item, index) => feedHTML +=
                `<a class="tranform hover:scale-[1.02] duration-300 col-span-12 md:col-span-6 lg:col-span-4" href="${item?.permalink}" target="_blank"><div class="rounded-md overflow-hidden shadow-xl">
                            <img src="${item?.media_url}" class="h-60 w-full object-cover" />
                            <p class="p-3">${item?.caption}</p>
                        </div></a>`
            )

            document.getElementById("instagramFeed").innerHTML = feedHTML;
        }
    }).catch((res) => {
        console.log(res)
    });
}

function getHomePage() {
    fetch(`${window.location.origin}/api/information-page/home-page`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();
            console.log(data)

            document.getElementById('header').style.backgroundImage = `url('${getImage(data?.image)}')`;
            document.getElementById('headerTitle').innerHTML = data?.title;
            document.getElementById('headerSubtitle').innerHTML = data?.subtitle;
            document.getElementById('section1').innerHTML = data?.sections[0]?.text;
            document.getElementById('section2').innerHTML = data?.sections[1]?.text;

            // document.getElementById('metaTitle').value = data?.meta_title;
            // document.getElementById('metaDesc').value = data?.meta_description;
            // document.getElementById('title').value = data?.title;
            // document.getElementById('subtitle').value = data?.subtitle;
            // if (data?.image) document.getElementById('image').src = getImage(data?.image);
            // tinymce.get("section1").setContent(data?.sections[0]?.text ? data?.sections[0]?.text : "");
            // tinymce.get("section2").setContent(data?.sections[1]?.text ? data?.sections[1]?.text : "");
            // document.getElementById('section1').setAttribute("name", data?.sections[0] ? data?.sections[0]
            //     ?.id : "");
            // document.getElementById('section2').setAttribute("name", data?.sections[1] ? data?.sections[1]
            //     ?.id : "");
        }
    }).catch((res) => {
        console.log(res)
    });
}
</script>
<header>
    <title>Home - TheFestival</title>
    <link rel="stylesheet" href="../../styles/globals.css">
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
        <div id="header" class="h-screen bg-cover relative">
            <div class="absolute top-0 left-0 h-full w-full bg-gradient-to-b from-transparent via-transparent to-white">
            </div>
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
                <h1 id="headerTitle" class="text-7xl font-semibold text-center"></h1>
            </div>
            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full">
                <p id="headerSubtitle" class="text-2xl font-normal text-center"></p>
            </div>
        </div>
        <div class="flex">
            <div id="section1" class="my-60 max-w-6xl px-4 md:px-6 lg:px-8 mx-auto"></div>
        </div>
        <div class="bg-primary-light mb-60">
            <div class="max-w-5xl px-4 md:px-6 lg:px-8 mx-auto grid grid-cols-12">
                <div
                    class="col-span-12 md:col-span-6 lg:col-span-4 flex flex-col items-center justify-center -translate-y-12">
                    <div class="bg-gray-400 rounded-full h-52 w-52"></div>
                    <h3 class="mt-4 font-semibold text-2xl">History</h3>
                    <div class="flex items-center justify-center -translate-y-4">
                        <div class="h-[3px] w-24 bg-black translate-x-3"></div><svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </div>
                </div>
                <div
                    class="col-span-12 md:col-span-6 lg:col-span-4 flex flex-col items-center justify-center -translate-y-12">
                    <div class="bg-gray-400 rounded-full h-52 w-52"></div>
                    <h3 class="mt-4 font-semibold text-2xl">Culture</h3>
                    <div class="flex items-center justify-center -translate-y-4">
                        <div class="h-[3px] w-24 bg-black translate-x-3"></div><svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </div>
                </div>
                <div
                    class="col-span-12 md:col-span-6 lg:col-span-4 flex flex-col items-center justify-center -translate-y-12">
                    <div class="bg-gray-400 rounded-full h-52 w-52"></div>
                    <h3 class="mt-4 font-semibold text-2xl">Food</h3>
                    <div class="flex items-center justify-center -translate-y-4">
                        <div class="h-[3px] w-24 bg-black translate-x-3"></div><svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex">
            <div id="section2" class="mb-60 max-w-6xl px-4 md:px-6 lg:px-8 mx-auto"></div>
        </div>
        <div class="relative flex">
            <div class="mb-60 max-w-6xl px-4 md:px-6 lg:px-8 mx-auto flex flex-col justify-start w-full">
                <h2 class="text-2xl font-semibold mb-10">Instagram feed</h2>
                <div id="instagramFeed" class="grid grid-cols-12 gap-4"></div>
            </div>
        </div>
        <div class="bg-primary-light py-14">
            <div class="max-w-6xl px-4 md:px-6 lg:px-8 mx-auto">
                <div class="grid grid-cols-12 gap-x-24">
                    <div
                        class="group col-span-12 md:col-span-6 lg:col-span-4 flex flex-col items-center justify-center px-4">
                        <img src="/assets/weather.jpg" alt="Weather"
                            class="h-32 w-36 rounded-lg shadow-lg object-cover" />
                        <h5 class="mt-4 font-medium text-primary duration-300 group-hover:translate-x-2">Check the
                            weather in Haarlem</h5>
                        <div
                            class="flex items-center justify-center -translate-y-3 w-full duration-300 group-hover:translate-x-2">
                            <div class="h-[3px] w-full bg-primary translate-x-3"></div><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="text-primary w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="group col-span-12 md:col-span-6 lg:col-span-4 flex flex-col items-center justify-center px-4">
                        <img src="/assets/google-maps.png" alt="Weather"
                            class="h-32 w-36 rounded-lg shadow-lg object-cover" />
                        <h5 class="mt-4 font-medium text-primary duration-300 group-hover:translate-x-2">View Haarlem on
                            Google Maps</h5>
                        <div
                            class="flex items-center justify-center -translate-y-3 w-full duration-300 group-hover:translate-x-2">
                            <div class="h-[3px] w-full bg-primary translate-x-3"></div><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="text-primary w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="group col-span-12 md:col-span-6 lg:col-span-4 flex flex-col items-center justify-center px-4">
                        <img src="/assets/9292.png" alt="Weather" class="h-32 w-36 rounded-lg shadow-lg object-cover" />
                        <h5 class="mt-4 font-medium text-primary duration-300 group-hover:translate-x-2">Plan your train
                            journey to Haarlem</h5>
                        <div
                            class="flex items-center justify-center -translate-y-3 w-full duration-300 group-hover:translate-x-2">
                            <div class="h-[3px] w-full bg-primary translate-x-3"></div><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="text-primary w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>