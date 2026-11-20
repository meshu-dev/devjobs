<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=schibsted-grotesk:400,500,600,700" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="min-h-screen font-sans antialiased bg-base-200 text-base-content">
    <main class="flex min-h-screen items-start justify-center px-4 pt-[12vh] pb-12">
        {{ $slot }}
    </main>

    {{--  TOAST area --}}
    <x-toast />

    @livewireScripts
</body>
</html>
