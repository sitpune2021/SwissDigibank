
<style>
    
    /* 🔥 NAVBAR GLASS EFFECT */
    #topbar {
    background:
        linear-gradient(
            135deg,
            #0f172a 0%,
            #111827 45%,
            #1e293b 100%
        );

    backdrop-filter: blur(18px);

    border-bottom: 1px solid rgba(255,255,255,0.06);

    box-shadow:
        0 4px 20px rgba(0,0,0,0.35),
        inset 0 -1px 0 rgba(255,255,255,0.04);
}

    #topbar{
    position: relative;
    z-index: 100;
}

@media (max-width:768px){

    #topbar{

        padding-left:12px !important;
        padding-right:12px !important;
    }

    .topbar-inner{

        gap:10px !important;
    }

    #dropdownBtn{

        padding:8px 14px !important;

        font-size:12px !important;
    }
}

#sidebar-toggle-btn{

    position: relative;

    z-index: 99999;
}

#sidebar-toggle-btn i{

    text-shadow: 0 0 12px rgba(255,255,255,0.35);
}

    /* 🔥 MENU BUTTON */
    #dropdownBtn {

    background: rgba(255,255,255,0.06);

    color: #f8fafc;

    border-radius: 14px;

    padding: 10px 18px;

    border: 1px solid rgba(255,255,255,0.08);

    font-size: 13px;

    font-weight: 700;

    letter-spacing: .5px;

    transition: all .3s ease;
}

#dropdownBtn:hover {

    transform: translateY(-1px);

    background: rgba(255,255,255,0.10);

    box-shadow:
        0 8px 25px rgba(0,0,0,0.25);

}

    /* 🔥 MAIN DROPDOWN */
    #dropdownMenu {

    background: rgba(15,23,42,0.96) !important;

    backdrop-filter: blur(22px);

    border: 1px solid rgba(255,255,255,0.06);

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 15px 40px rgba(0,0,0,0.45);

    padding: 10px;
}

#dropdownMenu li,
#accountsMenu li,
#reportsMenu li,
#dailycollectionMenu li,
#compliancesMenu li {

    border-radius: 12px;

    margin-bottom: 4px;

    font-size: 13px;

    font-weight: 600;

    transition: all .25s ease;
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
        background: rgba(255,255,255,0.07);
        color: white;

        transform: translateX(5px);
        box-shadow:
    inset 0 0 0 1px rgba(255,255,255,0.04),
    0 8px 18px rgba(0,0,0,0.18);
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

    border: 2px solid rgba(255,255,255,0.12);

    box-shadow:
        0 8px 20px rgba(0,0,0,0.35);

    transition: all .3s ease;
}

.profile-avatar:hover {

    transform: translateY(-2px) scale(1.03);

    box-shadow:
        0 12px 25px rgba(0,0,0,0.45);
}
.profile-dropdown {

    background: rgba(15,23,42,0.97);

    backdrop-filter: blur(24px);

    border: 1px solid rgba(255,255,255,0.06);

    border-radius: 22px;

    overflow: hidden;

    box-shadow:
        0 18px 50px rgba(0,0,0,0.5);
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
.navbar-top {

    position: sticky;

    top: 0;

    overflow: visible;
}

#topbar {

    animation: navbarFade .4s ease;
}

@keyframes navbarFade {

    from {
        opacity: 0;
        transform: translateY(-8px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<nav class="navbar-top topbarfull z-20 gap-3 bg-n0 py-3 shadow-sm duration-300 border-b border-n0 dark:border-n700 dark:bg-bg4 xl:py-4 xxxl:py-6" id="topbar" style="background: aliceblue;">
    
    <div class="topbar-inner flex items-center justify-between gap-2">
        
        <div class="flex grow items-center gap-2 xxl:gap-4">

            <a href="{{ route('index1') }}" class="topbar-logo hidden shrink-0">
                <img width="174" height="38" src="{{ asset('assets/images/SIT_LOGO.png') }}" alt="logo"
                    class="logo-full2 hidden lg:block" />
            </a>

            <!-- MOBILE SIDEBAR BUTTON -->
            <div class="relative lg:hidden shrink-0 z-[9999]">

                <button
                    id="sidebar-toggle-btn"

                    class="mobile-toggle-btn
                    flex
                    h-11
                    w-11
                    cursor-pointer
                    items-center
                    justify-center
                    rounded-2xl
                    shrink-0
                    transition-all
                    duration-300
                    md:h-12
                    md:w-12"
                >

                    <i class="las la-bars"></i>

                </button>

            </div>

            <!-- Dropdown Trigger -->
            <div class="whitespace-nowrap relative inline-block grow min-w-0 items-center gap-2 xxl:gap-4">
                <!-- Main button -->
                <button id="dropdownBtn" class="btn-outline uppercase py-2 px-1 transition" style="
                    background: linear-gradient(135deg,#f59e0b,#d97706) !important;
                    color:white;
                    border:1px solid rgba(255,255,255,0.08);
                    box-shadow:0 6px 20px rgba(245,158,11,0.35);
                ">
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

            <!-- Profile dropdown -->
            <div class="relative shrink-0">
                @php
                    $user = auth()->user();
                    $photo = $user->profilePhoto->filename ?? null;
                @endphp

                <!-- PROFILE BUTTON -->
                <div id="profile-btn" class="cursor-pointer" style="box-shadow: 0px 5px 15px 15px rgba(0, 0, 0, 0.2);">
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
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="flex items-center gap-3 px-5 py-3 text-red-500 hover:bg-red-500 hover:text-white transition"
                                style="
background:linear-gradient(135deg,#ef4444,#dc2626);
color:white;
">
                                <i class="las la-sign-out-alt text-lg"></i>
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('log.out') }}" method="POST" style="display:none;">
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

    // sidebar pe click hua to kuch mat karo
    if (e.target.closest("#sidebar")) {
        return;
    }

    // toggle button pe click hua to kuch mat karo
    if (e.target.closest("#sidebar-toggle-btn")) {
        return;
    }

    // dropdown close logic
    if (
        !dropdownMenu.contains(e.target) &&
        !dropdownBtn.contains(e.target)
    ) {

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