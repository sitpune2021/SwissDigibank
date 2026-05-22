@php
    use App\Models\Menu;
    use Illuminate\Support\Facades\Auth;
    $menuItems = Menu::with('submenus')->orderBy('id')->get();
    $user = Auth::user();
    $roleName = optional($user?->role)->name; // safely get role name
@endphp

@php

    use App\Models\logo_letterhead_img_uploads;
    use App\Models\User;
    //  use Illuminate\Support\Facades\Auth;

    // Find Super Admin
    $superAdmin = User::whereHas('role', function ($q) {
        $q->where('id', 1);
    })->first();


    // Fetch logo uploaded by Super Admin
    $sidebarLogo = null;

    if ($superAdmin) {
        $sidebarLogo = logo_letterhead_img_uploads::where('type', 'logo')
            ->where('uploaded_by', $superAdmin->id)
            ->latest()
            ->first();       
    }

    // Final logo path with fallback
    $logoPath = $sidebarLogo 
        ? asset('storage/' . $sidebarLogo->image_path)
        :  asset('assets/images/SIT_LOGO1.png');

@endphp

@php

    $permissions = auth()->user()?->rolePermission?->permissions ?? [];

@endphp

<style>
.submenu {
    margin: 0;
    padding: 0;
    list-style: none;
}

/* hidden state */
.submenu{
    display:none;
    margin-top:6px;
}

.submenu.submenu-show{
    display:block !important;
}
</style>

<style>
.menu-ul li:last-child {
    margin-bottom: 20px;
}
.menu-container {
    scroll-behavior: smooth;
}
    /* 🔥 HOVER EFFECT */
.menu-btn:hover{

    background:
    linear-gradient(
        135deg,
        rgba(59,130,246,0.22),
        rgba(6,182,212,0.14)
    ) !important;

    transform:
        translateX(5px)
        scale(1.01);

    border-color:
        rgba(96,165,250,0.22);

    box-shadow:
        0 10px 35px rgba(37,99,235,0.18),
        0 0 18px rgba(59,130,246,0.15);

    color:#fff !important;
}
/* =========================================
   NEO MENU TEXT
========================================= */

.neo-menu-text{

    color:#f8fafc !important;

    font-weight:600;

    letter-spacing:0.4px;

    text-shadow:
        0 0 8px rgba(255,255,255,0.15),
        0 0 16px rgba(59,130,246,0.12);

    transition:all .28s ease;
}

/* HOVER */
.menu-btn:hover .neo-menu-text{

    color:#ffffff !important;

    text-shadow:
        0 0 10px rgba(255,255,255,0.35),
        0 0 22px rgba(59,130,246,0.28);
}

/* ACTIVE */
.menu-btn.active .neo-menu-text{

    color:#ffffff !important;

    text-shadow:
        0 0 12px rgba(255,255,255,0.45),
        0 0 28px rgba(96,165,250,0.45);
}
/* 🔥 ACTIVE MENU */
.menu-btn.active{

    background:
    linear-gradient(
        90deg,
        #33697e,
        #33697e
    ) !important;

    color:#fff !important;

    border-color:transparent;

    box-shadow:
        0 10px 25px rgba(37,99,235,0.25);
}

/* 🔥 LEFT ACTIVE LINE */
.menu-li.active::before{
    content:"";
    position:absolute;

    left:-10px;
    top:10%;

    width:4px;
    height:80%;

    border-radius:20px;

    background:
    linear-gradient(
    180deg,
    #60a5fa,
    #22d3ee
    );

    box-shadow:
    0 0 14px rgba(59,130,246,0.8);
}

.menu-icon{

    width:36px;
    height:36px;

    border-radius:14px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,0.08),
            rgba(255,255,255,0.03)
        );

    border:1px solid rgba(255,255,255,0.08);

    transition:.3s;

    color:#bfdbfe;

    backdrop-filter: blur(10px);

    box-shadow:
        0 6px 14px rgba(0,0,0,0.22),
        inset 0 1px 0 rgba(255,255,255,0.06);
}

.menu-btn:hover .menu-icon,
.menu-btn.active .menu-icon{

    background:rgba(255,255,255,0.12);

    transform:scale(1.06);

    box-shadow:0 0 15px rgba(255,255,255,0.08);
}

/* 🔥 SUBMENU STYLE */
.submenu-link{

    display:flex;
    align-items:center;
    gap:10px;

    color:#cbd5e1;

    padding:10px 14px !important;

    margin:4px 0;

    border-radius:12px;

    transition:all .25s ease;
}

/* 🔥 SUBMENU HOVER */
.submenu-link:hover{

    color:#fff;

    background:
    linear-gradient(
    90deg,
    rgba(59,130,246,0.15),
    rgba(6,182,212,0.08)
    );

    transform:translateX(4px);
}
.menu-ul{
    display:flex;
    flex-direction:column;
    gap:8px;
}

.menu-container::-webkit-scrollbar{
    width:6px;
}

.menu-container::-webkit-scrollbar-track{
    background:transparent;
}

.menu-container::-webkit-scrollbar-thumb{
    background:rgba(148,163,184,0.25);
    border-radius:20px;
}

.menu-container::-webkit-scrollbar-thumb:hover{
    background:rgba(59,130,246,0.5);
}

/* 🔥 ICON GLOW */
.menu-btn:hover i {
    text-shadow: 0 0 8px #3b82f6;
}
.menu-btn{

    position:relative;
    width:100%;

    padding:12px 14px !important;

    border-radius:18px !important;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,0.05),
            rgba(255,255,255,0.02)
        ) !important;

    border:1px solid rgba(255,255,255,0.08);

    transition:all .32s ease;

    overflow:hidden;

    backdrop-filter: blur(16px);

    box-shadow:
        0 8px 20px rgba(0,0,0,0.28),
        inset 0 1px 0 rgba(255,255,255,0.05);
}
.menu-li {
    background: transparent !important;
}

.menu-li * {
    background-color: transparent !important;
}

/* =======================================================
   RESPONSIVE SIDEBAR
======================================================= */

/* =======================================================
   DESKTOP SIDEBAR
======================================================= */

.sidebar{
    width:270px;
    min-width:270px;
    height:100vh;

    position:fixed;
    top:0;
    left:0;

    z-index:9999;

    overflow-y:auto;
    overflow-x:hidden;

    transform: translateX(0);
    transition: transform .3s ease;
}

/* HIDE STATE */
.sidebar.hide-sidebar{
    transform: translateX(-100%);
}

/* CONTENT */
.main-content{
    margin-left:270px;
    width: calc(100% - 270px);
    transition: all .3s ease;
}

.main-content.full{
    margin-left:0 !important;
    width:100% !important;
}

/* MOBILE OVERLAY */
.sidebar-overlay{
    position:fixed;
    inset:0;

    background:rgba(0,0,0,0.6);

     z-index:99990;

    opacity:0;
    visibility:hidden;

    transition:.3s;
}

.sidebar-overlay.show{
    opacity:1;
    visibility:visible;
}

/* MOBILE VIEW */
@media(max-width:991px){

    .sidebar{
        position: fixed !important;
        top: 0;
        left: 0;
        width: 270px;
        height: 100vh;

        transform: translateX(-100%);
        transition: transform .3s ease-in-out !important;

        z-index: 99999 !important;
    }

    .sidebar.show{
        transform: translateX(0%) !important;
    }

    .main-content{
        margin-left:0 !important;
        width:100%;
    }
}

/* SMALL MOBILE */
@media(max-width:576px){

    .sidebar{
        width:85%;
        min-width:85%;
    }
    .sidebar.show{
    transform: translateX(0) !important;
}

    .menu-btn{
        border-radius:12px !important;
    }

    .submenu-link{
        padding:8px 10px !important;
    }
}
.submenu{

    margin-top:10px;

    padding:10px;

    border-radius:18px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,0.05),
            rgba(255,255,255,0.02)
        );

    backdrop-filter: blur(18px);

    border:
        1px solid rgba(255,255,255,0.06);

    box-shadow:
        0 10px 30px rgba(0,0,0,0.22);
}
/* =========================================
   PREMIUM ANIMATED NEO SIDEBAR
========================================= */

.neo-sidebar{

    position: relative;
    overflow: hidden;

    background:
        linear-gradient(
            180deg,
            #040404 0%,
            #1b1b1d 35%,
            #2c3440 100%
        );

    border-right:1px solid rgba(255,255,255,0.08);

    box-shadow:
        0 0 40px rgba(0,0,0,0.55),
        inset 0 1px 0 rgba(255,255,255,0.04);

    backdrop-filter: blur(20px);
}

/* =========================================
   MOVING GRADIENT LIGHT
========================================= */

.neo-sidebar::before{

    content:"";

    position:absolute;

    width:420px;
    height:420px;

    top:-120px;
    left:-140px;

    border-radius:50%;

    background:
        radial-gradient(
            circle,
            rgba(59,130,246,0.18),
            transparent 70%
        );

    animation:
        floatingGlow 10s ease-in-out infinite;

    pointer-events:none;
}

/* SECOND LIGHT */

.neo-sidebar::after{

    content:"";

    position:absolute;

    width:360px;
    height:360px;

    bottom:-120px;
    right:-100px;

    border-radius:50%;

    background:
        radial-gradient(
            circle,
            rgba(168,85,247,0.16),
            transparent 70%
        );

    animation:
        floatingGlow2 12s ease-in-out infinite;

    pointer-events:none;
}

/* =========================================
   FLOAT ANIMATION
========================================= */

@keyframes floatingGlow{

    0%{
        transform:
            translate(0px,0px)
            scale(1);
    }

    50%{
        transform:
            translate(40px,30px)
            scale(1.1);
    }

    100%{
        transform:
            translate(0px,0px)
            scale(1);
    }
}

@keyframes floatingGlow2{

    0%{
        transform:
            translate(0px,0px)
            scale(1);
    }

    50%{
        transform:
            translate(-30px,-40px)
            scale(1.08);
    }

    100%{
        transform:
            translate(0px,0px)
            scale(1);
    }
}

/* =========================================
   SHINING TOP LIGHT
========================================= */

.logo-container::before{

    content:"";

    position:absolute;

    top:0;
    left:-100%;

    width:120%;
    height:2px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,0.7),
            transparent
        );

    animation:
        shineMove 4s linear infinite;
}

    @keyframes shineMove{

        0%{
            left:-100%;
        }

        100%{
            left:120%;
        }
    }
.menu-btn::before{

    content:"";

    position:absolute;

    inset:0;

    background:
        linear-gradient(
            120deg,
            transparent,
            rgba(255,255,255,0.08),
            transparent
        );

    transform:translateX(-100%);

    transition:0.6s;
}

.menu-btn:hover::before{
    transform:translateX(100%);
}
/* =========================================
   RIGHT SIDE VERTICAL ANIMATION
========================================= */

.neo-sidebar .sidebar-right-glow{

    position:absolute;

    top:0;
    right:0;

    width:3px;
    height:100%;

    overflow:hidden;

    z-index:2;
}

.neo-sidebar .sidebar-right-glow::before{

    content:"";

    position:absolute;

    top:-30%;

    right:0;

    width:100%;
    height:220px;

    border-radius:50px;

    background:
        linear-gradient(
            180deg,
            transparent,
            #60a5fa,
            #22d3ee,
            transparent
        );

    box-shadow:
        0 0 25px #3b82f6,
        0 0 40px #06b6d4;

    animation:
        verticalLightMove 5s linear infinite;
}

/* =========================================
   TOP HORIZONTAL ANIMATION
========================================= */

.neo-sidebar .sidebar-top-glow{

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:3px;

    overflow:hidden;

    z-index:2;
}

.neo-sidebar .sidebar-top-glow::before{

    content:"";

    position:absolute;

    left:-30%;

    top:0;

    width:220px;
    height:100%;

    border-radius:50px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #818cf8,
            #38bdf8,
            transparent
        );

    box-shadow:
        0 0 25px #6366f1,
        0 0 40px #38bdf8;

    animation:
        horizontalLightMove 4s linear infinite;
}

/* =========================================
   ANIMATION KEYFRAMES
========================================= */

@keyframes verticalLightMove{

    0%{
        top:-30%;
    }

    100%{
        top:120%;
    }
}

@keyframes horizontalLightMove{

    0%{
        left:-30%;
    }

    100%{
        left:120%;
    }
}
</style>

<!-- <aside id="sidebar" class="sidebar mobile-sidebar" style="background: linear-gradient(180deg,#0f172a,#020617); border-right:1px solid rgba(59,130,246,0.25); box-shadow:0 0 30px rgba(59,130,246,0.2);"> -->
<!-- <aside id="sidebar" class="sidebar mobile-sidebar"
    style="
    background:
    linear-gradient(
        180deg,
        #040404 0%,
        #262424f2 45%,
        #393f4c 100%
    );

    border-right:1px solid rgba(255,255,255,0.08);

    box-shadow:
        0 10px 40px rgba(0,0,0,0.45),
        0 0 25px rgba(59,130,246,0.08);

    backdrop-filter: blur(18px);
"> -->
<aside id="sidebar" class="sidebar mobile-sidebar neo-sidebar">
    <div class="sidebar-top-glow"></div>
<div class="sidebar-right-glow"></div>
    <div class="sidebar-inner relative" >
        <div class="logo-column">
            
            <div class="logo-container"
                style="
                height:140px;
                margin-bottom:18px;
                padding:16px 12px;
                border-bottom:1px solid rgba(255,255,255,0.06);
                background:linear-gradient(180deg,rgba(255,255,255,0.04),transparent);
            ">
                <div class="logo-inner">                   
                    <a href="{{ route('index1') }}" class="logo-wrapper">
                        <!-- Full Logo -->
                        <img src="{{ $logoPath }} " width="174" height="50" class="logo-full" alt="logo" style="
                            width:225px;
                            height:100px;
                            filter:
                            drop-shadow(0 0 10px rgba(255,255,255,0.08))
                            drop-shadow(0 0 18px rgba(59,130,246,0.20));
                        " />

                        <!-- Icon Logo -->
                        <img src="{{ $logoPath }}" width="37" height="36" class="logo-icon hidden" alt="logo" />
                    </a>
                    {{-- <img width="141" height="38" class="logo-text hidden"
                        src="{{ asset('assets/images/SBC_Logo.png') }}" alt="logo text" /> --}}
                    <img width="141" height="38" class="logo-text hidden" src="{{ $logoPath }}" alt="logo text" />
                    <button class="sidebar-close-btn xl:hidden" id="sidebar-close-btn">
                        <i class="las la-times"></i>
                    </button>
                </div>
            </div>

            <div class="menu-container pb-28" style="background: transparent; height: calc(100vh - 130px); overflow-y: auto; padding-bottom: 20px;">
                {{-- <div class="menu-wrapper"> --}}
                <div style="padding: 0px 10px; background: transparent;">
                    <ul class="menu-ul" style="background: transparent;">
                        @foreach ($menuItems as $item)

                        @php

                            $hasSubPermission = false;

                            // SUPER ADMIN
                            if(auth()->user()->role_id == 1){

                                $hasSubPermission = true;

                            } else {

                                // CHECK SUBMENUS
                                if($item->submenus->isNotEmpty()) {

                                    foreach($item->submenus as $sub) {

                                        if(in_array($sub->route, $permissions)) {

                                            $hasSubPermission = true;
                                            break;

                                        }

                                    }

                                } else {

                                    if(in_array($item->route, $permissions)) {

                                        $hasSubPermission = true;

                                    }

                                }

                            }

                            // HIDE MENU
                            if(!$hasSubPermission) continue;

                        @endphp
                        @php

                        // Skip "User" menu for Customer
                        if (
                        in_array($roleName, ['Customer']) &&
                        in_array(strtolower($item->title), ['approvals', 'user', 'hr management'])
                        ) {
                        continue;
                        }

                        $filteredSubmenus = $item->submenus;

                        // If Role Customer and menu title is "Company" → hide specific submenus
                        if ($roleName === 'Customer' && strtolower($item->title) === 'company') {
                        $filteredSubmenus = $filteredSubmenus->filter(function ($sub) {
                        return !in_array(
                        strtolower($sub->title),
                        ['promotors', 'promotor share holdings', 'director']
                        );
                        });
                        }

                        $isActive = request()->routeIs($item?->route ?? '');
                        $submenuActive = $item->submenus->contains(function ($sub) {
                        return request()->routeIs($sub->route);
                        });
                        @endphp

                        {{-- Future-ready: Add tab/section separator logic --}}
                        @if (!empty($item->is_tab_start))
                        <hr style="margin: 10px 0; border-color: #ccc;">
                        @endif

                        <li class="menu-li {{ $isActive || $submenuActive ? 'active' : '' }}    ">
                            @if ($item->submenus->isNotEmpty())
                            <button style="
    padding: 8px 14px;
    color:#ffffff;
    background: rgba(255,255,255,0.04);
    border-radius:14px;
    transition:0.25s;
"
                                class="menu-btn group !bg-transparent dark:!bg-transparent {{ $isActive || $submenuActive ? 'active' : '' }}"
                                type="button" onclick="
                                    const submenu = this.nextElementSibling;

                                    document.querySelectorAll('.submenu').forEach(el => {
                                        if(el !== submenu){
                                            el.classList.remove('submenu-show');
                                        }
                                    });

                                    document.querySelectorAll('.menu-btn').forEach(btn => {
                                        if(btn !== this){
                                            btn.classList.remove('active');
                                        }
                                    });

                                    submenu.classList.toggle('submenu-show');
                                    this.classList.toggle('active');
                            ">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon" style="font-size: 14px !important;">
                                        <i class="{{ $item->icon }}"></i>
                                    </span>
                                    <span class="menu-title neo-menu-text font-medium text-start"
                                        style="font-size: 14px !important;">{{ $item->title }}</span>
                                </span>
                                <span class="plus-minus" style="font-size: 14px !important;">
                                    <i class="las la-plus text-xl {{ $submenuActive ? 'show' : '' }}"
                                        style="font-size: 14px !important;"></i>
                                    <i class="las la-minus text-xl {{ $submenuActive ? '' : 'show' }}"
                                        style="font-size: 14px !important;"></i>
                                </span>
                            </button>

                            <ul class="submenu {{ $submenuActive ? 'submenu-show' : '' }}">
                                @foreach ($item->submenus as $sub)
                                @if(auth()->user()->role_id != 1 && !in_array($sub->route, $permissions))
                                    @continue
                                @endif
                                <li>
                                    <a href="{{ route($sub->route) }}"
                                        class="submenu-link {{ request()->routeIs($sub->route) ? 'text-primary' : '' }}"
                                        style="padding: 3px 10px;">
                                        <i class="las la-minus text-xl"></i>
                                        <span style="font-size: 14px !important;">{{ $sub->title }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <a href="{{ route($item?->route) }}" style="padding:8px 14px; color:#e2e8f0; background: rgba(255,255,255,0.03); border-radius:10px; transition:0.25s;"
                                class="menu-btn border-n30 !bg-transparent dark:!bg-transparent flex items-center justify-center gap-2 {{ $isActive ? 'active' : '' }}">
                                <span class=" flex justify-start gap-2 ">
                                    <span class="menu-icon ">
                                        <i class="{{ $item->icon }}"></i>
                                    </span>
                                    <span class="menu-title font-semibold tracking-wide"
                                        style="
                                        font-size:13.5px !important;
                                        letter-spacing:0.3px;
                                    ">
                                        {{ $item->title }}
                                    </span>
                                </span>
                                <span class="plus-minus" style="font-size: 14px !important;">
                                    <i class="las la-plus text-xl {{ $submenuActive ? 'show' : '' }}"
                                        style="font-size: 14px !important;"></i>
                                    <i class="las la-minus text-xl {{ $submenuActive ? '' : 'show' }}"
                                        style="font-size: 14px !important;"></i>
                                </span>
                            </a>
                            @endif
                        </li>

                        {{-- Always add
                        <hr> AFTER HR MANAGEMENT --}}
                        @if ($item->title === 'HR MANAGEMENT')
                        {{-- <hr style="margin: 10px 0; border-color: #ccc;"> --}}
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            
        </div>
    </div>

</aside>

<div id="sidebarOverlay" class="sidebar-overlay"></div>

{{-- Optional JS: Only one submenu open at a time --}}
<script>
    document.querySelectorAll('.menu-btn').forEach(btn => {
    btn.addEventListener('click', function() {

        // your existing code
        document.querySelectorAll('.submenu-show').forEach(sub => {
            if (sub !== this.nextElementSibling) {
                sub.classList.remove('submenu-show');
            }
        });

        document.querySelectorAll('.menu-btn.active').forEach(activeBtn => {
            if (activeBtn !== this) {
                activeBtn.classList.remove('active');
                activeBtn.querySelector('.la-plus')?.classList.add('show');
                activeBtn.querySelector('.la-minus')?.classList.remove('show');
            }
        });

        // ✅ ADD THIS PART (scroll fix)
        const submenu = this.nextElementSibling;
        if (submenu && submenu.children.length > 7) {
            submenu.style.maxHeight = "250px";
            submenu.style.overflowY = "auto";
        }
    });
});
</script>

