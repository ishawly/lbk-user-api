<?php

namespace App\Services;

use App\Models\Record;

class RecordService
{
    public function store(array $attributes, $user)
    {
        $attributes['user_id'] = $user->id;

        return Record::create($attributes);
    }

    public function update(Record $record, array $attributes)
    {
        $record->update($attributes);
    }
}
