<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>交易记录列表</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <div class="records">
        @foreach ($records as $r)
            <x-records.item :record="$r" />
        @endforeach
    </div>
</body>
</html>
