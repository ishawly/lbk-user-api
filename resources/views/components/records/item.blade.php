@foreach ($records as $record)
<div class="grid grid-cols-4 w-2/5 mt-2">

    <div class="col-span-4">{{ $record->transaction_at->format('Y-m-d') }}</div>
    <div>{{ $record->getTypeName() }}</div>
    <div class="text-red-500">{{ $record->getAmountYuan() }}元</div>
    <div>{{ $record->category->name }}</div>
    <div>{{ $record->reciprocal_name }}</div>

    @if ($record->remarks)
        <div class="col-span-4 text-gray-500">{{ $record->remarks }}</div>
    @endif
</div>
@endforeach

{{ $records->links() }}
