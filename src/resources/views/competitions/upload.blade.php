<!DOCTYPE html>
<html>
<head>
    <title>Competition CSV Upload</title>
</head>
<body>

<h1>Competition CSV Upload</h1>

{{-- 成功メッセージ --}}
@if (session('success'))
    <div style="color: green; font-weight: bold;">
        {{ session('success') }}
    </div>
@endif

{{-- エラーメッセージ --}}
@if (session('error'))
    <div style="color: red; font-weight: bold;">
        {{ session('error') }}
    </div>
@endif

{{-- バリデーションエラー --}}
@if ($errors->any())
    <div style="color: red;">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('competitions.upload') }}" enctype="multipart/form-data">
    @csrf

    <label for="file">CSVファイルを選択:</label>
    <br>
    <input type="file" name="csv" required accept=".csv">
    <br><br>

    <button type="submit">アップロード</button>
</form>

</body>
</html>
