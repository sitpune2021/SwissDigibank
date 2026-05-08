@include('layout.header')

@stack('style')

<section class="topbar-container z-30">
    @include('layout.nav')
    @include('layout.sidebar')
</section>

<main class="main-content has-sidebar">
    <div class="main-inner">
        @hasSection('page-title')
            @include('layout.breadcrub')
        @endif
        @yield('content')
    </div>
</main>

@include('layout.footer')

<script>
document.addEventListener("DOMContentLoaded", function () 
{

    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("sidebar-toggle-btn");
    const overlay = document.getElementById("sidebarOverlay");
    const mainContent = document.querySelector(".main-content");

    // =========================
    // DESKTOP STATE
    // =========================
    let sidebarClosed = false;

    // =========================
    // TOGGLE BUTTON
    // =========================
    toggleBtn.addEventListener("click", function (e) {

        e.preventDefault();
        e.stopPropagation();

        // =========================
        // MOBILE
        // =========================
        if (window.innerWidth <= 991) {

            sidebar.classList.toggle("show");
            overlay.classList.toggle("show");

            return;
        }

        // =========================
        // DESKTOP
        // =========================
        sidebarClosed = !sidebarClosed;

        if (sidebarClosed) {

            sidebar.classList.add("hide-sidebar");
            mainContent.classList.add("full");

        } else {

            sidebar.classList.remove("hide-sidebar");
            mainContent.classList.remove("full");
        }

    });

    // =========================
// BLOCK TEMPLATE AUTO CLOSE
// =========================
document.addEventListener("click", function () {

    // desktop only
    if (window.innerWidth > 991) {

        setTimeout(() => {

            if (sidebarClosed) {

                sidebar.classList.add("hide-sidebar");
                mainContent.classList.add("full");

            } else {

                sidebar.classList.remove("hide-sidebar");
                mainContent.classList.remove("full");
            }

        }, 0);
    }

}, true);
    // =========================
    // MOBILE OVERLAY CLOSE
    // =========================
    overlay.addEventListener("click", function () {

        if (window.innerWidth <= 991) {

            sidebar.classList.remove("show");
            overlay.classList.remove("show");
        }

    });

});
</script>

@stack('script')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

