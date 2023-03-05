<?php 
/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    eader("location: /");
    exit;
}*/
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<header>
    <link rel="stylesheet" href="../../../styles/globals.css">
    <title>Information pages - The Festival</title>
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
<script>
window.addEventListener("load", (event) => {
    getInformationPages();
});

function getInformationPages() {
    fetch(`${window.location.origin}/api/information-page`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();
            console.log(data)
            var pagesHTML = "";

            data?.forEach((page) => pagesHTML +=
                `<div class="border border-primary flex items-center justify-between rounded-md p-2">
                <h3 class="text-lg font-normal">${page?.title ? page?.title :
                `Page ${page?.id}`}</h3>
                <div class="flex items-center gap-x-2"><a href="/dashboard/content/information-pages/page?id=${page?.id}"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-500 w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
</svg>
</a><button><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-500 w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
</svg>
</button></div>
                </div>`
            )

            document.getElementById("pages").innerHTML = pagesHTML;
        }
    }).catch((res) => {
        console.log(res)
    });
}

function addInformationPage() {
    fetch(`${window.location.origin}/api/information-page`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "POST",
        body: JSON.stringify({})
    }).then(async (res) => {
        getInformationPages();
    }).catch((res) => {});
}
</script>

<body>
    <div class="">
        <div class="w-screen relative">
            <?php include __DIR__ . '/../../../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">
                <div class="shadow-xl border-black w-full p-4 px-8">
                    <h2 class="text-2xl font-semibold">Information pages</h2>
                </div>
                <div class="px-4 md:px-6 lg:px-8 mt-10">
                    <div class="w-full flex items-center justify-end"><button
                            class="border-2 border-primary text-white bg-primary rounded-md p-2 hover:text-black hover:bg-transparent">Add
                            page</button>
                    </div>
                    <div id="pages" class="flex flex-col gap-y-4 mt-4"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>