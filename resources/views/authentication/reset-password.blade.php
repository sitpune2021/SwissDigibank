<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #0f172a, #0e7490);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-box {
            width: 100%;
            max-width: 400px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            color: white;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        .form-control {
            border-radius: 30px;
            padding: 10px 15px;
        }

        .btn-custom {
            border-radius: 30px;
            background: linear-gradient(90deg, #06b6d4, #3b82f6);
            border: none;
        }

        .btn-custom:hover {
            opacity: 0.9;
        }

        .toggle-eye {
            position: absolute;
            right: 15px;
            top: 10px;
            cursor: pointer;
            color: gray;
        }
    </style>
</head>

    <body>

        <div class="card-box">

            <h4 class="text-center mb-3">🔐 Reset Password</h4>

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

            <form method="POST" action="/update-password">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <!-- PASSWORD -->
                <div class="mb-3 position-relative">
                    <input type="password" name="password" id="password"
                        class="form-control"
                        placeholder="Enter New Password" required>

                    <span class="toggle-eye" onclick="togglePassword()">👁</span>
                </div>

                <!-- BUTTON -->
                <button type="submit" class="btn btn-custom w-100 text-white">
                    Update Password
                </button>
            </form>

        </div>

        <script>
        function togglePassword() {
            let input = document.getElementById("password");
            input.type = input.type === "password" ? "text" : "password";
        }
        </script>

    </body>
    
</html>