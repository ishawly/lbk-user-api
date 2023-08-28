<x-layout>
    <x-slot:title>
        记一条
    </x-slot:title>

    @if(session()->has('record.store.success'))
        <div>{{ session()->pull('record.store.success') }}</div>
    @endif

    <form id="form" action="{{ route('records.store') }}" method="post">
        @csrf

        <p>
            <label>收支</label>
            <select name="type">
                <option value="-1">支出</option>
                <option value="1">收入</option>
            </select>

            @error('type')
                <span>{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>类型</label>
            <select name="category_id">
                <option value="5">购物</option>
                <option value="5002">收款</option>
            </select>

            @error('category_id')
                <span>{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>对方名称</label>
            <input type="text" name="reciprocal_name" value="{{ old('reciprocal_name') }}" placeholder="转账时填写(可选)" />

            @error('reciprocal_name')
                <span>{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>金额</label>
            <input type="text" name="amount" value="{{ old('amount') }}" placeholder="单位(元)" />

            @error('amount')
                <span>{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>交易日期</label>
            <input type="date" name="transaction_at" value="{{ old('transaction_at') }}" />

            @error('transaction_at')
                <span>{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>备注</label>
            <input type="text" name="remarks" value="{{ old('remarks') }}" placeholder="200字以内(可选)" />

            @error('remarks')
                <span>{{ $message }}</span>
            @enderror
        </p>
        <p>
            <button type="reset">重置</button>
            <button type="submit">保存</button>
        </p>
    </form>
</x-layout>
