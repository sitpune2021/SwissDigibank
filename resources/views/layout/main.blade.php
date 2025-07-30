@include('layout.header')
@stack('style')
<section class="topbar-container z-30">
    @include('layout.nav')
    @include('layout.sidebar')
</section>
<main class="main-content has-sidebar">
    <div class="main-inner">
        @include('layout.breadcrub')
        @yield('content')
    </div>
</main>
@stack('script')
@include('layout.footer')
