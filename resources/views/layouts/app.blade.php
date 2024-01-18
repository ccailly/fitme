<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        <!-- Page Heading -->
        <div class="navbar bg-base-100">
            <div class="navbar-start">
                <x-application-logo class="w-8 h-8 fill-current text-gray-500" />
            </div>
            <div class="navbar-center">
                <span>Mon Feed</span>
            </div>
            <div class="navbar-end">
                <button class="btn btn-ghost btn-circle">
                    <div class="avatar">
                        <div class="w-8 rounded-full">
                            <img src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                        </div>
                    </div>
                </button>
            </div>
        </div>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Page Navigation -->
        <div class="btm-nav">
            <button class="text-primary active">
                <x-heroicon-o-home class="h-5 w-5" />
            </button>
            <button class="text-primary">
                <x-heroicon-o-user-group class="h-5 w-5" />
            </button>
            <button class="text-primary">
                <x-heroicon-o-calendar class="h-5 w-5" />
            </button>
            <button class="text-primary">
                <x-heroicon-o-chat-bubble-left-right class="h-5 w-5" />
            </button>
        </div>
    </div>
</body>

</html>
