<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    @vite('resources/css/app.scss')
    <title>Swiss Payment - Digital Banking</title>
</head>

<body class="vertical bg-secondary/5 dark:bg-bg3">
    <!-- Loader -->
    {{-- <div class="loader flex items-center justify-center min-w-screen min-h-screen fixed !z-50 inset-0 bg-n0 dark:bg-bg4">
        <svg viewBox="25 25 50 50">
            <circle r="20" cy="50" cx="50"></circle>
        </svg>
    </div> --}}

    <div class="relative min-h-screen bg-secondary/5 dark:bg-bg3">
        <img src="{{ asset('assets/images/ellipse1.png') }}" class="absolute top-16 md:top-5 ltr:right-10 rtl:left-10"
            alt="ellipse" />
        <img src="{{ asset('assets/images/ellipse2.png') }}"
            class="absolute bottom-6 ltr:left-0 rtl:right-0 ltr:sm:left-32 rtl:sm:right-32" alt="ellipse" />
        <a href="{{ route('index1') }}">
            <img src="{{ asset('assets/images/SBC_Logo.png') }}" alt="logo"
                class="logo-full2 lg:block p-6 lg:p-8 relative z-[2]" />
        </a>
        <div class="flex items-center justify-center mt-7">
            <div class="relative z-[2] max-w-[1416px] mx-auto px-3 pb-10">
                <div
                    class="box xl:p-6 dark:bg-bg4 grid grid-cols-12 gap-4 xxxl:gap-6 items-center shadow-[0px_6px_30px_0px_rgba(0,0,0,0.04)]">
                    <div class="col-span-12 lg:col-span-7">
                        <form action="{{ route('index1') }}" id="signupForm"
                            class="box bg-primary/5 dark:bg-bg3 lg:p-6 xl:p-8 border border-n30 dark:border-n500">
                            <!-- <h3 class="h3 mb-4">Let&apos;s Get Started!</h3> -->
                             <h3 class="h3 mb-4">Sign Up!</h3>
                            <p class="md:mb-6 pb-4 mb-4 md:pb-6 bb-dashed text-sm md:text-base">
                                Please Enter your Email Address to Start your Online Application
                            </p>
                            <div class="grid grid-cols-2 gap-x-4 xxxl:gap-x-6">
                                <div class="col-span-2 md:col-span-1">
                                    <label for="name" class="md:text-lg font-medium block mb-1">
                                        First Name
                                    </label>
                                    <input type="text" name="fname
                                        class="w-full text-sm bg-n0 dark:bg-bg4 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3 mb-2"
                                        placeholder="Enter First Name" id="fname" />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <label for="lname" class="md:text-lg font-medium block mb-1">
                                        Last Name
                                    </label>
                                    <input type="text" name="lname"
                                        class="w-full text-sm bg-n0 dark:bg-bg4 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3 mb-2"
                                        placeholder="Enter Last Name" id="lname" />
                                </div>
                            </div>
                            <div class="pt-4">
                                <label for="email" class="md:text-lg font-medium block mb-2">
                                    Enter Your Email
                                </label>
                                <input type="text" name="email"
                                    class="w-full text-sm bg-n0 dark:bg-bg4 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3 mb-2"
                                    placeholder="Enter Your Email" id="email" />
                            </div>
                            <label for="password" class="md:text-lg font-medium block my-4">
                                Enter Your Password
                            </label>
                            <div class="mb-2">
                                <div id="passwordfield"
                                    class="bg-n0 dark:bg-bg4 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-2.5 relative">
                                    <input type="password" name="password" class="w-11/12 text-sm bg-transparent p-0 border-none"
                                        placeholder="Enter Password" id="password2" />
                                    <span
                                        class="absolute eye-icon ltr:right-5 rtl:left-5 top-1/2 -translate-y-1/2 cursor-pointer"
                                        id="toggleBtn">
                                        <i class="las la-eye" style="display: none;"></i>
                                        <i class="las la-eye-slash"></i>
                                    </span>
                                </div>
                            </div>

                            <p>
                                By clicking submit, you agree to
                                <a class="text-primary" href="#">
                                    Terms of Use
                                </a>
                                ,
                                <a class="text-primary" href="#">
                                    Privacy Policy
                                </a>
                                ,
                                <a class="text-primary" href="#">
                                    E-sign
                                </a>
                                &
                                <a class="text-primary" href="#">
                                    Communication Authorization
                                </a>
                                .
                            </p>
                            <div class="mt-8">
                                <button class="btn-primary px-5">Sign Up</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-span-12 lg:col-span-5 flex justify-center items-center">
                        <img src="{{ asset('assets/images/auth.png') }}" alt="img" width="533" height="560" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
</body>

</html>
