<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BTracker') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('bug_logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-indigo-50 via-white to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <div class="min-h-screen flex flex-col justify-center items-center px-6">
            
            <div class="flex flex-col items-center text-center">
                <a href="/">
                    <img src="{{ asset('bug_logo.png') }}" alt="Logo" class="w-20 h-20 mb-4">
                </a>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white tracking-wide">
                    {{ config('app.name', 'BTracker') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-md">
                    Manage and track bugs efficiently with a modern, powerful, and easy-to-use system.
                </p>
            </div>

            <div class="w-full sm:max-w-md mt-8">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">
                    {{ $slot }}
                </div>
            </div>

            <div class="mt-8 mb-4 text-sm text-gray-500 dark:text-gray-400">
                © {{ date('Y') }} {{ config('app.name', 'BTracker') }}. All rights reserved.
            </div>
        </div>
    </body>
</html>
