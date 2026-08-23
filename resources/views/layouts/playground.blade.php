<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Playground interativo SampaUI - Editor e Live Preview em tempo real com Tailwind CSS.">

        <title>{{ $title ?? 'Playground · SampaUI' }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/icon_favicon_sampaui.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/icon_favicon_sampaui.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="h-full w-full overflow-hidden bg-[#0a0e17] text-slate-100 antialiased flex flex-col selection:bg-primary/30 selection:text-white">
        @yield('content')

        @livewireScriptConfig
    </body>
</html>
