<!DOCTYPE html>
<html>
<head>
    <title>お問い合わせメール</title>
</head>
<body>
    <h2>お問い合わせがありました</h2>
    <p><strong>お名前：</strong> {{ $formData['name'] }}</p>
    <p><strong>メールアドレス：</strong> {{ $formData['email'] }}</p>
    <p><strong>お問い合わせ内容：</strong></p>
    <p>{{ $formData['contact'] }}</p>
</body>
</html>
