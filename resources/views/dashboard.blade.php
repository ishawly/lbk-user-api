<x-layout>
    <x-slot:title>
        交易记录列表
    </x-slot:title>

    <div class="records">
        @foreach ($records as $r)
            <x-records.item :record="$r" />
        @endforeach
    </div>

    {{ $records->links() }}
</x-layout>
