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
                overflow-y: auto;
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

           .otp-box-input {
                width: 50px;
                height: 55px;
                text-align: center;
                font-size: 22px;
                border: 2px solid #ddd;
                border-radius: 10px;
                transition: 0.2s;
            }

            .otp-box-input:focus {
                border-color: #06b6d4;
                box-shadow: 0 0 10px rgba(6,182,212,0.4);
            }
            @keyframes scaleIn {
                from {
                    transform: scale(0.8);
                    opacity: 0;
                }
                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-cyan-900 to-slate-800"></div>

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
                            style="width: 470px; background-color: #362a2a;">

                            <!-- TITLE -->
                            <h2 class="text-white text-2xl font-semibold text-center mb-6 tracking-wide">
                                Welcome Back 👋
                            </h2>

                            <p class="text-center text-white text-sm mb-6">
                                <b>Login to your secure banking dashboard</b>
                            </p>

                            <!-- EMAIL -->
                            <div class="mb-4">
                                <!-- <label class="text-white">
                                    Email or Mobile
                                </label> -->
                                <input type="text" name="login"
                                    class="w-full px-4 py-3 rounded-xl 
                                    bg-white/80 text-black text-sm
                                    focus:ring-2 focus:ring-cyan-400
                                    outline-none shadow-md transition"
                                    placeholder="Email or Mobile">
                            </div>

                            <!-- PASSWORD -->
                            <div class="relative mb-5">
                                <!-- <label class="text-white">
                                    Password
                                </label> -->
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-3 pr-10 rounded-xl 
                                    bg-white/80 text-black text-sm
                                    focus:ring-2 focus:ring-cyan-400
                                    outline-none shadow-md transition"
                                    placeholder="Password">

                                <!-- TOGGLE -->
                                <span id="toggle" style="top: 28px;"
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
                                Login Securely
                            </button>

                            <!-- FORGOT -->
                            <div class="flex justify-end mt-4 w-full">
                                <a href="#" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#forgotPasswordModal"
                                    class="text-cyan-300 text-xs hover:text-cyan-200 transition" style="color: aliceblue;">
                                    <b>Forgot Password?</b>
                                </a>
                            </div><br>

                            <button type="button" onclick="biometricLogin()"
                                class="w-full flex items-center justify-center gap-2 
                                border border-white/30 text-white py-2.5 rounded-xl 
                                bg-white/5 hover:bg-white/10 backdrop-blur-md 
                                transition-all duration-300 shadow-md">

                                <!-- ICON -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" 
                                    class="bi bi-shield-lock" viewBox="0 0 16 16">
                                    <path d="M5.5 9a1.5 1.5 0 1 1 3 0v1h-3V9z"/>
                                    <path d="M8 0c-.69 0-1.843.405-3.516 1.316C2.825 2.26 2 3.21 2 4.2V7c0 3.248 2.432 6.023 6 6.9 3.568-.877 6-3.652 6-6.9V4.2c0-.99-.825-1.94-2.484-2.884C9.843.405 8.69 0 8 0zM8 1c.45 0 1.44.285 3.03 1.09C12.46 2.79 13 3.42 13 4.2V7c0 2.8-2.1 5.2-5 6-2.9-.8-5-3.2-5-6V4.2c0-.78.54-1.41 1.97-2.11C6.56 1.285 7.55 1 8 1z"/>
                                </svg>

                                <span class="text-sm font-medium tracking-wide">
                                    Login with Passkey
                                </span>
                            </button><br>

                        </div>

                    </form>

                    <!-- OTP POPUP -->
                    <div id="otpModal"  class="otp-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#00000080; justify-content:center; align-items:center;">
                        <div style="background:white; padding:20px; border-radius:10px; width:300px;">
                            <h4>Enter OTP</h4>

                            <div id="otpBoxes" style="display:flex; gap:10px; justify-content:center; margin-bottom:10px;">
    
                                <input type="text" maxlength="1" class="otp-box-input" id="otp1">
                                <input type="text" maxlength="1" class="otp-box-input" id="otp2">
                                <input type="text" maxlength="1" class="otp-box-input" id="otp3">
                                <input type="text" maxlength="1" class="otp-box-input" id="otp4">

                            </div>

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
        async function verifyOtp() 
        {

            let otp =
            document.getElementById('otp1').value +
            document.getElementById('otp2').value +
            document.getElementById('otp3').value +
            document.getElementById('otp4').value;

            let userId = window.userId;

            let res = await fetch("/verify-login-otp", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    user_id: userId,
                    otp: otp
                })
            });

            let data = await res.json();

            if (data.status) 
            {

                if (!data.has_biometric) {
                    if (confirm("Enable Secure Biometric Login?")) {
                        let success = await registerBiometric();

                        if (!success) {
                            alert("Biometric setup failed, continue login");
                        }
                    }
                }

                // 🔥 AFTER biometric
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        }
        </script>

        <script>      
            let timeLeft = 0;
            let timer;

            function startTimer(seconds) 
            {

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
                        document.querySelectorAll(".otp-box-input").forEach(i => i.value = "");

                        alert("OTP expired, please resend");
                    }

                }, 1000);
            }
        </script>

        <script>
        function loginUser() 
        {
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

                // ✅ VALIDATION ERROR
                if (data.type === 'validation') {
                    let messages = '';

                    for (let field in data.errors) {
                        messages += data.errors[field][0] + '\n';
                    }

                    alert(messages); // 🔥 popup
                    return;
                }

                // ❌ NORMAL ERROR
                if (!data.status) {
                    alert(data.message);
                    return;
                }

                // ✅ SUCCESS
                window.userId = data.user_id;

                document.getElementById('otpModal').style.display = 'flex';

                document.querySelectorAll(".otp-box-input").forEach(i => i.value = "");
                document.getElementById("otp1").focus();

                startTimer(data.expires_in);

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

                        // ✅ STEP 1: PURANA OTP CLEAR
                        document.querySelectorAll(".otp-box-input").forEach(i => i.value = "");

                        // ✅ STEP 2: FIRST BOX PE FOCUS
                        document.getElementById("otp1").focus();

                        // ✅ STEP 3: TIMER RESET
                        startTimer(data.expires_in);

                    } else {
                        alert(data.message);
                    }

                });
            }
        </script>

        <script>
            const inputs = document.querySelectorAll(".otp-box-input");

            inputs.forEach((input, index) => {

                input.addEventListener("input", (e) => {

                    if (e.target.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                });

                input.addEventListener("keydown", (e) => {

                    if (e.key === "Backspace" && !input.value && index > 0) {
                        inputs[index - 1].focus();
                    }

                });

            });
        </script>

        <script>
            async function biometricLogin() {
                try {

                    // ❌ Browser support check
                    if (!window.PublicKeyCredential) {
                        alert("Biometric / Passkey not supported in this browser");
                        return;
                    }

                    let login = document.querySelector('input[name="login"]').value;

                    if (!login) {
                        alert("Please enter Email or Mobile first");
                        return;
                    }

                    // ✅ STEP 1: Get options from server
                    let res = await fetch("/biometric/login-options", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        credentials: "same-origin",
                        body: JSON.stringify({ login: login })
                    });

                    // 🔥 IMPORTANT: handle non-JSON response
                    if (!res.ok) {
                        let text = await res.text();
                        console.error("SERVER ERROR:", text);
                        alert("Server error (check console)");
                        return;
                    }

                    let options = await res.json();

                    if (options.error) {
                        alert(options.error);
                        return;
                    }

                    // ✅ STEP 2: decode challenge
                    options.challenge = Uint8Array.from(atob(options.challenge), c => c.charCodeAt(0));

                    // ✅ STEP 3: decode allowCredentials
                    if (options.allowCredentials) {
                        options.allowCredentials = options.allowCredentials.map(cred => ({
                            ...cred,
                            id: Uint8Array.from(atob(cred.id), c => c.charCodeAt(0))
                        }));
                    }

                    // ✅ STEP 4: get credential from device
                    let credential = await navigator.credentials.get({
                        publicKey: options
                    });

                    // ❌ user cancelled
                    if (!credential) {
                        alert("Authentication cancelled");
                        return;
                    }

                    // ✅ STEP 5: encode rawId
                    let rawId = btoa(
                        String.fromCharCode(...new Uint8Array(credential.rawId))
                    );

                    // ✅ STEP 6: send to server
                    let response = await fetch("/biometric/login", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        credentials: "same-origin",
                        body: JSON.stringify({
                            id: rawId
                        })
                    });

                    // 🔥 again safe parsing
                    if (!response.ok) {
                        let text = await response.text();
                        console.error("LOGIN ERROR:", text);
                        alert("Login failed (server error)");
                        return;
                    }

                    let data = await response.json();

                    if (data.status) {
                        window.location.href = data.redirect;
                    } else {
                        alert("Biometric login failed");
                    }

                } catch (err) {
                    console.error("FULL ERROR:", err);
                    alert("Biometric failed or not supported");
                }
            }
        </script>

        <script>
            async function registerBiometric() 
            {
                try {

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    let res = await fetch("/biometric/register-options", {
                        method: "POST",
                        credentials: "same-origin", // ✅ VERY IMPORTANT
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({
                            user_id: window.userId
                        })
                    });

                    // ❌ agar 419 aya to yahin pakdo
                    if (!res.ok) {
                        let text = await res.text();
                        console.error("SERVER RESPONSE:", text);
                        throw new Error("Server error");
                    }

                    let options = await res.json();

                    // decode
                    options.challenge = Uint8Array.from(atob(options.challenge), c => c.charCodeAt(0));
                    options.user.id = Uint8Array.from(atob(options.user.id), c => c.charCodeAt(0));

                    let credential = await navigator.credentials.create({
                        publicKey: options
                    });

                    let attestationObject = btoa(
                        String.fromCharCode(...new Uint8Array(credential.response.attestationObject))
                    );

                    let clientDataJSON = btoa(
                        String.fromCharCode(...new Uint8Array(credential.response.clientDataJSON))
                    );

                    let rawId = btoa(
                        String.fromCharCode(...new Uint8Array(credential.rawId))
                    );

                    let response = await fetch("/biometric/register", {
                        method: "POST",
                        credentials: "include", // ✅ VERY IMPORTANT
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({
                            user_id: window.userId,
                            id: credential.id,
                            rawId: rawId,
                            attestationObject: attestationObject,
                            clientDataJSON: clientDataJSON
                        })
                    });

                    let data = await response.json();

                    if (data.status) {
                        alert("Biometric Enabled Successfully");
                        return true;
                    } else {
                        alert("Save failed");
                        return false;
                    }

                } catch (err) {
                    console.error("FULL ERROR:", err);
                    alert("Biometric setup failed");
                    return false;
                }
            }
        </script>

    </body>

</html>