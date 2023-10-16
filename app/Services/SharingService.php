<?php

namespace App\Services;

use App\Enums\SharingStatus;
use App\Enums\SharingUserGroupStatus;
use App\Models\Record;
use App\Models\Sharing;
use App\Models\SharingRecord;
use App\Models\SharingUser;
use App\Models\SharingUserGroup;
use Illuminate\Support\Facades\DB;

class SharingService
{
    public function store(array $input, $user): Sharing
    {
        $sharing = new Sharing();

        DB::transaction(function () use ($input, $user, $sharing) {
            $group   = SharingUserGroup::query()->findOrFail($input['sharing_user_group_id']);
            $details = $group->details()->get();
            $detail  = $details->where('user_id', $user->id)->first();
            $records = Record::query()->where('user_id', $user->id)->whereIn('id', $input['record_ids'])->get();

            $sharing->name                  = $input['name'];
            $sharing->created_by            = $user->id;
            $sharing->status                = SharingStatus::Processing->value;
            $sharing->sharing_user_group_id = $group->id;
            $sharing->save();

            $sharingUser                = new SharingUser();
            $sharingUser->sharing_id    = $sharing->id;
            $sharingUser->user_id       = $detail->user_id;
            $sharingUser->status        = SharingUserGroupStatus::Processing->value;
            $sharingUser->sharing_ratio = $detail->sharing_ratio;
            $sharingUser->save();

            $records->each(function ($record) use ($sharing) {
                SharingRecord::create([
                    'sharing_id'     => $sharing->id,
                    'record_id'      => $record->id,
                    'user_id'        => $record->user_id,
                    'type'           => $record->type,
                    'amount'         => $record->amount,
                    'transaction_at' => $record->transaction_at,
                    'snapshot'       => $record,
                ]);
            });
        });

        return $sharing;
    }

    public function update(array $input, $user): Sharing
    {
        return new Sharing();
    }
}
