<div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
    <h4 class="h3 capitalize">@yield('page-title', 'Dashboard')</h4>
     @hasSection('action-button')
        @yield('action-button')
    @endif
</div>
