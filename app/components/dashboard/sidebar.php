<link rel="stylesheet" href="/packages/toastify-js/toastify-js.css">
<script src="/packages/toastify-js/toastify-js.js"></script>
<script src="/packages/toast/toast.js"></script>
<script>
window.onload = () => {
    var acc = document.getElementsByClassName("accordion");
    var chevs = document.getElementsByClassName("chevron");

    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function(e) {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            panel.classList.toggle("hidden");
            if (this.classList.contains("active")) {
                this.getElementsByClassName("chevron")[0].classList.add("chevron-close");
                this.getElementsByClassName("chevron")[0].classList.remove("chevron-open");
            } else {
                this.getElementsByClassName("chevron")[0].classList.add("chevron-open");
                this.getElementsByClassName("chevron")[0].classList.remove("chevron-close");
            }
        });
    }
}
}

function logout() {
    fetch(`${window.location.origin}/api/account/logout`, {
        method: "POST",
    }).then((res) => {
        window.location.href = "/";
    }).catch((res) => {});
}
</script>

<nav class="py-8 px-4 bg-primary h-screen fixed w-[17rem] flex flex-col">
    <img src="/assets/festival_logo.png" class="w-3/4 mb-10 mx-auto" />
    <ul class="flex flex-col gap-y-1 text-white">
        <li><a href="/dashboard" class="flex gap-x-2 rounded hover:bg-teal-800 p-2"><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <h4>Dashboard</h4>
            </a>
        </li>
        <li><a href="/dashboard/accounts" class="flex gap-x-2 rounded hover:bg-teal-800 p-2"><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                <h4>Accounts</h4>
            </a>
        </li>
        <li><a href="/dashboard/orders" class="flex gap-x-2 rounded hover:bg-teal-800 p-2"><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>

                <h4>Orders</h4>
            </a>
        </li>
        <li class="accordion cursor-pointer flex justify-between items-center rounded hover:bg-teal-800 p-2">
            <div class="flex gap-x-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6zM7.5 6h.008v.008H7.5V6zm2.25 0h.008v.008H9.75V6z" />
                </svg>
                <h4>Content</h4>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 chevron chevron-open">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </li>
        <ul class="flex flex-col gap-y-2 text-white pl-10 my-2 hidden text-sm w-full">
            <li class="w-full"><a class="flex rounded hover:bg-teal-800 w-full p-1"
                    href="/dashboard/content/home-page">Home
                    page</a></li>
            <li class="w-full"><a class="flex rounded hover:bg-teal-800 w-full p-1"
                    href="/dashboard/content/information-pages">Information pages</a></li>
        </ul>
        <li class="accordion cursor-pointer flex justify-between items-center rounded hover:bg-teal-800 p-2">
            <div class="flex gap-x-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
                </svg>
                <h4>Yummie!</h4>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5 chevron chevron-open">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </li>
        <ul class="flex flex-col gap-y-3 text-white pl-12 my-2 hidden text-sm">


            <li>Restaurants</li>

            <li class="accordion cursor-pointer flex justify-between items-center rounded hover:bg-teal-800 p-2">
                <div class="flex gap-x-2"><svg fill="#FFF" viewBox="-5.5 0 32 32" class="w-6 h-6" version="1.1"
                        xmlns="http://www.w3.org/2000/svg">
                        <title>music</title>
                        <path
                            d="M5.688 9.656v10.906c-0.469-0.125-0.969-0.219-1.406-0.219-1 0-2.031 0.344-2.875 0.906s-1.406 1.469-1.406 2.531c0 1.125 0.563 1.969 1.406 2.531s1.875 0.875 2.875 0.875c0.938 0 2-0.313 2.844-0.875s1.375-1.406 1.375-2.531v-11.438l9.531-2.719v7.531c-0.438-0.125-0.969-0.188-1.438-0.188-0.969 0-2.031 0.281-2.875 0.844s-1.375 1.469-1.375 2.531c0 1.125 0.531 2 1.375 2.531 0.844 0.563 1.906 0.906 2.875 0.906 0.938 0 2.031-0.344 2.875-0.906 0.875-0.531 1.406-1.406 1.406-2.531v-14.406c0-0.688-0.469-1.156-1.156-1.156-0.063 0-0.438 0.125-1.031 0.281-1.25 0.344-3.125 0.875-5.25 1.5-1.094 0.281-2.063 0.594-3.031 0.844-0.938 0.281-1.75 0.563-2.469 0.75-0.75 0.219-1.219 0.344-1.406 0.406-0.5 0.156-0.844 0.594-0.844 1.094z">
                        </path>
                    </svg>
                    <h4>Dance!</h4>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 chevron chevron-open">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </li>
            <ul class="flex flex-col gap-y-3 text-white pl-12 my-2 hidden text-sm">
                <li class="w-full"><a class="flex rounded hover:bg-teal-800 w-full p-1" href="/dashboard/events">Events
                    </a></li>
                <li class="w-full"><a class="flex rounded hover:bg-teal-800 w-full p-1" href="/dashboard/events">Venues
                    </a></li>
                <li class="w-full"><a class="flex rounded hover:bg-teal-800 w-full p-1" href="/dashboard/events">Artists
                    </a></li>
            </ul>
            <li class="accordion cursor-pointer flex justify-between items-center rounded hover:bg-teal-800 p-2">
                <div class="flex gap-x-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                    </svg>

                    <h4>History!</h4>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 chevron chevron-open">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </li>
            <ul class="flex flex-col gap-y-3 text-white pl-8 my-2 hidden text-sm">
                <li>Event information</li>
            </ul>

        </ul>
        <button class="flex gap-x-2 rounded hover:bg-teal-800 p-2 mt-auto text-white" onclick="logout()"><svg
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
            <h4 class="text-white">Logout</h4>
        </button>
</nav>