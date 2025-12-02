<nav class="navbar-top topbarfull z-20 gap-3 bg-n0 py-3 shadow-sm duration-300 border-b border-n0 dark:border-n700 dark:bg-bg4 xl:py-4 xxxl:py-6"
    id="topbar">
    <div class="topbar-inner flex items-center justify-between gap-2">
        <div class="flex grow items-center gap-2 xxl:gap-4">
            <a href="{{ route('index1') }}" class="topbar-logo hidden shrink-0">
                <img width="174" height="38" src="{{ asset('assets/images/SBC_Logo.png') }}" alt="logo"
                    class="logo-full2 hidden lg:block" />
            </a>
            <button class="flex items-center rounded-s-2xl bg-primary px-0.5 py-3 text-xl text-n0"
                id="sidebar-toggle-btn">
                <i class="las la-angle-left text-lg"></i>
            </button>
            <!-- Select layout -->
             <!-- Dropdown Trigger -->
        <div class="whitespace-norwrap  relative inline-block grow items-center gap-2 xxl:gap-4 ">
            <!-- Main button -->
            <button id="dropdownBtn" class="btn-outline uppercase py-2 px-1 transition">
                Menu
                <i id="dropdownArrow" class="las la-angle-down ml-2 transition-transform duration-200"></i>
            </button>
 
            <!-- Main dropdown -->
            <div id="dropdownMenu"
                class="hidden absolute left-5 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                <ul>
                    <li class="px-4 py-2  hover:bg-gray-100 uppercase cursor-pointer submenu-trigger" data-submenu="accountsMenu">
                        Accounts →
                    </li>
 
                    <!-- Submenu triggers -->
                    <li class="relative px-4 py-2 uppercase hover:bg-gray-100 cursor-pointer ">
                       <a href="#"> New Journal Entry</a>
                    </li>
 
                    <li class="relative px-4 py-2 uppercase hover:bg-gray-100 cursor-pointer ">
                        <a href="#">Day Book</a>
                    </li>
 
                    <li class="px-4 py-2 hover:bg-gray-100 uppercase cursor-pointer">
                       <a href="#">Schedule SMS</a>
                    </li>
 
                    <li class="px-4 py-2 hover:bg-gray-100 uppercase cursor-pointer submenu-trigger " data-submenu="reportsMenu">
                        Reports →
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 uppercase cursor-pointer submenu-trigger "
                     data-submenu="dailycollectionMenu">
                        DAILY COLLECTION →
                    </li>
                </ul>
            </div>
 
            <!-- Submenus -->
            <div id="accountsMenu"
                class="hidden absolute left-0  bg-white border  border-gray-200 rounded-lg shadow-lg z-50 w-64"
                style="margin-left: 5px; margin-top: 55px !important;">
                <ul>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
 
                        <i class="las la-tree"></i>
                        <a href="">Tree</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-user-friends"></i>
                        <a href="{{ route('vendors.index') }}">vendors</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-object-group"></i>
                        <a href="{{ route('ledger-group.index') }}">Ledger Groups</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-plus-circle"></i>
                        <a href="{{ route('ledger.index') }}">Ledgers</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-list-ul"></i>
                        <a href="">Entries</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-balance-scale"></i>
                       <a href="">Trial Balance</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-rupee-sign"></i>
                          <a href="">Profit and Loss (P&L)</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-random"></i>
                       <a href="">Income Statement</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-chart-bar"></i>
                        <a href=""> Balance Sheet</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-list"></i>
                          <a href="">FY REPORT</a>
                    </li>
 
                </ul>
            </div>
 
            <div id="reportsMenu"
                class="hidden absolute left-0  bg-white border  border-gray-200 rounded-lg shadow-lg z-50 w-64"
                style="margin-left: 5px; margin-top: 55px !important;">
                <ul>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-user-secret"></i>
                          <a href="">Associate Report</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-building"></i>
                       <a href="">Branch Report</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-balance-scale"></i>
                       <a href="">Maturity Report</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-money-bill"></i>
                       <a href=""> Loan Report</a>
                    </li>
                </ul>
            </div>
             <div id="dailycollectionMenu"
                class="hidden absolute left-0  bg-white border  border-gray-200 rounded-lg shadow-lg z-50 w-64"
                style="margin-left: 5px; margin-top: 55px !important;">
                <ul>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-user-secret"></i>
                        <a href=""> Dashboard</a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-building"></i>
                         <a href="">Associate collection Approvals</a>  
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-balance-scale"></i>
                         <a href="">Associate collection Report</a>  
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-balance-scale"></i>
                       <a href="">Collection  Report</a>  
                    </li>
                     <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                       <i class="las la-id-badge" ></i>
                        <a href="">Active Associates</a>  
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                        <i class="las la-money-bill"></i>
                       <a href="">Associates Collection Limit</a>
                    </li>
                </ul>
            </div>
           
        </div>
        <!-- Dropdown end -->
 
            <!-- Search bar -->
            <form class="topnav-search">
                <input type="text" placeholder="Search"
                    class="w-full border-none bg-transparent py-2 focus:border-none focus:shadow-none focus:outline-none md:py-2.5 xxl:py-3 ltr:pl-4 rtl:pr-4" />
                <button class="flex h-8 w-9 items-center justify-center rounded-full bg-primary text-n0">
                    <i class="las la-search text-lg"></i>
                </button>
            </form>
        </div>

        <div class="  flex items-center gap-3 sm:gap-1 xxl:gap-2">

            <!-- mobile Search  -->
            <div class="relative lg:hidden">
                <button id="mobile-search-btn"
                    class="flex h-10 w-10 cursor-pointer select-none items-center justify-center gap-2 rounded-full border border-n30 bg-primary/5 dark:border-n500 dark:bg-bg3 md:h-12 md:w-12">
                    <i class="las la-search"></i>
                </button>
                <div id="mobile-search"
                    class="hide invisible absolute -left-8 top-full z-20 flex min-w-max max-w-[250px] origin-[20%_20%] gap-3 overflow-y-auto rounded-md bg-n0 p-3 opacity-0 shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)] duration-300 dark:bg-bg4">
                    <form
                        class="flex w-full items-center justify-between gap-3 rounded-[30px] border border-n30 bg-secondary/5 p-1 focus-within:border-primary dark:border-n500 dark:bg-bg3 xxl:p-2">
                        <input type="text" placeholder="Search" class="w-full bg-transparent py-1 ltr:pl-4 rtl:pr-4" />
                        <button
                            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-primary text-n0 lg:h-8 lg:w-8">
                            <i class="las la-search text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
            <!-- dark mode toggle -->
            <button id="darkModeToggle" aria-label="dark mode switch"
                class="h-10 w-10 shrink-0 rounded-full border border-n30 bg-primary/5 dark:border-n500 dark:bg-bg3 md:h-12 md:w-12">
                <i class="las la-sun text-2xl dark:hidden"></i>
                <span class="hidden text-n30 dark:block">
                    <i class="las la-moon text-2xl"></i>
                </span>
            </button>
            <!-- Notification -->
            <div class="relative">
                <button id="notification-btn"
                    class="relative h-10 w-10 rounded-full border border-n30 bg-primary/5 dark:border-n500 dark:bg-bg3 md:h-12 md:w-12">
                    <i class="las la-bell text-2xl"></i>
                    <span
                        class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary text-xs text-n0">
                        0
                    </span>
                </button>
                <div id="notification"
                    class="hide absolute top-full z-20 origin-[60%_0] rounded-md bg-n0 shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)] duration-300 dark:bg-bg4 ltr:-right-[110px] sm:ltr:right-0 sm:ltr:origin-top-right rtl:-left-[120px] sm:rtl:left-0 sm:rtl:origin-top-left">
                    <div class="flex items-center justify-between border-b p-3 dark:border-n500 lg:px-4">
                        <h5 class="h5">Notifications</h5>
                        <a href="#" class="text-sm text-primary"> View All </a>
                    </div>
                    <ul class="flex w-[300px] flex-col p-4">
                        <div class="flex cursor-pointer gap-2 rounded-md p-2 duration-300 hover:bg-primary/10">
                            <img src="{{ asset('assets/images/user-3.png') }}" width="44" height="40"
                                class="shrink-0 rounded-full" alt="img" />
                            <div class="text-sm">
                                <div class="flex gap-1">
                                    <span class="font-medium">Admin</span>
                                    <span>Sent a message</span>
                                </div>
                                <span class="text-xs text-n100 dark:text-n50">1 hour ago</span>
                            </div>
                        </div>


                        <div class="flex cursor-pointer gap-2 rounded-md p-2 duration-300 hover:bg-primary/10">
                            <img src="{{ asset('assets/images/user-7.png') }}" width="44" height="40"
                                class="shrink-0 rounded-full" alt="img" />
                            <div class="text-sm">
                                <div class="flex gap-1">
                                    <span class="font-medium">Samuel</span>
                                    <span>Uploaded a file</span>
                                </div>
                                <span class="text-xs text-n100 dark:text-n50">Yesterday</span>
                            </div>
                        </div>
                        <div class="flex cursor-pointer gap-2 rounded-md p-2 duration-300 hover:bg-primary/10">
                            <img src="{{ asset('assets/images/user-7.png') }}" width="44" height="40"
                                class="shrink-0 rounded-full" alt="img" />
                            <div class="text-sm">
                                <div class="flex gap-1">
                                    <span class="font-medium">David</span>
                                    <span>Left a Comment</span>
                                </div>
                                <span class="text-xs text-n100 dark:text-n50">Yesterday</span>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
            <!-- language dropdown -->
            <div class="relative">
                <button id="language-btn"
                    class="flex gap-1 rounded-full border border-n30 bg-primary/5 p-2 dark:border-n500 dark:bg-bg3 md:p-3">
                    <i class="las la-language"></i>
                </button>
                <div id="language"
                    class="hide absolute top-full z-20 rounded-md bg-n0 shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)] duration-300 dark:bg-bg4 ltr:right-0 ltr:origin-top-right rtl:left-0 rtl:origin-top-left">
                    <ul class="flex w-32 flex-col rounded-md bg-n0 p-1 dark:bg-bg4">
                        <li class="active block cursor-pointer rounded-md px-4 py-2 duration-300 hover:text-primary">
                            English
                        </li>
                        <li class="block cursor-pointer rounded-md px-4 py-2 duration-300 hover:text-primary">
                            Arabic
                        </li>
                        <li class="block cursor-pointer rounded-md px-4 py-2 duration-300 hover:text-primary">
                            Hindi
                        </li>
                        <li class="block cursor-pointer rounded-md px-4 py-2 duration-300 hover:text-primary">
                            Spanish
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Profile dropdown -->
            <div class="relative shrink-0">
                <div id="profile-btn" class="w-10 cursor-pointer md:w-12">
                    <img src="{{ asset('assets/images/user-big-4.png') }}" class="rounded-full" width="48" height="48"
                        alt="profile img" />
                </div>
                <div id="profile"
                    class="hide absolute top-full z-20 rounded-md bg-n0 shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)] duration-300 dark:bg-bg4 ltr:right-0 ltr:origin-top-right rtl:left-0 rtl:origin-top-left">
                    <div class="flex flex-col items-center border-b p-3 text-center dark:border-n500 lg:p-4">
                        <img src="{{ asset('assets/images/user-big-4.png') }}" width="60" height="60"
                            class="rounded-full" alt="profile img" />
                        <h6 class="h6 mt-2">
                            {{ auth()->user()->name}}
                        </h6>
                        <span class="text-sm">{{auth()->user()->email}}</span>
                    </div>
                    <ul class="flex w-[250px] flex-col p-4">
                        <li>
                            <a href="{{ route('settings.profile') }}"
                                class="flex items-center gap-2 rounded-md p-2 duration-300 hover:bg-primary hover:text-n0">
                                <span>
                                    <i class="las la-user mt-1 text-xl"></i>
                                </span>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('support.help.center') }}"
                                class="flex items-center gap-2 rounded-md p-2 duration-300 hover:bg-primary hover:text-n0">
                                <span>
                                    <i class="las la-life-ring mt-1 text-xl"></i>
                                </span>
                                Help
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.security') }}"
                                class="flex items-center gap-2 rounded-md p-2 duration-300 hover:bg-primary hover:text-n0">
                                <span>
                                    <i class="las la-cog mt-1 text-xl"></i>
                                </span>
                                Settings
                            </a>
                        </li>
                        <li>

                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="flex items-center gap-2 rounded-md p-2 duration-300 hover:bg-primary hover:text-n0">
                                <span>
                                    <i class="las la-sign-out-alt mt-1 text-xl"></i>
                                </span>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('log.out') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    const dropdownBtn = document.getElementById("dropdownBtn");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const dropdownArrow = document.getElementById("dropdownArrow");
    const submenuTriggers = document.querySelectorAll(".submenu-trigger");
    const submenus = document.querySelectorAll("[id$='Menu']:not(#dropdownMenu)");

    // ✅ Toggle main dropdown
    dropdownBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        dropdownMenu.classList.toggle("hidden");
        dropdownArrow.classList.toggle("rotate-180");

        // When closing the main menu → hide all submenus
        if (dropdownMenu.classList.contains("hidden")) {
            hideAllSubmenus();
        }
    });

    // ✅ Handle submenu click (only one open at a time)
    submenuTriggers.forEach(trigger => {
        trigger.addEventListener("click", (e) => {
            e.stopPropagation();
            const submenuId = trigger.dataset.submenu;
            const submenu = document.getElementById(submenuId);

            // If the clicked submenu is already open → close it
            const isAlreadyOpen = !submenu.classList.contains("hidden");

            // Hide all submenus first
            hideAllSubmenus();

            // If it wasn't open before → open it now
            if (!isAlreadyOpen) {
                const rect = trigger.getBoundingClientRect();
                const parentRect = dropdownMenu.getBoundingClientRect();
                submenu.style.top = `${rect.top - parentRect.top}px`;
                submenu.style.left = `${parentRect.width - 5}px`;
                submenu.classList.remove("hidden");
            }
        });
    });

    // ✅ Close dropdown & submenus when clicking outside
    document.addEventListener("click", (e) => {
        if (!dropdownMenu.contains(e.target) && e.target !== dropdownBtn) {
            dropdownMenu.classList.add("hidden");
            dropdownArrow.classList.remove("rotate-180");
            hideAllSubmenus();
        }
    });

    // ✅ Utility: Hide all submenus
    function hideAllSubmenus() {
        submenus.forEach(menu => menu.classList.add("hidden"));
    }
</script>


