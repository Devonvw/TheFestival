<script>
window.onload = () => {
    const burger = document.getElementById("burger");
    const close = document.getElementById("close");
    const mobileNav = document.getElementById("mobileNav");

    burger?.addEventListener("click", () => {
        console.log("burger");
        document.body.classList.add("overflow-hidden", "h-screen");
        mobileNav?.classList.remove("translate-x-full");
        mobileNav?.classList.add("translate-x-0");
    });

    close?.addEventListener("click", () => {
        document.body.classList.remove("overflow-hidden", "h-screen");
        mobileNav?.classList.remove("translate-x-0");
        mobileNav?.classList.add("translate-x-full");
    })

    getContentPages();
}

function getContentPages() {
    fetch(`${window.location.origin}/api/information-page/urls`, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: "GET",
    }).then(async (res) => {
        if (res.ok) {
            const data = await res.json();

            var contentPagesMobileHTML = "";
            var contentPagesHTML = "";

            data?.forEach((page) => {
                contentPagesHTML += `
                    <li><a href="/content/${page?.url}">${page?.title}</a></li>
            `;

                contentPagesMobileHTML += `
                <li>
                    <a href="/content/${page?.url}"
                        class="relative inline-flex items-center justify-center p-0.5 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                        <span
                            class="text-base text-white group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 rounded-md">
                            ${page?.title}
                        </span>
                    </a>
                </li>
            `
            });

            document.getElementById("contentPages").innerHTML = contentPagesHTML;
            document.getElementById("contentPagesMobile").innerHTML = contentPagesMobileHTML;
            document.getElementById("contentPagesFooter").innerHTML = contentPagesHTML;

        }
    }).catch((res) => {});
}

async function logout() {
    await fetch(`${window.location.origin}/api/account/logout`, {
        method: "POST",
    }).then((res) => {
        window.location.href = "/";
    }).catch((res) => {});
}
</script>

<nav class="fixed top-0 w-screen z-50" style="background-size:100%;">
    <svg class="-translate-y-10" width="1920" height="173" viewBox="0 0 1920 173" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M0 121H1252L1563 148L0 155V121Z" fill="#CBE5E5" />
        <path d="M0 40H1920V172.412L0 40Z" fill="#46AEAE" />
        <path d="M0 0H1920V109.5L0 155V0Z" fill="#008080" />
    </svg>

    <div class="flex flex-row justify-between px-4 py-6 fixed top-0 w-screen z-50" style="position: absolute;">
        <a href="/" class="h-3/5 w-3/5">
            <img src="../assets/festival_logo.png"
                class="text-teal-800 font-black uppercase text-4xl leading-tight tracking-tight pr-16 md:px-8 h-3/5 lg:h-4/5" />
        </a>
        <div class="hidden md:flex flex-row items-center text-xs sm:text-sm">
            <div
                class="overflow-visible dropdown relative inline-flex items-center justify-center p-0.5 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <p class="group-hover:text-white uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5
                    transition-all ease-in duration-75 rounded-md group-hover:bg-teal-800">
                    HAARLEM
                </p>
                <ul class="dropdown-content !mt-0 bg-white rounded-b-lg overflow-hidden w-max" id="contentPages">
                </ul>
            </div>
            <a href="/festival"
                class="relative inline-flex items-center justify-center p-0.5 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="group-hover:text-white uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5 transition-all ease-in duration-75 rounded-md group-hover:bg-teal-800">
                    FESTIVAL
                </span>
            </a>
            <a href="/"
                class="relative inline-flex items-center justify-center p-0.5 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <img src="../assets/britainLogo.svg"
                    class="text-teal-800 font-black uppercase text-4xl leading-tight tracking-tight px-8 h-6" />
            </a>
            <?php if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])) : ?><a href="/login"
                class="mr-4 relative inline-flex items-center justify-center p-0.5 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-teal-800 group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                    Login
                </span>
            </a><a href="/sign-up"
                class="relative inline-flex items-center justify-center p-0.5 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-teal-800 group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                    Signup
                </span>
            </a><?php else : ?>
            <a href="/cart"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-white my-auto mr-4 hover:scale-105">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </a>
            <a href="/manage-account">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-white my-auto mr-4 hover:scale-105">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>
            <button type="button" name="logoutBtn" onclick="logout()"
                class="relative inline-flex items-center justify-center p-0.5overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="text-white group-hover:text-teal-800 uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                    Logout
                </span>
            </button>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) : ?>
        <a href="/cart" class="md:hidden flex items-center justify-center mr-4"><svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6 text-white my-auto hover:scale-105">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
        </a>
        <a href="/manage-account" class="md:hidden flex items-center justify-center mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-white my-auto hover:scale-105">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </a>
        <?php endif; ?>
        <button id="burger" class=" md:hidden"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="cursor-pointer h-10 w-10 top-1/4 text-teal-800">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg></button>
    </div>
</nav>
<nav id="mobileNav"
    class="backdrop-blur-2xl bg-teal-600 translate-x-full fixed top-0 right-0 flex flex-col h-full nav-shadow overflow-y-hidden nav-mobile opacity-100 transition-all duration-200 w-screen z-[100]">
    <div class="px-4 py-6 h-full flex flex-col items-center">
        <div class="w-full flex">
            <a href="/">
                <img src="../assets/festival_logo.png"
                    class="text-teal-800 font-black uppercase text-4xl leading-tight tracking-tight px-8 " />
            </a>
            <button id="close" class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="cursor-pointer h-10 w-10 ml-auto text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg></button>
        </div>
        <div class="h-full py-8 flex flex-col text-xs sm:text-base">
            <p
                class="mb-1 relative inline-flex items-center justify-center p-0.5 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="border-b text-xl text-white group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75">
                    Haarlem
                </span>
            </p>
            <ul class="mb-6 flex flex-col gap-y-1 items-center" id="contentPagesMobile"></ul>
            <a href="/festival"
                class="mb-4 relative inline-flex items-center justify-center p-0.5 mr-2 overflow-hidden font-medium text-gray-100 rounded-lg group">
                <span
                    class="border-b text-xl text-white group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75">
                    FESTIVAL
                </span>
            </a>
            <?php if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])) : ?><a href="/login"
                class="mt-auto bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="w-full text-center text-black group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md">
                    Login
                </span>
            </a><a href="/sign-up"
                class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="w-full text-center text-black group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md">
                    Signup
                </span>
            </a><?php else : ?>
            <button type="button" name="logoutBtn" onclick="logout()"
                class="mt-auto bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span
                    class="w-full text-white group-hover:text-teal-800 uppercase font-bold relative x-5 py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                    Logout
                </span>
            </button>
            <?php endif; ?>
        </div>
        <div class="text-teal-800 font-chivo text-[13px] mt-8">
            ©TheFestival 2023
        </div>
    </div>
</nav>