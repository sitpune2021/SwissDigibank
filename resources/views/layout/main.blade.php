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
@stack('script')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

