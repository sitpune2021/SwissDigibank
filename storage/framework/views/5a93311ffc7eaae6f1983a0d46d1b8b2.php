<footer class="footer bg-n0 dark:bg-bg4">
    <div class="flex flex-col items-center justify-center gap-3 px-4 py-5 lg:flex-row lg:justify-between xxl:px-8">
        <p class="text-sm max-md:w-full max-md:text-center lg:text-base">
            Copyright @ <span id="current-year"></span>
            <a class="text-primary" href="<?php echo e(route('index1')); ?>">SIT SOLUTIONS PVT LTD </a>
            <!-- . Designed By
            <a href="#" class="text-secondary"> SIT SOLUTIONS PVT LTD </a> -->
        </p>
        <div class="justify-center max-md:flex max-md:w-full"></div>
        <!-- <ul class="flex gap-2 xxxl:gap-3">
            <li>
                <a href="#" aria-label="social link"
                    class="inline-flex rounded-full border border-primary p-1 text-primary duration-300 hover:bg-primary hover:text-n0 md:p-1.5 xxxl:p-2">
                    <i class="lab la-facebook-f"></i>
                </a>
            </li>
            <li>
                <a href="#" aria-label="social link"
                    class="inline-flex rounded-full border border-primary p-1 text-primary duration-300 hover:bg-primary hover:text-n0 md:p-1.5 xxxl:p-2">
                    <i class="lab la-twitter"></i>
                </a>
            </li>
            <li>
                <a href="#" aria-label="social link"
                    class="inline-flex rounded-full border border-primary p-1 text-primary duration-300 hover:bg-primary hover:text-n0 md:p-1.5 xxxl:p-2">
                    <i class="lab la-skype"></i>
                </a>
            </li>
            <li>
                <a href="#" aria-label="social link"
                    class="inline-flex rounded-full border border-primary p-1 text-primary duration-300 hover:bg-primary hover:text-n0 md:p-1.5 xxxl:p-2">
                    <i class="lab la-instagram"></i>
                </a>
            </li>
            <li>
                <a href="#" aria-label="social link"
                    class="inline-flex rounded-full border border-primary p-1 text-primary duration-300 hover:bg-primary hover:text-n0 md:p-1.5 xxxl:p-2">
                    <i class="lab la-linkedin-in"></i>
                </a>
            </li>
        </ul> -->

        <ul class="flex gap-3 text-sm max-lg:w-full max-lg:justify-center lg:gap-4 lg:text-base">
            <li>
                <a href="<?php echo e(route('support.privacy.policy')); ?>">Privacy Policy</a>
            </li>
            <li>
                <a href="<?php echo e(route('support.help.center')); ?>">Terms of condition</a>
            </li>
        </ul>
    </div>
</footer>

<?php echo $__env->make('layout.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('page-modal'); ?>

<!-- <div id="customizer-container" class="z-[60] w-full"></div> -->

<?php echo $__env->yieldPushContent('page-js'); ?>

<?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\swiss bank live code\resources\views/layout/footer.blade.php ENDPATH**/ ?>