<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Record Store</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <form id="form">
        <p>
            <label>收支</label>
            <select name="type">
                <option value="-1">支出</option>
                <option value="1">收入</option>
            </select>
        </p>
        <p>
            <label>类型</label>
            <select name="category_id">
                <option value="5">购物</option>
                <option value="5002">收款</option>
            </select>
        </p>
        <p>
            <label>对方名称</label>
            <input type="text" name="reciprocal_name" placeholder="转账时填写(可选)" />
        </p>
        <p>
            <label>金额</label>
            <input type="text" name="amount" placeholder="单位(元)" />
        </p>
        <p>
            <label>交易日期</label>
            <input type="date" name="transaction_at" />
        </p>
        <p>
            <label>备注</label>
            <input type="text" name="remarks" placeholder="200字以内(可选)" />
        </p>
        <p>
            <button type="reset">重置</button>
            <button type="submit">保存</button>
        </p>
    </form>
</body>
<script type="text/javascript">
    function recordSubmit(event) {
        event.preventDefault()
        let data = {
            type: getInputValue('type', 'select'),
            category_id: getInputValue('category_id', 'select'),
            reciprocal_name: getInputValue('reciprocal_name'),
            amount: getInputValue('amount'),
            transaction_at: getInputValue('transaction_at'),
            remarks: getInputValue('remarks'),
            _token: '{{ csrf_token() }}',
        }

        fetch('/api/v1/records', {
            method: 'post',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            const data = response.json();
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
    form.addEventListener('submit', recordSubmit)
</script>
</html>
