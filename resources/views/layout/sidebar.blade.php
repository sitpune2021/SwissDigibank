@extends('layout.sidebarstyle')

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
    <div class="mouse-glow" id="mouseGlow"></div>

    <div class="neo-particles">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="sidebar-inner relative">
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
                                @foreach ($filteredSubmenus as $sub)
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

