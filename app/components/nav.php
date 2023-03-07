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
    }

    async function logout() {
        await fetch(`${window.location.origin}/api/user/logout`, {
            method: "POST",
        }).then((res) => {
            window.location.href = "/";
        }).catch((res) => {});
    }
</script>

<nav class="fixed top-0 w-screen z-50" style="background-size:100%; position:relative; backdrop-filter: blur(20px);">
    <svg width="1920" height="173" viewBox="0 0 1920 173" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 121H1252L1563 148L0 155V121Z" fill="#CBE5E5" />
        <path d="M0 40H1920V172.412L0 40Z" fill="#46AEAE" />
        <path d="M0 0H1920V109.5L0 155V0Z" fill="#008080" />
    </svg>

    <div class="flex flex-row justify-between px-4 py-6 fixed top-0 w-screen z-50" style="position: absolute;">
        <a href="/">
            <img src="../assets/festival_logo.png" class="text-teal-800 font-black uppercase text-4xl leading-tight tracking-tight px-8" />
        </a>
        <div class="space-x-12 hidden md:flex flex-row text-xs sm:text-base">
            <?php if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])) : ?><a href="/login" class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-teal-800 group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                        Login
                    </span>
                </a><a href="/sign-up" class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-white group-hover:text-teal-800 uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                        Signup
                    </span>
                </a><?php else : ?>
                <a href="/new-post" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-2xl group-hover:text-white uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5 transition-all ease-in duration-75 rounded-md group-hover:bg-teal-800">
                        HISTORY
                    </span>
                </a>
                <a href="/my-posts" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-2xl group-hover:text-white uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5 transition-all ease-in duration-75 rounded-md group-hover:bg-teal-800">
                        CULTURE
                    </span>
                </a>
                <a href="/my-posts" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-2xl group-hover:text-white uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5 transition-all ease-in duration-75 rounded-md group-hover:bg-teal-800">
                        FOOD
                    </span>
                </a>
                <a href="/my-posts" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-2xl group-hover:text-white uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5 transition-all ease-in duration-75 rounded-md group-hover:bg-teal-800">
                        FESTIVAL
                    </span>
                </a>
                <a href="/my-posts" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <img src="../assets/britainLogo.svg" class="text-teal-800 font-black uppercase text-4xl leading-tight tracking-tight px-8" />
                </a>
                <button type="button" name="logoutBtn" onclick="logout()" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-white group-hover:text-teal-800 uppercase font-bold relative px-3 py-1.5 sm:px-5 sm:py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                        Logout
                    </span>
                </button>
            <?php endif; ?>
        </div>
        <button id="burger" class=" md:hidden"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="cursor-pointer h-10 w-10 top-1/4 text-teal-800">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg></button>
    </div>
</nav>
<nav id="mobileNav" class="backdrop-blur-2xl bg-teal-600 translate-x-full fixed top-0 right-0 flex flex-col h-full nav-shadow overflow-y-hidden nav-mobile opacity-100 transition-all duration-200 w-screen z-[100]">
    <div class="px-4 py-6 h-full flex flex-col items-center">
        <div class="w-full flex">   
            <a href="/">
            <img src="../assets/festival_logo.png" class="text-teal-800 font-black uppercase text-4xl leading-tight tracking-tight px-8 " />
            </a>
            <button id="close" class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="cursor-pointer h-10 w-10 ml-auto text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg></button>
        </div>
        <div class="flex flex-col text-xs sm:text-base my-auto">
            <?php if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])) : ?><a href="/login" class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="w-full text-center text-teal-800 group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-teal-800">
                        Login
                    </span>
                </a><a href="/sign-up" class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-8 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-white group-hover:text-teal-800 uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-blue-400">
                        Signup
                    </span>
                </a><?php else : ?>
                <a href="/new-post" class="relative inline-flex items-center justify-center p-0.5 mb-8 mr-2 mt-44 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-3xl text-white group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 rounded-md group-hover:bg-blue-400">
                        HISTORY
                    </span>
                </a>
                <a href="/my-posts" class="relative inline-flex items-center justify-center p-0.5 mb-8 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-3xl text-white group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 rounded-md group-hover:bg-blue-400">
                        CULTURE
                    </span>
                </a>
                <a href="/my-posts" class="relative inline-flex items-center justify-center p-0.5 mb-8 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-3xl text-white group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 rounded-md group-hover:bg-blue-400">
                        FOOD
                    </span>
                </a>
                <a href="/my-posts" class="relative inline-flex items-center justify-center p-0.5 mb-64 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="text-3xl text-white group-hover:text-white uppercase font-bold relative px-5 py-2.5 transition-all ease-in duration-75 rounded-md group-hover:bg-blue-400">
                        FESTIVAL
                    </span>
                </a>
                <button type="button" name="logoutBtn" onclick="logout()" class="bg-teal-800 relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden font-medium text-gray-900 rounded-lg group dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                    <span class="w-full text-white group-hover:text-teal-800 uppercase font-bold relative x-5 py-2.5 transition-all ease-in duration-75 bg-teal-800 rounded-md group-hover:bg-white">
                        Logout
                    </span>
                </button>
            <?php endif; ?>
        </div>
        <div class="text-teal-800 font-chivo text-[13px] mt-8">
            ©Social 2023
        </div>
    </div>
</nav>