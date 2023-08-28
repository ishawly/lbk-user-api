<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? '小记账' }}</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
{{-- 菜单--}}
<div>
    <ul>
        <li><a href="{{ route('dashboard') }}" >首页</a></li>
        <li><a href="{{ route('records.create') }}" >记一条</a></li>
    </ul>
</div>

{{ $slot }}

</body>
</html>