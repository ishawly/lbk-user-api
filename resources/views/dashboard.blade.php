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
        <div class="item">
            <p>{{ $r->type_name }}: {{ $r->amount }}</p>
            <p>类型: {{ $r->category->name }}</p>
            @if ($r->reciprocal_name)
            <p>对方名称: {{ $r->reciprocal_name }}</p>
            @endif
            <p>日期: {{ $r->transaction_at }}</p>
            @if ($r->remark)
            <p>{{ $r->remark }}</p>
            @endif
        </div>
        @endforeach
    </div>
</body>
</html>
