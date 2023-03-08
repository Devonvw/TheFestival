<?php 
/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    eader("location: /");
    exit;
}*/
?>
<!DOCTYPE HTML>
<html>
<script src="https://cdn.tailwindcss.com"></script>
<script src="/packages/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

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
<script src="/utils/getImage.js"></script>
<script src="/utils/handleImageUpload.js"></script>
<script>
tinymce.init({
    selector: 'textarea.tiny',
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image',
    plugins: 'image',
    image_class_list: [{
            title: 'Left',
            value: ''
        },
        {
            title: 'Right',
            value: 'md:float-right'
        }
    ],
    images_upload_handler: handleImageUpload
});
</script>
<script>
window.addEventListener("load", (event) => {
    getHomePage();
    var frm = document.getElementById("editForm");

    frm.addEventListener("submit", editHomePage);
});

function editHomePage(e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append("meta_title", document.getElementById('metaTitle').value);
    formData.append("meta_description", document.getElementById('metaDesc').value);
    formData.append("title", document.getElementById('title').value);
    formData.append("subtitle", document.getElementById('subtitle').value);
    formData.append("image", document.getElementById('imageInput').files ? document.getElementById('imageInput')
        .files[0] : null);
    formData.append("sections", JSON.stringify([{
        id: document.getElementById('section1').getAttribute("name"),
        text: tinymce.get("section1").getContent()
    }, {
        id: document.getElementById('section2').getAttribute("name"),
        text: tinymce.get("section2").getContent()
    }]));

    fetch(`${window.location.origin}/api/information-page/edit-home-page`, {
        method: "POST",
        body: formData
    }).then(async (res) => {
        if (!res.ok) {
            document.getElementById('error').innerHTML = (await res.json())?.msg;
            document.getElementById('errorWrapper').classList.remove('hidden');
        }
    }).catch((res) => {});
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

            document.getElementById('metaTitle').value = data?.meta_title;
            document.getElementById('metaDesc').value = data?.meta_description;
            document.getElementById('title').value = data?.title;
            document.getElementById('subtitle').value = data?.subtitle;
            if (data?.image) document.getElementById('image').src = getImage(data?.image);
            tinymce.get("section1").setContent(data?.sections[0]?.text ? data?.sections[0]?.text : "");
            tinymce.get("section2").setContent(data?.sections[1]?.text ? data?.sections[1]?.text : "");
            document.getElementById('section1').setAttribute("name", data?.sections[0] ? data?.sections[0]
                ?.id : "");
            document.getElementById('section2').setAttribute("name", data?.sections[1] ? data?.sections[1]
                ?.id : "");
        }
    }).catch((res) => {
        console.log(res)
    });
}

const handleImage = (e) => {
    console.log(e?.files[0])
    document.getElementById('image').src = getImage(e?.files[0]);
}
</script>

<body>
    <div class="">
        <div class="w-screen relative">
            <?php include __DIR__ . '/../../../components/dashboard/sidebar.php' ?>
            <div class="dashboard-right min-h-screen ml-auto">
                <div class="shadow-xl border-black w-full p-4 px-8">
                    <h2 class="text-2xl font-semibold">Home page</h2>
                </div>
                <div class="px-4 md:px-6 lg:px-8 mt-10 pb-10">
                    <form onsubmit="editHomePage" id="editForm" class="space-y-4 md:space-y-6">
                        <div class="w-full flex items-center justify-end"><button type="submit"
                                class="border-2 border-primary text-white bg-primary rounded-md p-2 hover:text-black hover:bg-transparent">Save</button>
                        </div>
                        <div>
                            <label for="metaTitle" class="block mb-2 text-sm font-medium text-gray-900">
                                Meta title</label>
                            <input maxlength="255" type="text" name="metaTitle" id="metaTitle"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Meta title..." required="">
                        </div>
                        <div>
                            <label for="metaDesc" class="block mb-2 text-sm font-medium text-gray-900">
                                Meta description</label>
                            <input maxlength="255" type="text" name="metaDesc" id="metaDesc"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Meta description..." required="">
                        </div>
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
                            <label for="image" class="block mb-2 text-sm font-medium text-gray-900">
                                Image</label>
                            <div class="h-60 bg-gray-200 relative">
                                <div class="flex items-center justify-center w-full">
                                    <label
                                        class="relative flex flex-col justify-center w-full h-60 border-4 border-dashed hover:bg-gray-100 border-gray-300 cursor-pointer">
                                        <div class="absolute top-0 left-0 z-0 h-full w-full"><img id='image'
                                                class="object-cover h-full w-full" />
                                        </div>
                                        <div class="visible flex flex-col items-center justify-center pt-7">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-12 h-12 text-gray-400 group-hover:text-gray-600"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fillRule="evenodd"
                                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                    clipRule="evenodd" />
                                            </svg>
                                            <p
                                                class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                                                Choose an image
                                            </p>
                                        </div>
                                        <input id="imageInput" onchange="handleImage(this)" type="file" multiple='false'
                                            accept="image/*" class="opacity-0" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="section1" class="block mb-2 text-sm font-medium text-gray-900">
                                Section 1</label>
                            <textarea id="section1" name="1" class="tiny"></textarea>
                        </div>
                        <h3 class="text-xl font-medium pt-5">Links section</h3>
                        <div class="grid grid-cols-12 gap-12 pb-5">
                            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                                <div class="rounded-md overflow-hidden border border-gray-200">
                                    <div class="h-32 bg-gray-200 relative">
                                        <div class="flex items-center justify-center w-full">
                                            <label
                                                class="relative flex flex-col w-full h-32 border-4 border-dashed hover:bg-gray-100 border-gray-300 cursor-pointer">
                                                <img src="/assets/festival_logo.png"
                                                    class="hidden absolute top-0 left-0 z-0 object-contain" />
                                                <div class="visible flex flex-col items-center justify-center pt-7">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-12 h-12 text-gray-400 group-hover:text-gray-600"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fillRule="evenodd"
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                            clipRule="evenodd" />
                                                    </svg>
                                                    <p
                                                        class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                                                        Choose an image
                                                    </p>
                                                </div>
                                                <input type="file" multiple='false' accept="image/*"
                                                    class="opacity-0" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="p-3"><label for="linkOneName"
                                            class="block mb-2 text-sm font-medium text-gray-900">
                                            Name</label>
                                        <input maxlength="255" type="text" name="linkOneName" id="linkOneName"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Subtitle...">
                                        <label for="linkOne" class="block mb-2 text-sm font-medium text-gray-900 mt-2">
                                            Link</label>
                                        <input maxlength="255" type="text" name="linkOne" id="linkOne"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Subtitle...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                                <div class="rounded-md overflow-hidden border border-gray-200">
                                    <div class="h-32 bg-gray-200 relative">
                                        <div class="flex items-center justify-center w-full">
                                            <label
                                                class="relative flex flex-col w-full h-32 border-4 border-dashed hover:bg-gray-100 border-gray-300 cursor-pointer">
                                                <img src="/assets/festival_logo.png"
                                                    class="hidden absolute top-0 left-0 z-0 object-contain" />
                                                <div class="visible flex flex-col items-center justify-center pt-7">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-12 h-12 text-gray-400 group-hover:text-gray-600"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fillRule="evenodd"
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                            clipRule="evenodd" />
                                                    </svg>
                                                    <p
                                                        class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                                                        Choose an image
                                                    </p>
                                                </div>
                                                <input type="file" multiple='false' accept="image/*"
                                                    class="opacity-0" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="p-3"><label for="linkOneName"
                                            class="block mb-2 text-sm font-medium text-gray-900">
                                            Name</label>
                                        <input maxlength="255" type="text" name="linkOneName" id="linkOneName"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Subtitle...">
                                        <label for="linkOne" class="block mb-2 text-sm font-medium text-gray-900 mt-2">
                                            Link</label>
                                        <input maxlength="255" type="text" name="linkOne" id="linkOne"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Subtitle...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                                <div class="rounded-md overflow-hidden border border-gray-200">
                                    <div class="h-32 bg-gray-200 relative">
                                        <div class="flex items-center justify-center w-full">
                                            <label
                                                class="relative flex flex-col w-full h-32 border-4 border-dashed hover:bg-gray-100 border-gray-300 cursor-pointer">
                                                <img src="/assets/festival_logo.png"
                                                    class="hidden absolute top-0 left-0 z-0 object-contain" />
                                                <div class="visible flex flex-col items-center justify-center pt-7">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-12 h-12 text-gray-400 group-hover:text-gray-600"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fillRule="evenodd"
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                            clipRule="evenodd" />
                                                    </svg>
                                                    <p
                                                        class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                                                        Choose an image
                                                    </p>
                                                </div>
                                                <input type="file" multiple='false' accept="image/*"
                                                    class="opacity-0" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="p-3"><label for="linkOneName"
                                            class="block mb-2 text-sm font-medium text-gray-900">
                                            Name</label>
                                        <input maxlength="255" type="text" name="linkOneName" id="linkOneName"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Subtitle...">
                                        <label for="linkOne" class="block mb-2 text-sm font-medium text-gray-900 mt-2">
                                            Link</label>
                                        <input maxlength="255" type="text" name="linkOne" id="linkOne"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Subtitle...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="section2" class="block mb-2 text-sm font-medium text-gray-900">
                                Section 2</label>
                            <textarea id="section2" name="2" class="tiny"></textarea>
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