<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <form id="form">
        <p>
            <label>邮箱</label>
            <input type="text" name="username" />
        </p>
        <p>
            <label>密码</label>
            <input type="password" name="password" />
        </p>
        <p>
            <button type="reset">重置</button>
            <button type="submit">登录</button>
        </p>
    </form>
</body>
<script type="text/javascript">
    const errShow = document.querySelector('#err-show')

    function login(event) {
        event.preventDefault()
        let data = {
            username: getInputValue('username'),
            password: getInputValue('password'),
            _token: '{{ csrf_token() }}'
        }

        if(! data.username || !data.password) {
            alert('邮箱或密码不能为空')
            return
        }

        fetch('/api/v1/auth/login/using-password', {
            method: 'post',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        }).then(response => response.json()).then(function (data) {
            if (data.message === 'success') {
                localStorage.setItem('access_token', data.data.access_token)
                window.location.href = '/records/create';
            } else {
                alert(data.message)
            }
        }).catch(function (err) {
            console.error(err)
        })
    }

    function getInputValue(key, tag) {
        if (! tag) {
            tag = 'input';
        }
        let dom = document.querySelector(tag + '[name="' + key + '"]')
        return dom.value
    }

    const form = document.getElementById('form')
    form.addEventListener('submit', login)
</script>
</html>
