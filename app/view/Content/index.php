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

<script>
window.addEventListener("load", (event) => {
    getInformationPage();
});

function getInformationPage() {
    const url = window.location.pathname.replace("/content/", "");

    fetch(`${window.location.origin}/api/information-page/page?url=${url}`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();
            console.log(data);

            if (data?.image) document.getElementById('header').style.backgroundImage =
                `url('${getImage(data?.image)}')`;
            document.getElementById('headerTitle').innerHTML = data?.title;
            document.getElementById('headerSubtitle').innerHTML = data?.subtitle;
            document.getElementsByTagName('Title')[0].innerHTML = `${data?.meta_title} - TheFestival`;
            document.getElementsByTagName('meta')["description"].content = data?.meta_description;

            var sectionsHTML = "";

            data?.sections?.forEach((section, index) => {
                if (section?.text)
                    sectionsHTML +=
                    `<div id="section-${index + 1}" class="my-60 max-w-6xl px-4 md:px-6 lg:px-8 mx-auto">${section?.text || ""}</div>`
            });

            document.getElementById("sections").innerHTML = sectionsHTML;
        }
    }).catch((res) => {
        console.log(res)
    });
}
</script>

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
        <div class="flex flex-col" id="sections">
        </div>
        <?php include __DIR__ . '/../../components/footer.php' ?>
    </div>
</body>

</html>