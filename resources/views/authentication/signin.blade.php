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

        <style>
            .otp-modal {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.7);

                justify-content: center;
                align-items: center;
            }

            .otp-box {
                background: white;
                padding: 25px;
                border-radius: 12px;
                width: 320px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            }
        </style>

    </head>

   <body class="vertical">

        <div class="relative min-h-screen w-full overflow-hidden">

            <!-- BACKGROUND -->
            <div class="absolute inset-0"
                style="
                    background-image: url('{{ asset('assets/images/sbc_new_logo3.png') }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                ">
            </div>

            <!-- DARK OVERLAY -->
            <div class="absolute inset-0 bg-black/70"></div>

            <!-- CONTENT -->
            <div class="relative z-10 flex justify-center items-center min-h-screen px-4">

                <!-- WIDTH -->
                <div class="w-[270px] sm:w-[300px]">
                    
                    <form id="loginForm">
                        @csrf

                        <!-- 🔥 CARD -->
                        <div class="
                            relative
                            bg-white/10
                            backdrop-blur-3xl
                            border border-white/20
                            rounded-2xl
                            px-5 py-6
                            shadow-[0_20px_60px_rgba(0,0,0,0.7)]
                            transition-all duration-300" 
                            style="width: 500px;">

                            <!-- TITLE -->
                            <h3 class="text-white text-xl font-semibold text-center mb-5 tracking-wide flex items-center justify-center gap-2">
                                <i class="las la-lock"></i>Secure Login
                            </h3>

                            <!-- EMAIL -->
                            <div class="mb-4">
                                <input type="text" name="login"
                                    class="w-full px-3 py-2.5 rounded-lg 
                                        bg-white/90 text-black text-sm outline-none
                                        focus:ring-2 focus:ring-cyan-400 
                                        transition duration-200 shadow-sm"
                                    placeholder="Email / Mobile" required>
                            </div>

                            <!-- PASSWORD -->
                            <div class="relative mb-5">
                                <input type="password" name="password" id="password"
                                    class="w-full px-3 pr-9 py-2.5 rounded-lg 
                                        bg-white/90 text-black text-sm outline-none
                                        focus:ring-2 focus:ring-cyan-400 
                                        transition duration-200 shadow-sm"
                                    placeholder="Password" required>

                                <!-- TOGGLE -->
                                <span id="toggle" style="top: 21px;"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-gray-600">
                                    <i class="las la-eye-slash"></i>
                                </span>
                            </div>

                            <!-- BUTTON -->
                            <button type="button" onclick="loginUser()"
                                class="w-full bg-gradient-to-r from-teal-400 to-cyan-500 
                                    hover:from-teal-500 hover:to-cyan-600
                                    text-white py-2.5 rounded-lg text-sm font-medium 
                                    shadow-md hover:shadow-lg transition duration-300" style="background-color: cornflowerblue;">
                                Login
                            </button>

                            <!-- FORGOT -->
                            <div class="text-center mt-4">
                                <a href="#" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#forgotPasswordModal"
                                    class="text-cyan-300 text-xs hover:text-cyan-200 transition" style="color: aliceblue;">
                                    <b>Forgot Password?</b>
                                </a>
                            </div>

                        </div>

                    </form>

                    <!-- OTP POPUP -->
                    <div id="otpModal"  class="otp-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#00000080; justify-content:center; align-items:center;">
                        <div style="background:white; padding:20px; border-radius:10px; width:300px;">
                            <h4>Enter OTP</h4>

                            <input type="text" id="otpInput" class="form-control mb-2" placeholder="Enter OTP">

                            <button onclick="verifyOtp()" class="btn btn-primary w-100 mb-2">Verify OTP</button>

                            <!-- TIMER -->
                            <p id="timerText" style="font-size:13px; color:gray;">
                                Resend OTP in <span id="countdown">30</span> sec
                            </p>

                            <!-- RESEND BUTTON -->
                            <button id="resendBtn" onclick="resendOtp()" 
                                class="btn btn-secondary w-100" disabled>
                                Resend OTP
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

            <!-- 🔥 FORGOT PASSWORD MODAL -->
            <div class="modal fade" id="forgotPasswordModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-3xl border-0 shadow-lg">

                        <div class="modal-header border-0">
                            <h5 class="modal-title">Reset Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ route('reset.password') }}" method="POST">
                            @csrf

                            <div class="modal-body">

                                <!-- EMAIL -->
                                <div class="mb-3">
                                    <input type="text" name="login"
                                        class="w-full px-3 py-2 rounded-lg border outline-none"
                                        placeholder="Enter your email" required>
                                </div>

                                <!-- NEW PASSWORD -->
                                <div class="mb-3">
                                    <input type="password" name="password"
                                        class="w-full px-3 py-2 rounded-lg border outline-none"
                                        placeholder="New Password" required>
                                </div>

                            </div>

                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    Reset
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        <!-- PASSWORD TOGGLE -->
        <script>
        const toggle = document.getElementById("toggle");
        const password = document.getElementById("password");

        toggle.addEventListener("click", function () {
            if (password.type === "password") {
                password.type = "text";
                this.innerHTML = '<i class="las la-eye"></i>';
            } else {
                password.type = "password";
                this.innerHTML = '<i class="las la-eye-slash"></i>';
            }
        });
        </script>

        @if(session('otp_login'))
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            let modal = document.getElementById('otpModal');
            modal.style.display = 'flex'; // 🔥 IMPORTANT
        });
        </script>
        @endif

        <script>
        function verifyOtp() {

            let otp = document.getElementById('otpInput').value;
            let userId = window.userId;

            fetch("{{ url('/verify-login-otp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    user_id: userId,
                    otp: otp
                })
            })
            .then(res => res.json())
            .then(data => {

                if (data.status) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }

            });
        }
        </script>

        <script>
            
            let timeLeft = 0;
            let timer;

            function startTimer(seconds) {

                clearInterval(timer); // 🔥 old timer stop

                timeLeft = seconds;

                document.getElementById("resendBtn").disabled = true;

                document.getElementById("timerText").innerHTML =
                    `Resend OTP in <span id="countdown">${timeLeft}</span> sec`;

                timer = setInterval(() => {

                    timeLeft--;
                    document.getElementById("countdown").innerText = timeLeft;

                    if (timeLeft <= 0) {
                        clearInterval(timer);

                        document.getElementById("resendBtn").disabled = false;
                        document.getElementById("timerText").innerText = "You can resend OTP now";

                        // 🔥 INPUT CLEAR
                        document.getElementById("otpInput").value = "";

                        alert("OTP expired, please resend");
                    }

                }, 1000);
            }
          
        </script>

        <script>
        function loginUser() {

            let login = document.querySelector('input[name="login"]').value;
            let password = document.querySelector('input[name="password"]').value;

            fetch("{{ route('log.in') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    login: login,
                    password: password
                })
            })
            .then(res => res.json())
            .then(data => {

                if (data.status) {

                    // 🔥 USER ID STORE
                    window.userId = data.user_id;

                    // 🔥 SHOW POPUP
                    document.getElementById('otpModal').style.display = 'flex';

                    startTimer(data.expires_in);

                } else {
                    alert(data.message || 'Login failed');
                }

            });
        }
        </script>

        <script>
            function resendOtp() {

                fetch("{{ url('/resend-otp') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        user_id: window.userId
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status) {
                        alert("OTP Resent Successfully");

                        // 🔥 TIMER RESET
                       startTimer(data.expires_in);

                    } else {
                        alert(data.message);
                    }

                });
            }
        </script>

    </body>

</html>