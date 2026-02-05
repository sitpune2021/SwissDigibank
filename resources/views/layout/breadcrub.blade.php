<div class="flex flex-wrap items-center justify-between gap-4 mb-4 lg:mb-6">
    <h4 class="text-lg uppercase">@yield('page-title', '')</h4>
     @hasSection('action-button')
        @yield('action-button')
    @endif
</div>
