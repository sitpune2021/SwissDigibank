<!-- Vertical -->
<aside id="sidebar" class="sidebar bg-n0 dark:!bg-bg4">
    <div class="sidebar-inner relative">
        <div class="logo-column">
            <div class="logo-container">
                <div class="logo-inner">
                    <a href="{{ route('index1') }}" class="logo-wrapper">
                        <img src="{{ asset('assets/images/logo-with-text.png') }}" width="174" height="38"
                            class="logo-full" alt="logo" />
                        <img src="{{ asset('assets/images/logo.png') }}" width="37" height="36"
                            class="logo-icon hidden" alt="logo" />
                    </a>
                    <img width="141" height="38" class="logo-text hidden"
                        src="{{ asset('assets/images/logo-text.png') }}" alt="logo text" />
                    <button class="sidebar-close-btn xl:hidden" id="sidebar-close-btn">
                        <i class="las la-times"></i>
                    </button>
                </div>
            </div>
            <div class="menu-container pb-28">
                <div class="menu-wrapper">
                    <!-- <p class="menu-heading">Navigation</p> -->
                    <ul class="menu-ul">
                        <li class="menu-li" {{ request()->routeIs('index1') ? 'active' : '' }}>
                            <!-- <button class="menu-btn border-n30 bg-n0 dark:!border-n500 dark:bg-bg4"> -->
                            <a href="{{ route('index1') }}" class="menu-btn border-n30 bg-n0 dark:!border-n500 dark:bg-bg4 flex items-center justify-center gap-2">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-home"></i>
                                    </span>
                                    <span class="menu-title font-medium">Dashboard</span>
                                </span>
                                <!-- <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span> -->
                                <!-- </button> -->
                            </a>
                            <ul class="submenu-hide submenu" style="display: none;">
                                <!-- <li>
                                    <a href="{{ route('index1') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 01</span>
                                    </a>
                                </li> -->
                                <!-- <li>
                                    <a href="{{ route('dashboard.index2') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 02</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard.index3') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 03</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard.index4') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 04</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard.index5') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 05</span>
                                    </a>
                                </li> -->
                            </ul>
                        </li>

                        <!-- Roles -->
                        <!-- <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-piggy-bank"></i>
                                    </span>
                                    <span class="menu-title font-medium">Roles</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Add Roles</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('accounts.account.overview') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Manage Roles</span>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        <!-- Groups -->
                        <!-- <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-piggy-bank"></i>
                                    </span>
                                    <span class="menu-title font-medium">Groups</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('accounts.bank.account') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Add Groups</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('accounts.account.overview') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Manage Groups</span>
                                    </a>
                                </li>
                            </ul>
                        </li> -->

                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-piggy-bank"></i>
                                    </span>
                                    <span class="menu-title font-medium">Company</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('company.view') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('manage.branch')}}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Branches</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('ManagePromotor')}}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Promoters</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('manage.shareholding')}}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Promotor & Share Holdings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Directors</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-user"></i>
                                    </span>
                                    <span class="menu-title font-medium">User Management</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{route('CreateRole')}}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Permissions / Roles</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('ManageUser')}}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Users</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-user"></i>
                                    </span>
                                    <span class="menu-title font-medium">HR Management</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{route('ManageEmployee')}}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Employees</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Attendance</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Salary Disbursment</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-piggy-bank"></i>
                                    </span>
                                    <span class="menu-title font-medium">Branch</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                            </ul>
                        </li> -->

                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-piggy-bank"></i>
                                    </span>
                                    <span class="menu-title font-medium">Accounts</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('accounts.bank.account') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Bank Account</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('accounts.account.overview') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Account Overview</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('accounts.account.details') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Account Details</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('accounts.deposit.detail') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Deposit Details</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-credit-card"></i>
                                    </span>
                                    <span class="menu-title font-medium">Cards</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('cards.overview') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Card Overview</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('cards.details') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Card Details</span>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-exchange-alt"></i>
                                    </span>
                                    <span class="menu-title font-medium">Transaction</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('transaction.style1') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 01</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transaction.style2') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 02</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transaction.style3') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 03</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-wallet"></i>
                                    </span>
                                    <span class="menu-title font-medium">Payment</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('payment.overview') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Payment Overview</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('payment.providers') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Payment Providers</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('payment.exchange') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Exchange</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('payment.make.payment') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Make a Payment</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-coins"></i>
                                    </span>
                                    <span class="menu-title font-medium">Private Transfers</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('transfer.add.contact') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Add Contact</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transfer.overview') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Transfer Overview</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transfer.make.transfer') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Make Transfer</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transfer.chat') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Chat</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-file-invoice"></i>
                                    </span>
                                    <span class="menu-title font-medium">Invoicing</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('invoicing.add.invoicing') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Add New Invoice</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('invoicing.style1') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 01</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('invoicing.style2') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 02</span>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        <!-- <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-chart-bar"></i>
                                    </span>
                                    <span class="menu-title font-medium">Trading</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('trading.style1') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 01</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('trading.style2') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 02</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('trading.style3') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 03</span>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-chart-pie"></i>
                                    </span>
                                    <span class="menu-title font-medium">Reports</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('reports.style1') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 01</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('reports.style2') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Style 02</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-cog"></i>
                                    </span>
                                    <span class="menu-title font-medium">Settings</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('settings.profile') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('settings.security') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Security</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('settings.social.network') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Social Network</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('settings.notification') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Notification</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('settings.payment.limit') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Payment Limits</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-user-circle"></i>
                                    </span>
                                    <span class="menu-title font-medium">Authentication</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('auth.sign.up') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Sign Up</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('log.in') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Sign In</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('auth.sign.in.qrcode') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Sign In QR Code</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('auth.error') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Error Page</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-li">
                            <button class="menu-btn group bg-n0 dark:!border-n500 dark:!bg-bg4">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="menu-icon">
                                        <i class="las la-handshake"></i>
                                    </span>
                                    <span class="menu-title font-medium">Support</span>
                                </span>
                                <span class="plus-minus">
                                    <i class="las la-plus text-xl"></i>
                                    <i class="las la-minus text-xl"></i>
                                </span>
                                <span class="chevron-down hidden">
                                    <i class="las la-angle-down text-base"></i>
                                </span>
                            </button>
                            <ul class="submenu-hide submenu">
                                <li>
                                    <a href="{{ route('support.help.center') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Help Center</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('support.privacy.policy') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Privacy Policy</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('support.contact.us') }}" class="submenu-link">
                                        <i class="las la-minus text-xl"></i>
                                        <span>Contact Us</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- <li class="menu-li">
                            <a href="{{route('components')}}" class="menu-link">
                                <i class="las la-puzzle-piece"></i>
                                <span>Components</span>
                            </a>
                        </li> -->
                    </ul>
                </div>
                <!-- <div class="px-4 xxl:px-6 xxxl:px-8">
                    <div class="balance-part">
                        <p class="border-t-2 border-dashed border-primary/20 py-4 text-xs font-semibold lg:py-6">
                            Balance
                        </p>
                        <ul>
                            <li>
                                <button
                                    class="group flex w-full items-center justify-between rounded-xl px-4 py-2.5 lg:py-3 xxxl:px-6">
                                    <span class="flex items-center gap-2">
                                        <span class="-mb-1 self-center text-primary">
                                            <i class="las la-dollar-sign"></i>
                                        </span>
                                        <span class="font-medium">33,215.00 USD</span>
                                    </span>
                                </button>
                                <button
                                    class="group flex w-full items-center justify-between rounded-xl px-4 py-2.5 lg:py-3 xxxl:px-6">
                                    <span class="flex items-center gap-2">
                                        <span class="-mb-1 self-center text-primary">
                                            <i class="las la-euro-sign"></i>
                                        </span>
                                        <span class="font-medium">15,254.32 EUR</span>
                                    </span>
                                </button>
                                <button
                                    class="group flex w-full items-center justify-between rounded-xl px-4 py-2.5 lg:py-3 xxxl:px-6">
                                    <span class="flex items-center gap-2">
                                        <span class="-mb-1 self-center text-primary">
                                            <i class="las la-pound-sign"></i>
                                        </span>
                                        <span class="font-medium">7,029.14 GBP</span>
                                    </span>
                                </button>
                                <button
                                    class="group flex w-full items-center justify-between rounded-xl px-4 py-2.5 lg:py-3 xxxl:px-6">
                                    <span class="flex items-center gap-2">
                                        <span class="-mb-1 self-center text-primary">
                                            <i class="las la-plus-circle"></i>
                                        </span>
                                        <span class="font-medium">Add More Balance</span>
                                    </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="upgrade-part">
                        <img src="{{ asset('assets/images/upgrade.png') }}" width="272" height="173"
                            alt="upgrade" />
                        <p class="mb-8 mt-6 text-sm">
                            Upgrade your account to
                            <span class="font-semibold text-primary">PRO</span> for even
                            more examples.
                        </p>
                        <a href="#" class="btn-primary flex w-full justify-center">
                            Upgrade Now
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</aside>