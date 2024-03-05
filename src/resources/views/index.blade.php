<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Kickoff Reminderでサッカーの試合通知を受け取ろう！" />
    <meta property="og:description" content="Kickoff Reminderはサッカーの試合時刻を通知するサービスです。" />
    <meta property="og:url" content="https://kickoffreminder.com" />
    <meta property="og:site_name" content="Kickoff Reminder" />
    <meta property="og:image" content="{{ asset('favicon.ico') }}" />
    <meta name="twitter:card" content="summary" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Kickoff Reminder</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div id="app"></div>
    @vite('resources/js/app.js')
</body>

</html>
