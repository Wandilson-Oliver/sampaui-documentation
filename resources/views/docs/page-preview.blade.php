<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $page['name'] }} · Preview SampaUI</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#F4F6FA] text-primary">
        {!! \Illuminate\Support\Facades\Blade::render($page['preview']) !!}
    </body>
</html>
