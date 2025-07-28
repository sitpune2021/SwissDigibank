
<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Navigation -->
<section class="topbar-container z-30">
    <?php echo $__env->make('layout.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layout.sidebar' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</section>

<!-- Main Content -->
<main class="main-content has-sidebar">
    <?php echo $__env->yieldContent('content'); ?>
</main>

<?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\xampp\htdocs\swiss bank live code\resources\views/layout/main.blade.php ENDPATH**/ ?>