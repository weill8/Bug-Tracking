<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BTracker') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('bug_logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans">

    {{-- Navbar --}}
    <header class="w-full fixed top-0 left-0 z-50 bg-white/70 dark:bg-gray-900/70 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2 text-xl font-bold">
                <img src="{{ asset('bug_logo.png') }}" class="w-8 h-8" alt="Logo">
                {{ config('app.name', 'BTracker') }}
            </a>

            <div class="flex gap-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-800">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700">
                                Register
                            </a>
                        @endif
                    @endauth
                    </nav>
                @endif
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section
        class="pt-32 h-screen pb-20 bg-gradient-to-b from-indigo-50 via-white to-white dark:from-gray-800 dark:via-gray-900 dark:to-gray-900 flex items-center">
        <div class="max-w-7xl mx-auto px-6 text-center">
            {{-- Tagline kecik --}}
            <span class="text-sm uppercase tracking-wide text-indigo-600 font-semibold">
                🚀 Boost your workflow
            </span>

            <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
                Simplify Your <span class="text-indigo-600">Bug Tracking</span>
            </h1>

            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-8">
                Manage and track bugs efficiently with a modern, powerful, and easy-to-use system.
            </p>

            <div class="flex justify-center gap-4 mb-12">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-6 py-3 rounded-lg bg-indigo-600 text-white font-medium shadow hover:bg-indigo-700 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="px-6 py-3 rounded-lg bg-indigo-600 text-white font-medium shadow hover:bg-indigo-700 transition">
                            Get Started
                        </a>
                    @endauth
                @endif
                        <a href="#features"
                            class="px-6 py-3 rounded-lg bg-gray-200 dark:bg-gray-700 font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            Learn More
                        </a>
                </div>

                <div class="grid grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-3xl font-bold text-indigo-600">{{ $jumlahUser }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">Active Users</p>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-3xl font-bold text-indigo-600">{{ $jumlahProject }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">Projects Managed</p>
                    </div>
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-3xl font-bold text-indigo-600">{{ $jumlahResolved }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">Bugs Resolved</p>
                    </div>
                </div>

            </div>
        </section>


        {{-- Features Section --}}
        <section id="features" class="py-24">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-12">Awesome Features</h2>
                <div class="grid md:grid-cols-3 gap-8">

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-2">👥 Users</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Manage and monitor all registered users in one place.
                        </p>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-2">🐞 Total Bugs</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Get real-time insight into all bugs reported across projects.
                        </p>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-2">✅ Bugs Resolved</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Track how many bugs have been fixed successfully.
                        </p>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-2">📂 Projects</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Organize and manage multiple projects with ease.
                        </p>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-2">🎁 User Rewards</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Reward active users and boost engagement with a built-in reward system.
                        </p>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-2">📊 Bug Statistics</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Visualize bug distribution by priority for smarter decisions.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        {{-- About Section --}}
        <section id="about" class="py-20 bg-white dark:bg-gray-800">
            <div class="max-w-5xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-6">Why Choose Us?</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    BTracker is built to help teams manage bugs and tasks with ease. With an intuitive UI, modern design,
                    and robust backend, you can focus on what matters: delivering quality software.
                </p>
            </div>
        </section>

        {{-- Footer --}}
        <footer
            class="py-4 bg-indigo-600 dark:border-gray-700 text-center font-semibold tracking-wide text-sm text-white dark:text-black">
            &copy; {{ date('Y') }} {{ config('app.name', 'BTracker') }}. All rights reserved.
        </footer>
    </body>

    </html>
