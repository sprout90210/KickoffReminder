<!DOCTYPE html>
<html>

<head>
    <title>試合通知</title>
    <style>
        body {
            color: white;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: gray;
        }
        header {
            padding: 25px 0;
            text-align: center;
            border-bottom: 1px solid gray;
        }
        header a {
            color: #3d4852;
            font-size: 19px;
            font-weight: bold;
            text-decoration: none;
        }
        h3{
            text-align: center;
        }
        footer {
            margin: 0 auto;
            padding: 20px 0;
            text-align: center;
            border-top: 1px solid gray;
        }
        footer p {
            color: #b0adc5;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>

<header><a href="{{ config('app.url') }}">KickoffReminder</a></header>

<body>
    <br>
    <h3>{{ $name }} さん</h3>
    <br>
    <div>
        <p>※日本時間</p>
        <p>{{ $formattedDate }}</p>
    </div>
    <p>
        <span>{{ $game->competition->name }}</span>
        <span>{{ $stage }}</span>
    </p>
    <h2><strong>{{ $game->homeTeam->name }} vs {{ $game->awayTeam->name }}</strong></h2>
    <br>

    <p>{{ $remainingTimeMessage }}</p>
    <br>
    <p>お見逃しなく！</p>
    <br>
    <br>
</body>
<footer>
    <p>© 2023 KickoffReminder. All rights reserved.</p>
</footer>

</html>