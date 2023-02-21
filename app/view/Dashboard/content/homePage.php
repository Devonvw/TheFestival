<?php 
/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    eader("location: /");
    exit;
}*/
?>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<header>
    <link rel="stylesheet" href="../../styles/globals.css">
    <title>Home page - The Festival</title>
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
tinymce.init({
    selector: '#mytextarea'
});
</script>

<body>
    <div class="">
        <div class="w-screen relative">
            <?php include __DIR__ . '/../../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">
                <div class="shadow-xl border-black w-full p-4 px-8">
                    <h2 class="text-2xl font-semibold">Home page</h2>
                </div>
                <div class="px-4 md:px-6 lg:px-8 mt-10">
                    <form id="editForm" class="space-y-4 md:space-y-6">
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">
                                Title</label>
                            <input maxlength="255" type="text" name="title" id="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Title..." required="">
                        </div>
                        <div>
                            <label for="subtitle" class="block mb-2 text-sm font-medium text-gray-900">
                                Subtitle</label>
                            <input maxlength="255" type="text" name="subtitle" id="subtitle"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Subtitle..." required="">
                        </div>
                        <div>
                            <label for="section1" class="block mb-2 text-sm font-medium text-gray-900">
                                Section 1</label>
                            <textarea id="mytextarea">Hello, World!</textarea>
                        </div>
                        <div><button type="submit" class="w-full text-white bg-primary p-2 rounded-lg">
                                Save
                            </button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>