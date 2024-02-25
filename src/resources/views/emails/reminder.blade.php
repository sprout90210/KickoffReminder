<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>試合通知</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #444;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header a {
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 0 20px;
        }

        h3 {
            text-align: center;
            color: #444;
        }

        .game-info {
            background-color: #ddd;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .game-info h2 {
            margin: 10px 0;
        }

        footer {
            background-color: #444;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            margin-top: 20px;
        }

        footer p {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <header>
        <a href="{{ config('app.url') }}">Kickoff Reminder</a>
    </header>

    <div class="container">
        <br>
        <h3>{{ $name }} さん</h3>
        <br>
        <div class="game-info">
            <p>※日本時間</p>
            <p>{{ $formattedDate }}</p>
            <p>
                <span>{{ $game->competition->name }}</span>
                <span>{{ $stage }}</span>
            </p>
            <h2><strong>{{ $game->homeTeam->name }} vs {{ $game->awayTeam->name }}</strong></h2>
            <br>
            <p>{{ $remainingTimeMessage }}</p>
            <p>お見逃しなく！</p>
        </div>
        <br>
        <ul>
            <li>正しくメールが表示されない場合がございます。</li>
            <li>このメールは、送信専用メールアドレスから配信されています。ご返信いただいてもお答えできませんので、ご了承ください。</li>
            <li>メール配信停止をご希望の場合はお手数ですが<a href="{{ config('app.url') }}">Kickoff Reminder</a>よりお手続きください。</li>
        </ul>
    </div>

    <footer>
        <p>© Kickoff Reminder. All rights reserved.</p>
    </footer>
</body>

</html>