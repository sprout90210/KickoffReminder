<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント登録申し込み確認メール</title>
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
    <header><a href="{{ config('app.url') }}">Kickoff Reminder</a></header>

    <div class="container">
        <h2>アカウント登録申し込み確認メール</h2>

        <p>現時点ではアカウント登録は完了しておりません。</p>

        <p>下記のURLをクリックし、登録を進めてください。</p>
        <a href="{{ url('/verify-email/'.$token) }}">{{ url('/verify-email/'.$token) }}</a>
        <br><br>

        <ul>
            <li>この認証メールの有効期限は1時間です。1時間を経過した場合、アカウント登録をはじめからやりなおしてください。</li>
            <li>正しくメールが表示されない場合がございます。</li>
            <li>このメールは、送信専用メールアドレスから配信されています。ご返信いただいてもお答えできませんので、ご了承ください。</li>
            <li>このメールにお心当たりのない方は、本メールを破棄してください。</li>
        </ul>
    </div>

    <footer>
        <p>© Kickoff Reminder. All rights reserved.</p>
    </footer>
</body>

</html>