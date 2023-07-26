<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <form id="form" action="/session" method="post">
        @csrf
        <p>
            <label>邮箱</label>
            <input type="text" name="username" value="{{ @old('username') }}"/>
        </p>
        <p>
            <label>密码</label>
            <input type="password" name="password" />
        </p>
        <p>
            <button type="reset">重置</button>
            <button type="submit">登录</button>
        </p>
        @if($errors->any())
            @foreach($errors->all() as $err)
                <p class="error-msg">
                    {{ $err }}
                </p>
            @endforeach
        @endif
    </form>
</body>
</html>
