
<style>
    #topbar::before {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        top: -100px;
        left: -100px;

        background: radial-gradient(circle, rgba(0,255,255,0.15), transparent);
        filter: blur(100px);
    }
    /* 🔥 NAVBAR GLASS EFFECT */
    #topbar {
        background: linear-gradient(90deg, #0f172a, #1e293b);
        backdrop-filter: blur(15px);
        border-bottom: 1px solid rgba(0,255,255,0.15);

        box-shadow: 
            0 3px 6px rgba(0,0,0,0.3),
            inset 0 0 20px rgba(0,255,255,0.05);
    }

    /* 🔥 MENU BUTTON */
    #dropdownBtn {
        background: rgba(0,255,255,0.08);
        color: #e54d3d;
        border-radius: 10px;
        padding: 6px 14px;
        transition: 0.3s;
    }

    #dropdownBtn:hover {
        background: rgba(0,255,255,0.2);
        box-shadow: 0 0 12px rgba(0,255,255,0.6);
    }

    /* 🔥 MAIN DROPDOWN */
    #dropdownMenu {
        background: rgba(15, 23, 42, 0.95) !important;
        backdrop-filter: blur(18px);
        border: 1px solid rgba(0,255,255,0.2);
        border-radius: 12px;

        animation: fadeSlide 0.25s ease;
    }

    /* 🔥 SUBMENUS */
    #accountsMenu,
    #reportsMenu,
    #dailycollectionMenu,
    #compliancesMenu {
        background: rgba(15, 23, 42, 0.97) !important;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(0,255,255,0.15);
        border-radius: 12px;

        animation: slideRight 0.25s ease;
    }

    /* 🔥 MENU ITEMS */
    #dropdownMenu li,
    #accountsMenu li,
    #reportsMenu li,
    #dailycollectionMenu li,
    #compliancesMenu li {
        color: #cbd5e1;
        transition: 0.25s;
    }

    /* 🔥 HOVER EFFECT */
    #dropdownMenu li:hover,
    #accountsMenu li:hover,
    #reportsMenu li:hover,
    #dailycollectionMenu li:hover,
    #compliancesMenu li:hover {
        background: rgba(0,255,255,0.12);
        color: white;

        transform: translateX(5px);
        box-shadow: 0 0 10px rgba(0,255,255,0.4);
    }

    /* 🔥 ICON GLOW */
    li i {
        transition: 0.2s;
    }
    li:hover i {
        text-shadow: 0 0 8px #3b82f6;
    }

    /* 🔥 ANIMATIONS */
    @keyframes fadeSlide {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideRight {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* 🔥 SCROLLBAR STYLING */
    #dropdownMenu::-webkit-scrollbar,
    #accountsMenu::-webkit-scrollbar {
        width: 5px;
    }

    #dropdownMenu::-webkit-scrollbar-thumb,
    #accountsMenu::-webkit-scrollbar-thumb {
        background: #3b82f6;
        border-radius: 10px;
    }

    /* 🔥 MOBILE RESPONSIVE */
    @media (max-width: 768px) {

        #dropdownMenu {
            width: 90vw !important;
            left: 5% !important;
        }

        #accountsMenu,
        #reportsMenu,
        #dailycollectionMenu,
        #compliancesMenu {
            position: relative !important;
            left: 0 !important;
            margin-top: 5px !important;
            width: 100% !important;
        }
    }
</style>

<style>
    .profile-avatar {
    border-radius: 50%;
    border: 2px solid rgba(0,255,255,0.4);
    box-shadow: 
        0 0 10px rgba(0,255,255,0.6),
        0 0 25px rgba(0,255,255,0.3),
        inset 0 0 5px rgba(0,255,255,0.5);
    transition: all 0.3s ease;
}

.profile-avatar:hover {
    transform: scale(1.08);
    box-shadow: 
        0 0 15px rgba(0,255,255,1),
        0 0 35px rgba(0,255,255,0.6);
}
.profile-dropdown {
    background: rgba(10, 15, 25, 0.85);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(0,255,255,0.2);

    box-shadow:
        0 10px 40px rgba(0,0,0,0.6),
        0 0 30px rgba(0,255,255,0.15);

    transition: all 0.3s ease;
}
.profile-dropdown .user-info {
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

/* USER NAME */
.profile-dropdown h6 {
    color: #ffffff;
    font-weight: 700; /* 🔥 bold */
    letter-spacing: 0.6px;
    text-shadow: 0 0 8px rgba(0,255,255,0.4); /* neon glow */
}

/* EMAIL */
.profile-dropdown span {
    color: #d1d5db; /* thoda soft white */
    font-weight: 500;
}

/* MENU ITEMS TEXT */
.menu-item {
    color: #ffffff;
    font-weight: 600; /* 🔥 bold */
    transition: all 0.25s ease;
}

/* HOVER EFFECT */
.menu-item:hover {
    color: #00f0ff;
    font-weight: 600;
    background: rgba(0,255,255,0.08);
    box-shadow: inset 0 0 15px rgba(0,255,255,0.15);
}

/* ICON COLOR */
.menu-item i {
    color: #ffffff;
}

/* LOGOUT */
.logout-item {
    color: #ff6b6b;
    font-weight: 600;
}
</style>

<nav class="navbar-top topbarfull z-20 gap-3 bg-n0 py-3 shadow-sm duration-300 border-b border-n0 dark:border-n700 dark:bg-bg4 xl:py-4 xxxl:py-6" id="topbar" style="background: aliceblue;">
    
    <div class="topbar-inner flex items-center justify-between gap-2">
        
        <div class="flex grow items-center gap-2 xxl:gap-4">
            <a href="{{ route('index1') }}" class="topbar-logo hidden shrink-0">
                <img width="174" height="38" src="{{ asset('assets/images/SIT_LOGO.png') }}" alt="logo"
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
                        <li class="px-4 py-2  hover:bg-gray-100 uppercase cursor-pointer submenu-trigger"
                            data-submenu="accountsMenu">
                            Accounts →
                        </li>

                        <!-- Submenu triggers -->
                        <li class="relative px-4 py-2 uppercase hover:bg-gray-100 cursor-pointer ">
                            <a href="#"> New Journal Entry</a>
                        </li>

                        <li class="relative px-4 py-2 uppercase hover:bg-gray-100 cursor-pointer ">
                            <a href="{{ route('day.book') }}">Day Book</a>
                        </li>

                        <li class="px-4 py-2 hover:bg-gray-100 uppercase cursor-pointer">
                            <a href="#">Schedule SMS</a>
                        </li>

                        <li class="px-4 py-2 hover:bg-gray-100 uppercase cursor-pointer submenu-trigger "
                            data-submenu="reportsMenu">
                            Reports →
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100 uppercase cursor-pointer submenu-trigger "
                            data-submenu="dailycollectionMenu">
                            DAILY COLLECTION →
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100 uppercase cursor-pointer submenu-trigger  "
                            data-submenu="compliancesMenu">
                            Compliances →
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100 uppercase cursor-pointer submenu-trigger  "
                            data-submenu="legalMenu">
                            Legal →
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100 uppercase cursor-pointer submenu-trigger  "
                            data-submenu="niyamakMenu">
                            niyamak mandal →
                        </li>
                    </ul>
                </div>

                <!-- Submenus -->
                <div id="accountsMenu"
                    class="hidden absolute left-0  bg-white border  border-gray-200 rounded-lg shadow-lg z-50 w-64"
                    style="margin-left: 5px; margin-top: 55px !important;">
                    <ul>
                        <a href="{{ route('accounting.tree') }}">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                                <i class="las la-tree"></i>
                                Tree
                            </li>
                        </a>
                        <a href="{{ route('ledger-group.index') }}">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                                <i class="las la-object-group"></i>
                                Ledger Groups
                            </li>
                        </a>
                        <a href="{{ route('ledger.index') }}">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                                <i class="las la-plus-circle"></i>
                                Ledgers
                            </li>
                        </a>
                        <a href="{{ route('trial.balance') }}">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                                <i class="las la-balance-scale"></i>
                                Trial Balance
                            </li>
                        </a>
                        <a href="{{ route('profit-loss.profit_loss') }}">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                                <i class="las la-rupee-sign"></i>
                                Profit and Loss (P&L)
                            </li>
                        </a>
                        <a href="{{ route('income.statement') }}">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                                <i class="las la-random"></i>
                                Income Statement
                            </li>
                        </a>
                        <a href="{{ route('balance.sheet') }}">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                                <i class="las la-chart-bar"></i>
                                Balance Sheet
                            </li>
                        </a>
                        <a href="{{ route('vendors.index') }}">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                                <i class="las la-user-friends"></i>
                                vendors
                            </li>
                        </a>
                        <a href="">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                                <i class="las la-list-ul"></i>
                                Entries
                            </li>
                        </a>
                        <a href="">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                                <i class="las la-list"></i>
                                FY REPORT
                            </li>
                        </a>
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
                        {{-- <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                            <i class="las la-building"></i>
                            <a href="">Branch Report</a>
                        </li> --}}
                         <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                            <i class="las la-money-bill"></i>
                            <a href="{{ route('reports.branch') }}"> Branch Report</a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                            <i class="las la-balance-scale"></i>
                            <a href="{{route('loan-report.maturity_index')}}">Maturity Report</a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                            <i class="las la-money-bill"></i>
                            <a href="{{ route('loan-report.index') }}"> Loan Report</a>
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
                            <a href="">Collection Report</a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                            <i class="las la-id-badge"></i>
                            <a href="">Active Associates</a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                            <i class="las la-money-bill"></i>
                            <a href="">Associates Collection Limit</a>
                        </li>
                    </ul>
                </div>

                <div id="compliancesMenu"
                    class="hidden absolute left-0  bg-white border  border-gray-200 rounded-lg shadow-lg z-50 w-64"
                    style="margin-left: 5px; margin-top: 55px !important;">
                    <ul>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                            <a href="{{ route('index-from-i') }}" class="uppercase">
                                <i class="las la-file-contract"></i>
                                form I And J
                            </a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer uppercase">
                            <a href="{{ route('index-from-e') }}">
                                <i class="las la-file-alt"></i>
                                form E</a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100  cursor-pointer uppercase">
                            <a href="{{ route('mis_index') }}">
                                <div class="flex gap-1">

                                    <p> <i class="las la-file-invoice"></i></p>
                                    <p>
                                        Management Information Systems
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100  cursor-pointer uppercase">
                            <a href="">
                                <div class="flex gap-1">

                                    <p> <i class="las la-file-invoice"></i></p>
                                    <p>
                                        RBI
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-100  cursor-pointer uppercase">
                            <a href="">
                                <div class="flex gap-1">

                                    <p> <i class="las la-file-invoice"></i></p>
                                    <p>
                                        DDR / AR / JT Office
                                    </p>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
            <!-- Dropdown end -->

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
            <!-- <button id="darkModeToggle" aria-label="dark mode switch"
                class="h-10 w-10 shrink-0 rounded-full border border-n30 bg-primary/5 dark:border-n500 dark:bg-bg3 md:h-12 md:w-12">
                <i class="las la-sun text-2xl dark:hidden"></i>
                <span class="hidden text-n30 dark:block">
                    <i class="las la-moon text-2xl"></i>
                </span>
            </button> -->

            <!-- Profile dropdown -->
            <div class="relative shrink-0">
                @php
                    $user = auth()->user();
                    $photo = $user->profilePhoto->filename ?? null;
                @endphp

                <!-- PROFILE BUTTON -->
                <div id="profile-btn" class="cursor-pointer">
                    <img src="{{ $photo 
                    ? asset('storage/profile_photos/'.$photo) 
                    : asset('assets/images/user-big-4.png') }}"
                    class="profile-avatar"
                    style="width:45px;height:45px;object-fit:cover;">
                </div>

                <!-- DROPDOWN -->
                <div id="profile"
                    class="profile-dropdown hide absolute right-0 mt-3 w-72 rounded-2xl overflow-hidden">

                    <!-- USER INFO -->
                    <div class="flex flex-col items-center text-center p-5 border-b dark:border-gray-700">

                        <img src="{{ $photo 
                            ? asset('storage/profile_photos/'.$photo) 
                            : asset('assets/images/user-big-4.png') }}"
                            class="rounded-full mb-3 border-2 border-primary"
                            style="width:60px;height:60px;object-fit:cover;">

                        <h6 class="font-semibold text-sm uppercase">
                            {{ $user?->fname && $user?->lname ? $user->fname.' '.$user->lname : '' }}
                        </h6>

                        <span class="text-gray-500 text-xs mt-1">
                            {{ $user?->email ?? '' }}
                        </span>
                    </div>

                    <!-- MENU -->
                    <ul class="flex flex-col text-sm">

                        <li>
                            <a href="{{ route('settings.profile') }}"
                                class="menu-item flex items-center gap-3 px-5 py-3">
                                <i class="las la-user text-lg"></i>
                                Profile
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('support.help.center') }}"
                                class="menu-item flex items-center gap-3 px-5 py-3">
                                <i class="las la-life-ring text-lg"></i>
                                Help Center
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('settings.security') }}"
                                class="menu-item flex items-center gap-3 px-5 py-3">
                                <i class="las la-cog text-lg"></i>
                                Settings
                            </a>
                        </li>

                        <li class="border-t mt-2">
                            <a href="#"
                                class="menu-item logout-item flex items-center gap-3 px-5 py-3">
                                <i class="las la-sign-out-alt text-lg"></i>
                                Logout
                            </a>
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