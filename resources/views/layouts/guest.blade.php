<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Login SKIS</title>

    <!-- Logo apps | favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/kias-logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes slideFade {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-slideFade {
            animation: slideFade 0.6s ease-out both;
        }
    </style>
</head>


<body class="min-h-screen bg-black text-white font-sans relative overflow-hidden">
    {{ $slot }}
</body>


</html>
