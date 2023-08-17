<div class="item">
    <p>{{ $record->getTypeName() }}: {{ $record->getAmountYuan() }}</p>
    <p>类型: {{ $record->category->name }}</p>
    @if ($record->reciprocal_name)
        <p>对方名称: {{ $record->reciprocal_name }}</p>
    @endif
    <p>日期: {{ $record->transaction_at->format('Y-m-d H:i:s') }}</p>
    @if ($record->remark)
        <p>{{ $record->remark }}</p>
    @endif
</div>