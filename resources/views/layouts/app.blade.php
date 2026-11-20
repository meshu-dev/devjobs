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

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden border-b border-base-300">
        <x-slot:brand>
            <livewire:mobile-header />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-1 p-2 cursor-pointer" aria-label="Open menu">
                <x-icon name="o-bars-3" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-base-200 lg:border-r lg:border-base-300">

            {{-- BRAND --}}
            <a href="/" wire:navigate class="hidden-when-collapsed block px-5 pt-6 pb-4 text-2xl font-bold tracking-tight">
                DevJobs
            </a>

            {{-- MENU --}}
            <x-menu activate-by-route active-bg-color="bg-base-100 font-semibold">
                <x-menu-item title="Jobs" icon="o-briefcase" link="/" />
                <x-menu-item title="Favourites" icon="o-star" link="/favourites" />
                <x-menu-item title="Import history" icon="o-clock" link="/logs" />
                <x-menu-item title="Profile" icon="o-user-circle" link="/profile" />

                @if($user = auth()->user())
                    <x-menu-separator />

                    <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
                        <x-slot:actions>
                            <x-button icon="o-arrow-right-start-on-rectangle" class="btn-circle btn-ghost btn-sm" tooltip-left="Log out" aria-label="Log out" no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-list-item>
                @endif
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content class="max-w-5xl">
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />

    @livewireScripts
</body>
</html>
