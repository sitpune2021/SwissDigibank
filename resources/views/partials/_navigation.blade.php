<section class="topbar-container z-30">
  <nav
    class="navbar-top topbarfull z-20 gap-3 bg-n0 py-3 shadow-sm duration-300 border-b border-n0 dark:border-n700 dark:bg-bg4 xl:py-4 xxxl:py-6"
    id="topbar">
    <div class="topbar-inner flex items-center justify-between">
      <div class="flex grow items-center gap-4 xxl:gap-6">
        <a href="{{ route('dashboard.index1') }}" class="topbar-logo hidden shrink-0">
          <img width="174" height="38" src="../images/logo-with-text.png" alt="logo"
            class="logo-full2 hidden lg:block" />
        </a>
        <button class="flex items-center rounded-s-2xl bg-primary px-0.5 py-3 text-xl text-n0" id="sidebar-toggle-btn">
          <i class="las la-angle-left text-lg"></i>
        </button>
        <!-- Select layout -->
        <div class="topnav-layout">
          <div id="layout-btn"
            class="flex w-full cursor-pointer items-center justify-between gap-2 rounded-[30px] border border-n30 bg-primary/5 px-4 py-1 dark:border-n500 dark:bg-bg3 lg:py-1.5 xxl:px-6 xxl:py-2">
            <span class="flex select-none items-center gap-2">
              <i class="las la-border-all text-3xl text-primary"></i>
              <span id="selected-layout" class="capitalize">Vertical</span>
            </span>
            <i id="drop-arrow" class="las la-angle-down shrink-0 text-lg duration-300"></i>
          </div>
          <ul id="layout"
            class="hide absolute left-0 top-full z-20 w-full origin-top rounded-lg bg-n0 p-2 shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)] duration-300 dark:bg-bg4">
            <li data-layout="vertical"
              class="active block cursor-pointer select-none rounded-md p-2 duration-300 hover:text-primary">
              Vertical
            </li>
            <li data-layout="two-column"
              class="block cursor-pointer select-none rounded-md p-2 duration-300 hover:text-primary">
              Two-Column
            </li>
            <li data-layout="hovered"
              class="block cursor-pointer select-none rounded-md p-2 duration-300 hover:text-primary">
              Hovered
            </li>
            <li data-layout="horizontal"
              class="block cursor-pointer select-none rounded-md p-2 duration-300 hover:text-primary">
              Horizontal
            </li>
            <li data-layout="detached"
              class="block cursor-pointer select-none rounded-md p-2 duration-300 hover:text-primary">
              Detached
            </li>
          </ul>
        </div>

        <!-- Search bar -->
        <form class="topnav-search">
          <input type="text" placeholder="Search"
            class="w-full border-none bg-transparent py-2 focus:border-none focus:shadow-none focus:outline-none md:py-2.5 xxl:py-3 ltr:pl-4 rtl:pr-4" />
          <button class="flex h-8 w-9 items-center justify-center rounded-full bg-primary text-n0">
            <i class="las la-search text-lg"></i>
          </button>
        </form>
      </div>
      <div class="flex items-center gap-3 sm:gap-4 xxl:gap-6">
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
              2
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
                <img src="../images/user-3.png" width="44" height="40" class="shrink-0 rounded-full" alt="img" />
                <div class="text-sm">
                  <div class="flex gap-1">
                    <span class="font-medium">Benjamin</span>
                    <span>Sent a message</span>
                  </div>
                  <span class="text-xs text-n100 dark:text-n50">1 hour ago</span>
                </div>
              </div>
              <div class="flex cursor-pointer gap-2 rounded-md p-2 duration-300 hover:bg-primary/10">
                <img src="../images/user-4.png" width="44" height="40" class="shrink-0 rounded-full" alt="img" />
                <div class="text-sm">
                  <div class="flex gap-1">
                    <span class="font-medium">Benjamin</span>
                    <span>Left a Comment</span>
                  </div>
                  <span class="text-xs text-n100 dark:text-n50">1 hour ago</span>
                </div>
              </div>
              <div class="flex cursor-pointer gap-2 rounded-md p-2 duration-300 hover:bg-primary/10">
                <img src="../images/user-5.png" width="44" height="40" class="shrink-0 rounded-full" alt="img" />
                <div class="text-sm">
                  <div class="flex gap-1">
                    <span class="font-medium">Benjamin</span>
                    <span>Sent a message</span>
                  </div>
                  <span class="text-xs text-n100 dark:text-n50">2 hour ago</span>
                </div>
              </div>
              <div class="flex cursor-pointer gap-2 rounded-md p-2 duration-300 hover:bg-primary/10">
                <img src="../images/user-7.png" width="44" height="40" class="shrink-0 rounded-full" alt="img" />
                <div class="text-sm">
                  <div class="flex gap-1">
                    <span class="font-medium">Samuel</span>
                    <span>Uploaded a file</span>
                  </div>
                  <span class="text-xs text-n100 dark:text-n50">Yesterday</span>
                </div>
              </div>
              <div class="flex cursor-pointer gap-2 rounded-md p-2 duration-300 hover:bg-primary/10">
                <img src="../images/user-7.png" width="44" height="40" class="shrink-0 rounded-full" alt="img" />
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
        <!-- Chat Link -->
        <a href="/private/chat.html"
          class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-n30 bg-primary/5 dark:border-n500 dark:bg-bg3 max-[620px]:hidden md:h-12 md:w-12">
          <i class="lab la-facebook-messenger"></i>
          <span
            class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary text-xs text-n0">
            3
          </span>
        </a>
        <!-- language dropdown -->
        <!-- <div class="relative">
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
        </div> -->
        <!-- Profile dropdown -->
        <div class="relative shrink-0">
          <div id="profile-btn" class="w-10 cursor-pointer md:w-12">
            <img src="../images/user-big-4.png" class="rounded-full" width="48" height="48" alt="profile img" />
          </div>
          <div id="profile"
            class="hide absolute top-full z-20 rounded-md bg-n0 shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)] duration-300 dark:bg-bg4 ltr:right-0 ltr:origin-top-right rtl:left-0 rtl:origin-top-left">
            <div class="flex flex-col items-center border-b p-3 text-center dark:border-n500 lg:p-4">
              <img src="../images/user-big-4.png" width="60" height="60" class="rounded-full" alt="profile img" />
              <h6 class="h6 mt-2">William James</h6>
              <span class="text-sm">james@mail.com</span>
            </div>
            <ul class="flex w-[250px] flex-col p-4">
              <li>
                <a href="../settings/profile.html"
                  class="flex items-center gap-2 rounded-md p-2 duration-300 hover:bg-primary hover:text-n0">
                  <span>
                    <i class="las la-user mt-1 text-xl"></i>
                  </span>
                  Profile
                </a>
              </li>
              <li>
                <a href="../private/chat.html"
                  class="flex items-center gap-2 rounded-md p-2 duration-300 hover:bg-primary hover:text-n0">
                  <span>
                    <i class="las la-envelope mt-1 text-xl"></i>
                  </span>
                  Messages
                </a>
              </li>
              <li>
                <a href="../support/help-center.html"
                  class="flex items-center gap-2 rounded-md p-2 duration-300 hover:bg-primary hover:text-n0">
                  <span>
                    <i class="las la-life-ring mt-1 text-xl"></i>
                  </span>
                  Help
                </a>
              </li>
              <li>
                <a href="../settings/security.html"
                  class="flex items-center gap-2 rounded-md p-2 duration-300 hover:bg-primary hover:text-n0">
                  <span>
                    <i class="las la-cog mt-1 text-xl"></i>
                  </span>
                  Settings
                </a>
              </li>
              <li>
                <a href="../auth/sign-in.html"
                  class="flex items-center gap-2 rounded-md p-2 duration-300 hover:bg-primary hover:text-n0">
                  <span>
                    <i class="las la-sign-out-alt mt-1 text-xl"></i>
                  </span>
                  Logout
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Vertical -->
  <aside id="sidebar" class="sidebar bg-n0 dark:!bg-bg4">
    <div class="sidebar-inner relative">
      <div class="logo-column">
        <div class="logo-container">
          <div class="logo-inner">
            <a href="{{ route('index1') }}" class="logo-wrapper">
              <img src="../images/logo-with-text.png" width="174" height="38" class="logo-full" alt="logo" />
              <img src="../images/logo.png" width="37" height="36" class="logo-icon hidden" alt="logo" />
            </a>
            <img width="141" height="38" class="logo-text hidden" src="../images/logo-text.png" alt="logo text" />
            <button class="sidebar-close-btn xl:hidden" id="sidebar-close-btn">
              <i class="las la-times"></i>
            </button>
          </div>
        </div>
        <div class="menu-container pb-28">
          <div class="menu-wrapper">
            <p class="menu-heading">Navigation</p>
            <ul class="menu-ul">
              <li class="menu-li">
                <button class="menu-btn border-n30 bg-n0 dark:!border-n500 dark:bg-bg4">
                  <span class="flex items-center justify-center gap-2">
                    <span class="menu-icon">
                      <i class="las la-home"></i>
                    </span>
                    <span class="menu-title font-medium">Dashboard</span>
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
                    <a href="{{ route('index1') }}l" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 01</span>
                    </a>
                  </li>
                  <li>
                    <a href="../dashboards/style-02.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 02</span>
                    </a>
                  </li>
                  <li>
                    <a href="../dashboards/style-03.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 03</span>
                    </a>
                  </li>
                  <li>
                    <a href="../dashboards/style-04.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 04</span>
                    </a>
                  </li>
                  <li>
                    <a href="../dashboards/style-05.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 05</span>
                    </a>
                  </li>
                </ul>
              </li>
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
                    <a href="../accounts/bank-account.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Bank Account</span>
                    </a>
                  </li>
                  <li>
                    <a href="../accounts/account-overview.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Account Overview</span>
                    </a>
                  </li>
                  <li>
                    <a href="../accounts/account-details.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Account Details</span>
                    </a>
                  </li>
                  <li>
                    <a href="../accounts/deposit-details.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Deposit Details</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="menu-li">
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
                    <a href="../cards/card-overview.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Card Overview</span>
                    </a>
                  </li>
                  <li>
                    <a href="../cards/card-details.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Card Details</span>
                    </a>
                  </li>
                </ul>
              </li>
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
                    <a href="../transaction/style-01.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 01</span>
                    </a>
                  </li>
                  <li>
                    <a href="../transaction/style-02.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 02</span>
                    </a>
                  </li>
                  <li>
                    <a href="../transaction/style-03.html" class="submenu-link">
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
                    <a href="../payment/payment-overview.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Payment Overview</span>
                    </a>
                  </li>
                  <li>
                    <a href="../payment/providers.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Payment Providers</span>
                    </a>
                  </li>
                  <li>
                    <a href="../payment/exchange.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Exchange</span>
                    </a>
                  </li>
                  <li>
                    <a href="../payment/make-payment.html" class="submenu-link">
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
                    <a href="../private/add-contact.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Add Contact</span>
                    </a>
                  </li>
                  <li>
                    <a href="../private/transfer-overview.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Transfer Overview</span>
                    </a>
                  </li>
                  <li>
                    <a href="../private/make-transfer.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Make Transfer</span>
                    </a>
                  </li>
                  <li>
                    <a href="../private/chat.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Chat</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="menu-li">
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
                    <a href="../invoicing/add-new.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Add New Invoice</span>
                    </a>
                  </li>
                  <li>
                    <a href="../invoicing/style-01.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 01</span>
                    </a>
                  </li>
                  <li>
                    <a href="../invoicing/style-02.html" class="submenu-link">
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
                    <a href="../trading/style-01.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 01</span>
                    </a>
                  </li>
                  <li>
                    <a href="../trading/style-02.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 02</span>
                    </a>
                  </li>
                  <li>
                    <a href="../trading/style-03.html" class="submenu-link">
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
                    <a href="../reports/style-01.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Style 01</span>
                    </a>
                  </li>
                  <li>
                    <a href="../reports/style-02.html" class="submenu-link">
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
                    <a href="../settings/profile.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Profile</span>
                    </a>
                  </li>
                  <li>
                    <a href="../settings/security.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Security</span>
                    </a>
                  </li>
                  <li>
                    <a href="../settings/social-network.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Social Network</span>
                    </a>
                  </li>
                  <li>
                    <a href="../settings/notification.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Notification</span>
                    </a>
                  </li>
                  <li>
                    <a href="../settings/payment-limits.html" class="submenu-link">
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
                    <a href="../auth/sign-up.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Sign Up</span>
                    </a>
                  </li>
                  <li>
                    <a href="../auth/sign-in.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Sign In</span>
                    </a>
                  </li>
                  <li>
                    <a href="../auth/signin-qrcode.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Sign In QR Code</span>
                    </a>
                  </li>
                  <li>
                    <a href="../auth/error.html" class="submenu-link">
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
                    <a href="../support/help-center.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Help Center</span>
                    </a>
                  </li>
                  <li>
                    <a href="../support/privacy-policy.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Privacy Policy</span>
                    </a>
                  </li>
                  <li>
                    <a href="../support/contact-us.html" class="submenu-link">
                      <i class="las la-minus text-xl"></i>
                      <span>Contact Us</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="px-4 xxl:px-6 xxxl:px-8">
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
              <img src="../images/upgrade.png" width="272" height="173" alt="upgrade" />
              <p class="mb-8 mt-6 text-sm">
                Upgrade your account to
                <span class="font-semibold text-primary">PRO</span> for even
                more examples.
              </p>
              <a href="#" class="btn-primary flex w-full justify-center">
                Upgrade Now
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </aside>
</section>
