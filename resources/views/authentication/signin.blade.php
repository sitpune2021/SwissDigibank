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
                width: 55px;
                height: 60px;
                text-align: center;
                font-size: 24px;
                border: 2px solid #e5e7eb;
                border-radius: 12px;
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

            /* 🌌 Animated Background Glow */
            body::before {
                content: "";
                position: fixed;
                width: 600px;
                height: 600px;
                background: radial-gradient(circle, rgba(0,255,255,0.15), transparent);
                top: -100px;
                left: -100px;
                filter: blur(120px);
                animation: moveGlow 10s infinite alternate;
            }

            @keyframes moveGlow {
                0% { transform: translate(0,0); }
                100% { transform: translate(200px,150px); }
            }

            /* 🔥 Neon Card Glow */
            .neon-card {
                border: 1px solid rgba(0,255,255,0.2);
                box-shadow: 0 0 25px rgba(0,255,255,0.15),
                            0 0 60px rgba(0,255,255,0.05);
            }

            /* 🚀 Neon Button */
            .neon-btn {
                background: linear-gradient(90deg, #00f0ff, #0066ff);
                box-shadow: 0 0 15px rgba(0,240,255,0.6);
            }
            .neon-btn:hover {
                box-shadow: 0 0 25px rgba(0,240,255,1);
                transform: translateY(-1px);
            }

            /* 🧠 Input Focus Glow */
            input:focus {
                box-shadow: 0 0 12px rgba(0,255,255,0.6) !important;
            }

            /* 🔢 OTP Neon Boxes */
            .otp-box-input {
                background: rgba(255,255,255,0.05);
                color: white;
                border: 1px solid rgba(0,255,255,0.3);
            }
            .otp-box-input:focus {
                border-color: #00f0ff;
                box-shadow: 0 0 12px rgba(0,255,255,0.8);
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

   <body class="vertical">

        <div class="relative min-h-screen w-full overflow-hidden">

            <!-- SUCCESS -->
            @if(session('success'))
                <div class="alert alert-success text-center py-2">
                    {{ session('success') }}
                </div>
            @endif

            <!-- BACKGROUND -->
            <div class="absolute inset-0"
                style="
                    background-image: url('{{ asset('assets/images/sbc_new_logo7.png') }}');
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
                            rounded-3xl
                            px-5 py-6
                            shadow-[0_20px_60px_rgba(0,0,0,0.7)]
                            transition-all duration-300" 
                            style="width: 420px; background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); animation: scaleIn 0.4s ease;">

                            <!-- TITLE -->
                            <h2 class="text-white text-2xl font-semibold text-center mb-6 tracking-wide">
                                Secure Banking Login
                            </h2>
                           
                            <div class="text-center mb-4 text-white text-xs text-cyan-300">
                                🔐 Trusted Secure Login • End-to-End Encrypted
                            </div>

                            <!-- EMAIL -->
                            <div class="mb-4">
                                <input type="text" name="login"
                                    class="w-full px-4 py-3 rounded-xl 
                                    bg-white/80 text-black text-sm
                                    focus:ring-2 focus:ring-cyan-400
                                    outline-none shadow-md transition"
                                    placeholder="Email or Mobile">
                            </div>

                            <!-- PASSWORD -->
                            <div class="relative mb-5">
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
                                class="w-full py-2.5 rounded-lg text-sm font-semibold 
                                bg-gradient-to-r from-cyan-500 to-blue-600
                                hover:from-cyan-600 hover:to-blue-700
                                shadow-lg hover:shadow-cyan-500/40 transition duration-300" style="background-color: cornflowerblue;">
                                Continue to Secure Login →
                            </button>

                            <!-- FORGOT -->
                            <div class="flex justify-end mt-4 w-full">
                                <a href="#" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#forgotPasswordModal"
                                    class="text-cyan-300 text-xs hover:text-cyan-200 transition" style="color: aliceblue;">
                                    <b>Forgot Password?</b>
                                </a>
                            </div>

                            <div class="flex items-center my-4">
                                <div class="flex-grow h-px bg-white/30"></div>
                                <span class="px-3 text-xs text-gray-300" style="color: blanchedalmond;">OR</span>
                                <div class="flex-grow h-px bg-white/30"></div>
                            </div>

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

                                <span class="text-sm font-medium tracking-wide hover:scale-105 active:scale-95">
                                    Secure Login with Fingerprint / Face ID
                                </span>
                            </button><br>

                        </div>

                    </form>

                    <!-- OTP POPUP -->
                    <div id="otpModal" class="otp-modal" style="
                        display:none;
                        position:fixed;
                        top:0;
                        left:0;
                        width:100%;
                        height:100%;
                        background: rgba(0,0,0,0.75);
                        backdrop-filter: blur(10px);
                        justify-content:center;
                        align-items:center;
                    ">
                        <div class="otp-box neon-card" style="
                            background: rgba(0,0,0,0.85);
                            backdrop-filter: blur(20px);
                            color:white;
                            border-radius:20px;
                            padding:25px;
                            width:340px;
                            animation: scaleIn 0.3s ease;
                        ">
                            <h4 style="font-weight:600;">
                                🔐 OTP Verification
                            </h4>

                            <p style="font-size:12px; color:#aaa; margin-bottom:15px;">
                                Enter the OTP sent to your registered device
                            </p>

                            <div id="otpMessage" style="color:#ff6b6b; font-size:13px;"></div>

                            <div id="otpBoxes" style="display:flex; gap:12px; justify-content:center; margin:15px 0;">
    
                                <input type="text" maxlength="1" class="otp-box-input" id="otp1">
                                <input type="text" maxlength="1" class="otp-box-input" id="otp2">
                                <input type="text" maxlength="1" class="otp-box-input" id="otp3">
                                <input type="text" maxlength="1" class="otp-box-input" id="otp4">

                            </div>

                            <button onclick="verifyOtp()" 
                                class="w-full py-2 rounded-lg text-white neon-btn">
                                ✔ Verify & Continue
                            </button>
                            <!-- TIMER -->
                            <p id="timerText" style="font-size:12px; margin-top:10px; color:#aaa;">
                                Resend OTP in <span id="countdown">60</span> sec
                            </p>

                            <!-- RESEND BUTTON -->
                            <button id="resendBtn" onclick="resendOtp()" 
                                class="w-full mt-2 py-2 rounded-lg border border-cyan-400 text-cyan-300" disabled>
                                Resend OTP
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

            <!-- 🔥 PREMIUM FORGOT PASSWORD MODAL -->
            <div class="modal fade" id="forgotPasswordModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    
                    <div class="modal-content border-0 bg-transparent shadow-none">

                        <div class="otp-box neon-card" style="
                            background: rgba(0,0,0,0.85);
                            backdrop-filter: blur(20px);
                            color:white;
                            border-radius:20px;
                            padding:25px;
                            width:100%;
                            animation: scaleIn 0.3s ease;
                        ">

                            <!-- TITLE -->
                            <h4 style="font-weight:600;">
                                🔐 Reset Password
                            </h4>

                            <p style="font-size:12px; color:#aaa; margin-bottom:15px;">
                                Enter your registered email to receive reset link
                            </p>

                            <!-- SUCCESS -->
                            @if(session('success'))
                                <div style="color:#22c55e; font-size:13px; margin-bottom:10px;">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- ERROR -->
                            @if(session('error'))
                                <div style="color:#ff6b6b; font-size:13px; margin-bottom:10px;">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- VALIDATION -->
                            @if($errors->any())
                                <div style="color:#ff6b6b; font-size:13px; margin-bottom:10px;">
                                    @foreach($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- FORM -->
                            <form action="/forgot-password" method="POST">
                                @csrf

                                <!-- EMAIL INPUT -->
                                <div style="margin-bottom:15px;">
                                    <input type="email" name="email"
                                        class="w-full px-4 py-3 rounded-xl 
                                        bg-white/10 text-white text-sm
                                        border border-cyan-400/30
                                        focus:ring-2 focus:ring-cyan-400
                                        outline-none transition"
                                        placeholder="Enter your email"
                                        required>
                                </div><br>

                                <!-- BUTTON -->
                                <div style="display:flex; gap:10px; margin-top:10px;">

                                    <!-- SEND BUTTON -->
                                    <button type="submit"
                                        class="w-50 py-2 rounded-lg text-white neon-btn">
                                        ✉ Send Reset Link
                                    </button>

                                    <!-- CANCEL BUTTON -->
                                    <button type="button" data-bs-dismiss="modal"
                                        class="w-50 py-2 rounded-lg border border-gray-500 text-gray-300">
                                        Cancel
                                    </button>

                                </div>

                            </form>

                        </div>

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
                document.getElementById("otpMessage").innerText = "";

                if (data.has_biometric === false && !localStorage.getItem("biometric_asked")) {

                    localStorage.setItem("biometric_asked", "yes");

                    setTimeout(async () => {
                        if (confirm("Enable Secure Biometric Login?")) {
                            await registerBiometric();
                        }
                    }, 500);
                }

                // 🔥 AFTER biometric
                window.location.href = data.redirect;
            } else {
                document.getElementById("otpMessage").innerText = data.message;
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

                        document.getElementById("otpMessage").innerText = "OTP expired, please resend";
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
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    login: login,
                    password: password
                })
            })
            .then(res => res.json())
            .then(data => {

                // ✅ VALIDATION ERROR (backend se aa raha hai)
                if (data.errors) {
                    let messages = '';

                    for (let field in data.errors) {
                        messages += data.errors[field][0] + '\n';
                    }

                    alert(messages); // 🔥 show validation
                    return;
                }

                // ❌ LOGIN ERROR (invalid credentials)
                if (!data.status) {
                    alert(data.message); // 🔥 IMPORTANT
                    return;
                }

                // ✅ SUCCESS
                window.userId = data.user_id;

                document.getElementById('otpModal').style.display = 'flex';

                document.querySelectorAll(".otp-box-input").forEach(i => i.value = "");
                document.getElementById("otp1").focus();

                startTimer(data.expires_in);
            })
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

                        document.getElementById("otpMessage").innerText = "OTP Resent Successfully";

                        // ✅ STEP 1: PURANA OTP CLEAR
                        document.querySelectorAll(".otp-box-input").forEach(i => i.value = "");

                        // ✅ STEP 2: FIRST BOX PE FOCUS
                        document.getElementById("otp1").focus();

                        // ✅ STEP 3: TIMER RESET
                        startTimer(data.expires_in);

                    } else {
                        document.getElementById("otpMessage").innerText = data.message;
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

                    if (data.status) 
                    {
                        // 🔥 ADD THIS LINE
                        localStorage.setItem("biometric_asked", "done");
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