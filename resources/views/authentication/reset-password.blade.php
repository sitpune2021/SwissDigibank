<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Secure Reset Password</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            overflow:hidden;

            background:
                radial-gradient(circle at top left, rgba(34,211,238,0.15), transparent 30%),
                radial-gradient(circle at bottom right, rgba(59,130,246,0.15), transparent 30%),
                linear-gradient(
                    135deg,
                    #020617,
                    #0f172a,
                    #111827
                );

            font-family:sans-serif;
        }

        /* GLOW */
        .bg-glow{
            position:absolute;
            width:500px;
            height:500px;
            border-radius:50%;

            background:rgba(34,211,238,0.12);

            filter:blur(120px);

            animation:floatGlow 8s ease-in-out infinite;
        }

        .bg-glow.one{
            top:-150px;
            left:-120px;
        }

        .bg-glow.two{
            bottom:-180px;
            right:-120px;
        }

        /* CARD */
        .card-box{
            position:relative;
            overflow:hidden;

            width:100%;
            max-width:430px;

            padding:34px;

            border-radius:34px;

            background:linear-gradient(
                145deg,
                rgba(15,23,42,0.96),
                rgba(2,6,23,0.94)
            );

            backdrop-filter:blur(35px);

            border:1px solid rgba(34,211,238,0.18);

            box-shadow:
                0 30px 90px rgba(0,0,0,0.75),
                0 0 35px rgba(34,211,238,0.10);

            color:white;

            z-index:10;

            animation:
                cardFloat 6s ease-in-out infinite,
                scaleIn 0.35s ease;
        }

        /* SHINE */
        .card-box::before{
            content:"";
            position:absolute;

            top:-120px;
            left:-40%;

            width:180%;
            height:220px;

            background:linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,0.10),
                transparent
            );

            transform:rotate(8deg);

            animation:shineMove 7s linear infinite;
        }

        /* TITLE */
        .title{
            text-align:center;
            font-size:28px;
            font-weight:700;

            letter-spacing:1px;

            text-shadow:0 0 18px rgba(34,211,238,0.35);
        }

        .subtitle{
            text-align:center;
            color:#cbd5e1;

            font-size:13px;

            margin-top:8px;
        }

        /* EXPIRY */
        .expiry-box{
            margin-top:18px;

            background:rgba(255,255,255,0.05);

            border:1px solid rgba(34,211,238,0.12);

            border-radius:16px;

            padding:12px;

            text-align:center;

            font-size:13px;

            color:#dbeafe;

            box-shadow:
                inset 0 0 15px rgba(255,255,255,0.03);
        }

        .expiry-box span{
            color:#22d3ee;
            font-weight:600;
        }

        /* PREMIUM LINE */
        .premium-line{
            display:flex;
            align-items:center;
            justify-content:center;

            margin:22px 0;
        }

        .premium-line span{
            width:70px;
            height:1.5px;

            background:linear-gradient(to right, transparent, #22d3ee);

            box-shadow:0 0 10px rgba(34,211,238,0.7);
        }

        .premium-line .dot{
            width:8px;
            height:8px;

            border-radius:50%;

            background:#22d3ee;

            margin:0 10px;

            box-shadow:0 0 12px rgba(34,211,238,1);
        }

        /* INPUT */
        .input-box{
            position:relative;
            margin-bottom:18px;
        }

        .form-control{
            background:rgba(255,255,255,0.08) !important;

            border:1px solid rgba(34,211,238,0.12) !important;

            border-radius:18px;

            padding:14px 16px;

            color:white !important;

            font-size:14px;

            box-shadow:none !important;
        }

        .form-control::placeholder{
            color:#cbd5e1;
        }

        .form-control:focus{
            border-color:#22d3ee !important;

            box-shadow:
                0 0 18px rgba(34,211,238,0.20) !important;
        }

        /* EYE */
        .toggle-eye{
            position:absolute;

            right:18px;
            top:15px;

            cursor:pointer;

            color:#cbd5e1;
        }

        /* BUTTON */
        .btn-custom{
            width:100%;

            border:none;

            border-radius:20px;

            padding:14px;

            color:white;

            font-weight:600;

            background:linear-gradient(
                135deg,
                #06b6d4,
                #2563eb
            );

            transition:0.35s;
        }

        .btn-custom:hover{
            transform:translateY(-2px) scale(1.02);

            box-shadow:
                0 12px 30px rgba(34,211,238,0.30);
        }

        /* ANIMATION */
        @keyframes shineMove{
            0%{
                transform:translateX(-120%) rotate(8deg);
            }

            100%{
                transform:translateX(120%) rotate(8deg);
            }
        }

        @keyframes cardFloat{
            0%{
                transform:translateY(0px);
            }

            50%{
                transform:translateY(-6px);
            }

            100%{
                transform:translateY(0px);
            }
        }

        @keyframes floatGlow{
            0%{
                transform:translateY(0px);
            }

            50%{
                transform:translateY(-20px);
            }

            100%{
                transform:translateY(0px);
            }
        }

        @keyframes scaleIn{
            from{
                opacity:0;
                transform:scale(0.95);
            }

            to{
                opacity:1;
                transform:scale(1);
            }
        }

    </style>

</head>

<body>

    <!-- GLOW -->
    <div class="bg-glow one"></div>
    <div class="bg-glow two"></div>

    <div class="card-box">

        <!-- TITLE -->
        <h2 class="title">
            🔐 Reset Password
        </h2>

        <p class="subtitle">
            Create a strong and secure password
        </p>

        <!-- EXPIRY -->
        <div class="expiry-box">
            ⏳ Reset link expires on
            <br>
            <span>{{ $expiresAt }}</span>
        </div>

        <!-- LINE -->
        <div class="premium-line">
            <span></span>
            <div class="dot"></div>
            <span></span>
        </div>

        <!-- SUCCESS -->
        @if(session('success'))
            <div class="alert alert-success text-center py-2">
                {{ session('success') }}
            </div>
        @endif

        <!-- ERROR -->
        @if(session('error'))
            <div class="alert alert-danger text-center py-2">
                {{ session('error') }}
            </div>
        @endif

        <!-- VALIDATION -->
        @if($errors->any())
            <div class="alert alert-danger py-2">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="/update-password">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <!-- PASSWORD -->
            <div class="input-box">

                <input type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Enter New Password"
                    required>

                <span class="toggle-eye" onclick="togglePassword()">
                    👁
                </span>

            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn-custom">
                Update Secure Password →
            </button>

        </form>

    </div>

    <script>

        function togglePassword(){

            let input = document.getElementById("password");

            input.type =
                input.type === "password"
                ? "text"
                : "password";
        }

    </script>

</body>

</html>