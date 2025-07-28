<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>" type="image/x-icon" />
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.scss'); ?>
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
    <title>Swiss Payment - Digital Banking</title>
</head>

<body class="vertical bg-secondary/5 dark:bg-bg3">
    <!-- Loader -->
    
    <div class="relative min-h-screen bg-secondary/5 dark:bg-bg3">
        <img src="<?php echo e(asset('assets/images/ellipse1.png')); ?>" class="absolute top-16 md:top-5 ltr:right-10 rtl:left-10"
            alt="ellipse" />
        <img src="<?php echo e(asset('assets/images/ellipse1.png')); ?>"
            class="absolute bottom-6 ltr:left-0 rtl:right-0 ltr:sm:left-32 rtl:sm:right-32" alt="ellipse" />
        <a href="<?php echo e(route('index1')); ?>">
            <img src="<?php echo e(asset('assets/images/SBC_Logo.png')); ?>" alt="logo"
                class="logo-full2 lg:block p-6 lg:p-8 relative z-[2]" width="300" />
        </a>
        <!-- <div class="flex items-center justify-center mt-7">
            <div class="relative z-[2] max-w-[1416px] mx-auto px-3 pb-10"> -->
        <div class="relative z-10 flex justify-center items-center min-h-screen">
            <div class="w-full max-w-3xl px-4">
                <div class="box p-3 md:p-4 xl:p-6 grid grid-cols-12 items-center">
                    <form action="<?php echo e(route('log.in')); ?>" method="post" id="loginForm" class="col-span-12 lg:col-span-12">
                        <?php echo csrf_field(); ?>
                        <div class="box bg-primary/5 dark:bg-bg3 lg:p-6 xl:p-8 border border-n30 dark:border-n500">
                            <h3 class="h3 mb-3">Sign In!</h3>
                            <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert1">
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                    style="width: 5px; height: 5px;"></button>
                            </div>
                            <?php endif; ?>

                            <?php if(session('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert1">
                                <?php echo e(session('error')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                    style="width: 5px; height: 5px;"></button>
                            </div>
                            <?php endif; ?>
                            <p class="md:mb-4 md:pb-6 mb-4 pb-4 bb-dashed text-sm md:text-base">
                                Sign in to your account and join us
                            </p>
                            <label for="email" class="md:text-lg font-medium block mb-2">
                                Enter Your Email ID
                            </label>
                            <div class="mb-4">
                                <input type="text" name="email"
                                    class="w-full text-sm bg-n0 dark:bg-bg4 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                    placeholder="Enter Your Email" id="email" />
                            </div>
                            <label for="password" class="md:text-lg font-medium block mb-2">
                                Enter Your Password
                            </label>
                            <div class="col-span-2 md:col-span-1">
                                <div id="passwordfield"
                                    class="bg-n0 dark:bg-bg4 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-2.5 relative">
                                    <input type="password" name="password" class="w-11/12 text-sm bg-transparent p-0 border-none"
                                        placeholder="Enter Password" id="password2" />
                                    <span
                                        class="absolute eye-icon ltr:right-5 rtl:left-5 top-1/2 -translate-y-1/2 cursor-pointer"
                                        id="togglePassword">
                                        <i class="las la-eye" style="display: none;"></i>
                                        <i class="las la-eye-slash"></i>
                                    </span>
                                </div>
                            </div>
                            <a href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#forgotPasswordModal"

                                class="flex justify-end text-primary mt-4">
                                Forgot Password?
                            </a>
                            <!-- <p class="mt-3">
                                Don&apos;t have an account?
                                <a class="text-primary" href="/auth/sign-up.html">
                                    Signup
                                </a>
                            </p> -->
                            <div class="mt-1 flex gap-6">
                                <button type="submit" class="btn-primary px-5">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- <div class="col-span-12 lg:col-span-5">
                        <img src="<?php echo e(asset('assets/images/auth1.png')); ?>" alt="img" width="533" height="560" />
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="<?php echo e(route('reset.password')); ?>" id="forgetForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="w-full text-sm bg-n0 dark:bg-bg4 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" id="email" name="email"
                                placeholder="Enter your registered email">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <div class="bg-n0 dark:bg-bg4 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-2.5 relative">
                                <input type="password" class="w-11/12 text-sm bg-transparent p-0 border-none" id="newPassword" name="password"
                                    placeholder="Enter new password">
                                <span
                                    class="absolute eye-icon ltr:right-5 rtl:left-5 top-1/2 -translate-y-1/2 cursor-pointer"
                                    id="toggleNewPassword">
                                    <i class="las la-eye" style="display: none;"></i>
                                    <i class="las la-eye-slash"></i>
                                </span>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-outline-light border me-2 text-dark"
                            data-bs-dismiss="modal">Cancel</button> -->
                        <button type="button" class="btn-outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-primary px-3">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('forgotPasswordModal');
            const form = document.getElementById('forgetForm');

            // Bootstrap 5 event
            modal.addEventListener('hidden.bs.modal', function() {
                form.reset();
            });
        });
    </script>
    <script>
        const toggleBtn = document.getElementById('toggleNewPassword');
        const passwordInput = document.getElementById('newPassword');
        const eyeOpen = toggleBtn.querySelector('.la-eye');
        const eyeSlash = toggleBtn.querySelector('.la-eye-slash');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            eyeOpen.style.display = isPassword ? 'inline' : 'none';
            eyeSlash.style.display = isPassword ? 'none' : 'inline';
        });
    </script>
    <script>
        const toggleBtn1 = document.getElementById('togglePassword');
        const passwordInput1 = document.getElementById('password2');
        const eyeOpen1 = toggleBtn.querySelector('.la-eye');
        const eyeSlash1 = toggleBtn.querySelector('.la-eye-slash');

        toggleBtn1.addEventListener('click', () => {
            const isPassword = passwordInput1.type === 'password';
            passwordInput1.type = isPassword ? 'text' : 'password';

            eyeOpen1.style.display = isPassword ? 'inline' : 'none';
            eyeSlash1.style.display = isPassword ? 'none' : 'inline';
        });
    </script>
</body>


</html><?php /**PATH C:\xampp\htdocs\swiss bank live code\resources\views/authentication/signin.blade.php ENDPATH**/ ?>