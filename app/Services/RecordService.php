<?php

namespace App\Services;

use App\Models\Record;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RecordService
{
    public function getRecordQueryBuilder(Request $request): Builder
    {
        $type       = (int) $request->input('type');
        $categoryId = (int) $request->input('category_id');
        $keyword    = $request->input('keyword');

        $transactionAtStart = $request->input('transaction_at_start');
        $transactionAtEnd   = $request->input('transaction_at_end');

        $query = Record::query();

        $type               and $query->where('type', $type);
        $categoryId         and $query->where('category_id', $categoryId);
        $keyword            and $query->where('reciprocal_name', 'like', "%{$keyword}%");
        $transactionAtStart and $query->where('transaction_at', '>=', $transactionAtStart);
        $transactionAtEnd   and $query->where('transaction_at', '<=', $transactionAtEnd);

        return $query;
    }

    public function store(array $attributes, $user)
    {
        $attributes['user_id'] = $user->id;
        // 以分为单位保存
        $attributes['amount'] = intval($attributes['amount'] * 100);

        return Record::create($attributes);
    }

    public function update(Record $record, array $attributes)
    {
        $record->update($attributes);
    }

    public function getTypes(): array
    {
        return [
            ['id' => -1, 'name' => '支出'],
            ['id' => 1, 'name' => '收入'],
        ];
    }
}
