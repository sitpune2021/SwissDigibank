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
    90deg,
    rgba(37,99,235,0.22),
    rgba(6,182,212,0.16)
    ) !important;

    transform:translateX(5px);

    border-color:rgba(59,130,246,0.25);

    box-shadow:
    0 10px 25px rgba(2,6,23,0.45),
    inset 0 1px 0 rgba(255,255,255,0.04);

    color:#fff !important;
}

/* 🔥 ACTIVE MENU */
.menu-btn.active{

    background:
    linear-gradient(
    90deg,
    #0a0a0a,
    #0891b2
    ) !important;

    color:#fff !important;

    border-color:rgba(255,255,255,0.10);

    box-shadow:
    0 12px 24px rgba(37,99,235,0.30),
    0 0 0 1px rgba(255,255,255,0.04);

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
    width:34px;
    height:34px;

    border-radius:10px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:rgba(255,255,255,0.04);

    border:1px solid rgba(255,255,255,0.05);

    transition:.3s;
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

    color:#94a3b8;

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

    border-radius:16px !important;

    background:rgba(255,255,255,0.03) !important;

    border:1px solid rgba(255,255,255,0.04);

    transition:all .28s ease;

    overflow:hidden;
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
    margin-top:8px;

    padding:8px;

    border-radius:16px;

    background:
    rgba(255,255,255,0.02);

    border:
    1px solid rgba(255,255,255,0.03);
}
</style>

<!-- <aside id="sidebar" class="sidebar mobile-sidebar" style="background: linear-gradient(180deg,#0f172a,#020617); border-right:1px solid rgba(59,130,246,0.25); box-shadow:0 0 30px rgba(59,130,246,0.2);"> -->
<aside id="sidebar" class="sidebar mobile-sidebar"
    style="
    background:
    linear-gradient(180deg,#071028 0%, #0b1736 45%, #111827 100%);
    border-right:1px solid rgba(148,163,184,0.15);
    box-shadow:
    0 0 40px rgba(15,23,42,0.9),
    0 0 18px rgba(59,130,246,0.12);
    backdrop-filter: blur(16px);
    ">
    
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
                            <button style="padding: 8px 14px; color:#cbd5e1; background: rgba(59,130,246,0.08); border-radius:10px; transition:0.25s;"
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
                                    <span class="menu-title font-medium  text-start "
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
                            <a href="{{ route($item?->route) }}" style="padding:8px 14px; color:#cbd5e1; background: rgba(255,255,255,0.03); border-radius:10px; transition:0.25s;"
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

