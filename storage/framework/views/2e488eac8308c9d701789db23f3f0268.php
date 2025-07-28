<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>" type="image/x-icon" />
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.scss'); ?>
    <title>Bankhub - HTML Tailwindcss Fintech and Banking Dashboard</title>
</head>

<body class="vertical bg-secondary/5 dark:bg-bg3">
    <div class="flex items-center justify-center py-10 md:py-16 lg:py-20 px-3">
        <div class="flex flex-col items-center justify-center text-center max-w-[640px] mx-auto">
            <img src="<?php echo e(asset('assets/images/system-error.png')); ?>" alt="confirm illustration"
                class="mb-10 lg:mb-14" />
            <h2 class="h2 mb-4 lg:mb-6">Oops... Something went wrong</h2>
            <p class="mb-6 md:mb-8 lg:mb-10">
                An error has occurred. If the problem persists, please contact a
                system administrator or try again later.
            </p>
            <a href="<?php echo e(route('index1')); ?>" class="btn-primary">
                Back to Home
            </a>
        </div>
    </div>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\authentication\error.blade.php ENDPATH**/ ?>