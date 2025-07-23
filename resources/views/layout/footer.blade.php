<footer class="footer bg-n0 dark:bg-bg4">
    <div class="flex flex-col items-center justify-center gap-3 px-4 py-5 lg:flex-row lg:justify-between xxl:px-8">
        <p class="text-sm max-md:w-full max-md:text-center lg:text-base">
            Copyright @ <span id="current-year"></span>
            <a class="text-primary" href="{{ route('index1') }}">SIT SOLUTIONS PVT LTD </a>
        </p>
        <div class="justify-center max-md:flex max-md:w-full"></div>
    </div>
</footer>

@include('layout.modal')

@yield('page-modal')

<!-- <div id="customizer-container" class="z-[60] w-full"></div> -->

@stack('page-js')

@vite(['resources/js/app.js'])

</body>

</html>
