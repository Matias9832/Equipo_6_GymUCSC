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
        <!-- Navbar -->
        <div class="bg-white shadow">
            @include('layouts.navigation')
        </div>

        <!-- Main Layout -->
        <div class="bg-gray-100 min-h-screen flex">
            <!-- Sidebar -->
            @if (isset($sidebar))
                <aside style="width: 18%;" class="bg-gray-200 p-4 h-screen">
                    {{ $sidebar }}
                </aside>
            @endif

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>