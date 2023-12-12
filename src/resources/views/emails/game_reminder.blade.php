<!DOCTYPE html>
<html>
<head>
    <title>試合通知</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .game-details {
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2 class="game-details">試合開始が近づいています!</h2>
    <br>
    <p>
        <span>{{ $formattedDate }}</span>
        <span>
            ※日本時間
        </span>
    </p>
    <br>
    <p>
        <span>
            {{ $game->competition->name }}
        </span>
        <span>
            {{ $stage }}
        </span>
    </p>
    <h3>
        <strong>
            {{ $game->homeTeam->name }} vs {{ $game->awayTeam->name }}
        </strong>
    </h3>
    <br>

    <p>{{ $remainingTimeMessage }}</p>
    <br>
    <br>
    <p><a href="{{ config('app.url') }}">Kickoff Reminder</a></p>
</body>
</html>
