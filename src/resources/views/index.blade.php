<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Kickoff Reminder</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div id="app"></div>
    @vite('resources/js/app.js')
</body>

</html>
