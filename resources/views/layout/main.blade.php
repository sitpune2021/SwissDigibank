
@include('layout.header')

<!-- Navigation -->
<section class="topbar-container z-30">
    @include('layout.nav')
    @include('layout.sidebar')
</section>

<!-- Main Content -->
<main class="main-content has-sidebar">
    @yield('content')
</main>

@include('layout.footer')
