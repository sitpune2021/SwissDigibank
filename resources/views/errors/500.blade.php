<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - {{ $exception->getStatusCode() ?? 'Error' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #333;
        }
        .error-container {
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 90%;
        }
        .error-code {
            font-size: 100px;
            font-weight: bold;
            color: #ff6b6b;
        }
        .error-message {
            font-size: 20px;
            margin-bottom: 20px;
        }
        .btn-home {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff6b6b;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-home:hover {
            background-color: #e64949;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">
            {{ $exception->getStatusCode() ?? 'Error' }}
        </div>
        <div class="error-message">
            @if($exception->getStatusCode() == 500)
                Sorry! Something went wrong on our server.
            @else
                An unexpected error occurred. Please try again later.
            @endif
        </div>
        <a href="{{ url('/dashboard') }}" class="btn-home">Go Home</a>
    </div>
</body>
</html>
