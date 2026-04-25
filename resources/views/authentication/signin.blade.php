<!DOCTYPE html>
<html dir="ltr">

<head>
    
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    @vite('resources/css/app.scss')
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <title>Swiss Payment - Digital Banking</title>

    <style>
        html,
        body {
            overflow-x: auto;
            /* horizontal scroll allowed */
            overflow-y: hidden;
            /* vertical scroll disabled */
        }
    </style>

</head>

    <body class="vertical bg-secondary/5 dark:bg-bg3">
        
        <div class="relative min-h-screen bg-secondary/5 dark:bg-bg3">
            
            <img src="{{ asset('assets/images/ellipse1.png') }}" class="absolute top-16 md:top-5 ltr:right-10 rtl:left-10"
                alt="ellipse" />
            <img src="{{ asset('assets/images/ellipse1.png') }}"
                class="absolute bottom-6 ltr:left-0 rtl:right-0 ltr:sm:left-32 rtl:sm:right-32" alt="ellipse" />
            <a href="{{ route('index1') }}">
                <img src="{{ asset('assets/images/SBC_Logo.png') }}" alt="logo"
                    class="logo-full2 lg:block p-6 lg:p-8 relative z-[2]" width="300" style="top: 10px;" />
            </a>
            
            <div class="relative z-10 flex justify-center items-center min-h-screen" style="top: -120px; left: 30px;">
                
                <div class="w-full max-w-3xl px-4">
                    @if (session('session_expired'))
                    <div class="w-full alert alert-warning" id="sessionAlert">
                        {{ session('session_expired') }}
                    </div>
                    @endif

                    <div class="box p-3 md:p-4 xl:p-6 grid grid-cols-12 items-center">
                        
                        <form action="{{ route('log.in') }}" method="post" id="loginForm" class="col-span-12 lg:col-span-12">
                            @csrf

                            <div class="box bg-primary/5 dark:bg-bg3 lg:p-6 xl:p-8 border border-n30 dark:border-n500">
                                
                                <!-- <h3 class="h3 mb-3">Sign In!</h3> -->
                                <h3 class="h3 mb-3">Secure Login</h3>
                
                                @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                        style="width: 5px; height: 5px;"></button>
                                </div>
                                @endif

                                @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                        style="width: 5px; height: 5px;"></button>
                                </div>
                                @endif

                                <p class="md:mb-4 md:pb-6 mb-4 pb-4 bb-dashed text-sm md:text-base">
                                    Access your account safely and manage your transactions
                                </p>

                                <label for="email" class="md:text-lg font-medium block mb-2">
                                    Enter Your Email ID
                                </label>

                                <div class="mb-4">
                                   <input type="text" name="login"
                                    class="w-full rounded-xl border border-gray-300 
                                        px-4 py-3 text-sm 
                                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                        outline-none transition"
                                    placeholder="Enter your email or mobile" />
                                </div>                           

                                <label class="md:text-lg font-medium block mb-2">
                                    Enter Your Password
                                </label>

                                <div class="relative">
                                    <input type="password" name="password" id="passwordField"
                                        class="w-full rounded-xl border border-gray-300 
                                            px-4 pr-12 py-3 text-sm
                                            focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                            outline-none"
                                        placeholder="Enter your password" />

                                    <span id="togglePassword" style="left: 595px; top: 30px;"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500 z-10">
                                        <i class="las la-eye-slash"></i>
                                    </span>
                                </div><br>
                                                             
                                <div class="mt-1 flex gap-6">
                                    <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 
                                            text-white py-3 rounded-xl 
                                            font-medium transition duration-200 shadow-md">
                                        Login 
                                    </button>
                                </div>

                                <a href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#forgotPasswordModal"
                                    class="flex justify-end text-primary mt-4">
                                    Forgot Password?
                                </a>

                            </div>

                        </form>

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

                    <form method="POST" action="{{route('reset.password')}}" id="forgetForm">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="login" class="form-label">Email Address</label>
                                <input type="text" class="w-full text-sm bg-n0 dark:bg-bg4 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" id="forgotLoginInput" name="login"
                                    placeholder="Enter your registered email">
                                @error('login')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
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
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-outline" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-primary px-3">Reset Password</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // --- Login Input ---
                const loginInput = document.getElementById('loginInput');
                const forgotLoginInput = document.getElementById('forgotLoginInput');

                // --- Forgot Password Modal Reset ---
                const modal = document.getElementById('forgotPasswordModal');
                const form = document.getElementById('forgetForm');

                if (modal && form) {
                    modal.addEventListener('hidden.bs.modal', function() {
                        form.reset();
                    });
                }

                // --- Toggle Password for Main Login ---
                const toggleBtn1 = document.getElementById('togglePassword');
                const passwordInput1 = document.getElementById('password2');
                if (toggleBtn1 && passwordInput1) {
                    const eyeOpen1 = toggleBtn1.querySelector('.la-eye');
                    const eyeSlash1 = toggleBtn1.querySelector('.la-eye-slash');

                    toggleBtn1.addEventListener('click', () => {
                        const isPassword = passwordInput1.type === 'password';
                        passwordInput1.type = isPassword ? 'text' : 'password';
                        if (eyeOpen1) eyeOpen1.style.display = isPassword ? 'inline' : 'none';
                        if (eyeSlash1) eyeSlash1.style.display = isPassword ? 'none' : 'inline';
                    });
                }

                // --- Toggle Password for Forgot Password Modal ---
                const toggleBtn = document.getElementById('toggleNewPassword');
                const passwordInput = document.getElementById('newPassword');
                if (toggleBtn && passwordInput) {
                    const eyeOpen = toggleBtn.querySelector('.la-eye');
                    const eyeSlash = toggleBtn.querySelector('.la-eye-slash');

                    toggleBtn.addEventListener('click', () => {
                        const isPassword = passwordInput.type === 'password';
                        passwordInput.type = isPassword ? 'text' : 'password';
                        if (eyeOpen) eyeOpen.style.display = isPassword ? 'inline' : 'none';
                        if (eyeSlash) eyeSlash.style.display = isPassword ? 'none' : 'inline';
                    });
                }

                // --- Optional: Form validation on submit ---
                const loginForm = document.getElementById('loginForm');
                if (loginForm && loginInput) {
                    loginForm.addEventListener('submit', function(e) {
                        const value = loginInput.value.trim();
                        if (!value) {
                            alert('Email or mobile is required');
                            e.preventDefault();
                            return false;
                        }
                    });
                }

            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const toggle = document.getElementById("togglePassword");
                const input = document.getElementById("passwordField");

                toggle.addEventListener("click", function () {
                    if (input.type === "password") {
                        input.type = "text";
                        this.innerHTML = '<i class="las la-eye"></i>';
                    } else {
                        input.type = "password";
                        this.innerHTML = '<i class="las la-eye-slash"></i>';
                    }
                });
            });
        </script>

        <!-- 10 sec. massage -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                // Success Alert Auto Hide
                const successAlert = document.getElementById("successAlert");
                if (successAlert) {
                    setTimeout(() => {
                        successAlert.classList.remove("show");
                        successAlert.classList.add("fade");
                        successAlert.style.display = "none";
                    }, 10000); // 10 seconds
                }

                // Error Alert Auto Hide
                const errorAlert = document.getElementById("errorAlert");
                if (errorAlert) {
                    setTimeout(() => {
                        errorAlert.classList.remove("show");
                        errorAlert.classList.add("fade");
                        errorAlert.style.display = "none";
                    }, 10000);
                }

            });
        </script>

        <!-- 10 sec. logout massage -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                // Success Alert
                const successAlert = document.getElementById("successAlert");
                if (successAlert) {
                    setTimeout(() => {
                        successAlert.style.display = "none";
                    }, 10000);
                }

                // Error Alert
                const errorAlert = document.getElementById("errorAlert");
                if (errorAlert) {
                    setTimeout(() => {
                        errorAlert.style.display = "none";
                    }, 10000);
                }

                // 🔥 Session Expired Alert (YE MISSING THA)
                const sessionAlert = document.getElementById("sessionAlert");
                if (sessionAlert) {
                    setTimeout(() => {
                        sessionAlert.style.display = "none";
                    }, 10000);
                }

            });
        </script>

    </body>

</html>