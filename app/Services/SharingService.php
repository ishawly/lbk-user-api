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

    public function update(Sharing $sharing, array $input, $user): Sharing
    {
        // Check current is member of Sharing user group
        $group     = SharingUserGroup::query()->where('id', $sharing->sharing_user_group_id)->firstOrFail();
        $groupUser = $group->details()->where('user_id', $user->id)->firstOrFail();

        DB::transaction(function () use ($sharing, $input, $user, $groupUser) {
            [
                'record_ids' => $recordIds,
            ] = $input;

            // Sharing Records
            $recordIds = collect($recordIds);

            $sRecords   = $sharing->records()->where('user_id', $user->id)->get('id');
            $sRecordIds = $sRecords->pluck('id');

            $deleteIds = $sRecordIds->diff($recordIds);
            SharingRecord::query()
                ->where('user_id', $user->id)
                ->where('sharing_id', $sharing->id)
                ->whereIn('id', $deleteIds)
                ->delete();

            $addIds     = collect($recordIds)->diff($sRecordIds);
            $addRecords = Record::query()->where('user_id', $user->id)
                ->whereIn('id', $addIds)->get();
            $addRecords->each(function ($record) use ($sharing) {
                $sr = new SharingRecord([
                    // 'sharing_id' => $sharing->id,
                    'record_id'      => $record->id,
                    'user_id'        => $record->user_id,
                    'type'           => $record->type,
                    'amount'         => $record->amount,
                    'transaction_at' => $record->transaction_at,
                    'snapshot'       => $record,
                ]);
                $sharing->records()->save($sr);
            });

            // Sharing user
            SharingUser::firstOrCreate([
                'sharing_id'    => $sharing->id,
                'user_id'       => $groupUser->id,
                'status'        => SharingStatus::Processing->value,
                'sharing_ratio' => $groupUser->sharing_ratio,
            ]);
        });

        return $sharing;
    }
}
