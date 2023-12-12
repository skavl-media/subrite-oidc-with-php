<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
        .login-button {
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 8px;
            transition: background 0.3s ease-in-out;
            background: linear-gradient(45deg, #4CAF50, #2196F3);
            border: none;
            outline: none;
        }

        .login-button:hover {
            background: linear-gradient(45deg, #2196F3, #4CAF50);
        }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">


            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                <a 
                    class="login-button"
                    href="localhost:8000/login
  ?client_id=example-client-id
  &scope=openid%20offline_access
  &response_type=code
  &redirect_uri=https://localhost:3010/logout"

                >
Test

            </a>

                </div>

            </div>
        </div>
    </body>
</html>
