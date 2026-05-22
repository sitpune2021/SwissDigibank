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
                overflow-x: hidden;
                overflow-y: auto;
                width: 100%;
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
                width: 92%;
                max-width: 340px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            }

           .otp-box-input {
                width: 50px;
                height: 55px;
                text-align: center;
                font-size: 24px;
                border: 2px solid #e5e7eb;
                border-radius: 12px;
                transition: 0.2s;
            }
            @media (max-width:480px){

                .otp-box-input{
                    width:45px;
                    height:50px;
                    font-size:20px;
                }

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
            .login-bg{
                background-image: url('{{ asset('assets/images/sbc_new_logo7.png') }}');
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
            }

            /* MOBILE FIX */
            @media (max-width:768px){

                .login-bg{
                    background-size: contain;
                    background-position: top center;
                    background-color: #020617;
                }

            }
            /* MOBILE */
            .login-wrapper{
                width:100%;
                max-width:360px;
            }

            .login-card{
                width:100%;
                max-width:360px;
                margin:auto;
            }

            /* DESKTOP / FULL SCREEN */
            @media (min-width:1024px){

                .login-wrapper{
                    max-width:420px;
                }

                .login-card{
                    max-width:420px;
                }

            }
            .login-card{
                border-radius: 48px;
                overflow: hidden;
            }

            /* ✨ ULTRA PREMIUM BANKING CARD */
            .login-card{
                position: relative;
                overflow: hidden;
                border-radius: 48px;

                /* GLASS EFFECT */
                background: linear-gradient(
                    145deg,
                    rgba(255,255,255,0.12),
                    rgba(255,255,255,0.04)
                );

                border: 1px solid rgba(255,255,255,0.18);

                /* DEPTH SHADOW */
                box-shadow:
                    0 25px 80px rgba(0,0,0,0.65),
                    0 0 25px rgba(34,211,238,0.12),
                    inset 0 1px 1px rgba(255,255,255,0.08);

                backdrop-filter: blur(24px);

                /* ANIMATION */
                animation:
                    floatCard 6s ease-in-out infinite,
                    cardGlow 3.5s ease-in-out infinite alternate;

                transition: all 0.4s ease;
            }

            /* 🔥 HOVER DEPTH EFFECT */
            .login-card:hover{
                transform: translateY(-8px) scale(1.01);

                box-shadow:
                    0 35px 100px rgba(0,0,0,0.8),
                    0 0 40px rgba(34,211,238,0.22),
                    0 0 80px rgba(59,130,246,0.18);
            }

            /* ✨ MOVING LIGHT */
            .login-card::before{
                content:"";
                position:absolute;
                top:-150px;
                left:-60%;
                width:220%;
                height:260px;

                background: linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,0.16),
                    transparent
                );

                transform: rotate(8deg);

                animation: shineMove 7s linear infinite;

                pointer-events:none;
            }

            /* 🌌 PREMIUM BORDER GLOW */
            .login-card::after{
                content:"";
                position:absolute;
                inset:0;
                border-radius:48px;
                padding:1px;

                background: linear-gradient(
                    135deg,
                    rgba(34,211,238,0.65),
                    transparent 35%,
                    transparent 65%,
                    rgba(59,130,246,0.55)
                );

                -webkit-mask:
                    linear-gradient(#fff 0 0) content-box,
                    linear-gradient(#fff 0 0);

                -webkit-mask-composite:xor;
                mask-composite:exclude;

                pointer-events:none;
            }

            /* ⬆ FLOATING EFFECT */
            @keyframes floatCard{
                0%{
                    transform: translateY(0px);
                }
                50%{
                    transform: translateY(-10px);
                }
                100%{
                    transform: translateY(0px);
                }
            }

            /* 🌌 GLOW PULSE */
            @keyframes cardGlow{
                0%{
                    filter: brightness(1);
                }

                100%{
                    filter: brightness(1.08);
                }
            }

            /* ✨ LIGHT SWEEP */
            @keyframes shineMove{
                0%{
                    transform: translateX(-140%) rotate(8deg);
                }

                100%{
                    transform: translateX(140%) rotate(8deg);
                }
            }
        </style>
        
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

</html>