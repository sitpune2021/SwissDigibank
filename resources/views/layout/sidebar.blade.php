@php
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
$menuItems = Menu::with('submenus')->orderBy('id')->get();
$user = Auth::user();
$roleName = optional($user->role)->name; // safely get role name


@endphp
@php
use App\Models\logo_letterhead_img_uploads;
use App\Models\User;
// use Illuminate\Support\Facades\Auth;

// Find Super Admin
$superAdmin = User::whereHas('role', function ($q) {
    $q->where('name', 'Super Admin');
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
    ? Storage::url($sidebarLogo->image_path)
    : asset('assets/images/SBC_Logo.png');
@endphp

{{-- @php

use App\Models\logo_letterhead_img_uploads;

$sidebarLogo = null;

if (Auth::check()) {
$sidebarLogo = logo_letterhead_img_uploads::where('type', 'logo')
->where('uploaded_by', Auth::id())
->first();
}

$logoPath = $sidebarLogo
? asset($sidebarLogo->image_path)
: asset('assets/images/SBC_Logo.png');
@endphp --}}

<aside id="sidebar" class="sidebar bg-n0 dark:!bg-bg4">
    <div class="sidebar-inner relative">
        <div class="logo-column">
            <div class="logo-container">
                <div class="logo-inner">
                    {{-- <a href="{{ route('index1') }}" class="logo-wrapper">
                        <img src="{{ asset('assets/images/SBC_Logo.png') }}" width="174" height="38" class="logo-full"
                            alt="logo" />
                        <img src="{{ asset('assets/images/SBC_Logo.png') }}" width="37" height="36"
                            class="logo-icon hidden" alt="logo" />
                    </a> --}}
                    <a href="{{ route('index1') }}" class="logo-wrapper">
                        <!-- Full Logo -->
                        <img src="{{ $logoPath }}" width="174" height="38" class="logo-full" alt="logo" />

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

            <div class="menu-container pb-28">
                <div class="menu-wrapper">
                    <ul class="menu-ul">
                        @foreach ($menuItems as $item)
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

                        {{-- ✅ Future-ready: Add tab/section separator logic --}}
                        @if (!empty($item->is_tab_start))
                        <hr style="margin: 10px 0; border-color: #ccc;">
                        @endif

                        <li class="menu-li {{ $isActive || $submenuActive ? 'active' : '' }}   ">
                            @if ($item->submenus->isNotEmpty())
                            <button style="padding: 5px 13px;"
                                class="menu-btn group bg-n0 dark:!border-n500  dark:!bg-bg4 {{ $isActive || $submenuActive ? 'active' : '' }}"
                                type="button" onclick="this.nextElementSibling.classList.toggle('submenu-show'); this.classList.toggle('active'); 
                                            this.querySelector('.plus-minus .la-plus').classList.toggle('show'); 
                                            this.querySelector('.plus-minus .la-minus').classList.toggle('show');">
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

                            <ul class="submenu {{ $submenuActive ? 'submenu-show' : 'submenu-hide' }}">
                                @foreach ($item->submenus as $sub)
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
                            <a href="{{ route($item?->route) }}"
                                class="menu-btn border-n30 bg-n0 dark:!border-n500 dark:bg-bg4 flex items-center justify-center gap-2 {{ $isActive ? 'active' : '' }}">
                                <span class=" flex justify-start gap-2 ">
                                    <span class="menu-icon ">
                                        <i class="{{ $item->icon }}"></i>
                                    </span>
                                    <span class="menu-title font-medium" style="font-size: 14px !important ;">{{
                                        $item->title }}</span>

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

                        {{-- ✅ Always add
                        <hr> AFTER HR MANAGEMENT --}}
                        @if ($item->title === 'HR MANAGEMENT')
                        <hr style="margin: 10px 0; border-color: #ccc;">
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>

{{-- ✅ Optional JS: Only one submenu open at a time --}}
<script>
    document.querySelectorAll('.menu-btn').forEach(btn => {
        btn.addEventListener('click', function() {
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
        });
    });
</script>