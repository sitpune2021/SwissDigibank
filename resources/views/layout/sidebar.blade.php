@php
    use App\Models\Menu;
    $menuItems = Menu::with('submenus')->orderBy('id')->get();
@endphp

<aside id="sidebar" class="sidebar bg-n0 dark:!bg-bg4">
    <div class="sidebar-inner relative">
        <div class="logo-column">
            <div class="logo-container">
                <div class="logo-inner">
                    <a href="{{ route('index1') }}" class="logo-wrapper">
                        <img src="{{ asset('assets/images/SBC_Logo.png') }}" width="174" height="38"
                            class="logo-full" alt="logo" />
                        <img src="{{ asset('assets/images/SBC_Logo.png') }}" width="37" height="36"
                            class="logo-icon hidden" alt="logo" />
                    </a>
                    <img width="141" height="38" class="logo-text hidden"
                        src="{{ asset('assets/images/SBC_Logo.png') }}" alt="logo text" />
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
                                $isActive = request()->routeIs($item->route ?? '');
                                $submenuActive = $item->submenus->contains(function ($sub) {
                                    return request()->routeIs($sub->route);
                                });
                            @endphp

                            <li class="menu-li {{ $isActive || $submenuActive ? 'active' : '' }}">
                                @if ($item->submenus->isNotEmpty())
                                    <button
                                        class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4 {{ $isActive || $submenuActive ? 'active' : '' }}"
                                        type="button"
                                        onclick="this.nextElementSibling.classList.toggle('submenu-show'); this.classList.toggle('active'); 
                                            this.querySelector('.plus-minus .la-plus').classList.toggle('hidden'); 
                                            this.querySelector('.plus-minus .la-minus').classList.toggle('hidden');">
                                        <span class="flex items-center justify-center gap-2">
                                            <span class="menu-icon">
                                                <i class="{{ $item->icon }}"></i>
                                            </span>
                                            <span class="menu-title font-medium">{{ $item->title }}</span>
                                        </span>
                                        <span class="plus-minus">
                                            <i class="las la-plus text-xl {{ $submenuActive ? 'hidden' : '' }}"></i>
                                            <i class="las la-minus text-xl {{ $submenuActive ? '' : 'hidden' }}"></i>
                                        </span>
                                    </button>
                                    <ul class="submenu {{ $submenuActive ? 'submenu-show' : 'submenu-hide' }}">
                                        @foreach ($item->submenus as $sub)
                                            <li>
                                                <a href="{{ route($sub->route) }}"
                                                    class="submenu-link {{ request()->routeIs($sub->route) ? 'text-primary' : '' }}">
                                                    <i class="las la-minus text-xl"></i>
                                                    <span>{{ $sub->title }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <a href="{{ route($item->route) }}"
                                        class="menu-btn border-n30 bg-n0 dark:!border-n500 dark:bg-bg4 flex items-center justify-center gap-2 {{ $isActive ? 'active' : '' }}">
                                        <span class="flex items-center justify-center gap-2">
                                            <span class="menu-icon">
                                                <i class="{{ $item->icon }}"></i>
                                            </span>
                                            <span class="menu-title font-medium">{{ $item->title }}</span>
                                        </span>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>
