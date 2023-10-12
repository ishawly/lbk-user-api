<?php

namespace App\Services;

use App\Enums\SharingUserGroupStatus;
use App\Models\SharingUserGroup;
use App\Models\SharingUserGroupDetail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SharingUserGroupService
{
    public function has($id, int $userId = null): bool
    {
        $hasGroup = SharingUserGroup::where('id', $id)->exists();
        if (! $hasGroup) {
            return false;
        }

        if ($userId) {
            $hasDetail = SharingUserGroupDetail::where('sharing_user_group_id', $id)
                ->where('user_id', $userId)->exists();
            if (! $hasDetail) {
                return false;
            }
        }

        return true;
    }

    public function getByUserId($userId)
    {
        $list = SharingUserGroup::whereHas('details', function (Builder $query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return $list;
    }

    public function store($input, $user)
    {
        $ratios = collect($input['sharing_ratios']);
        if (100 != $ratios->sum()) {
            report('分摊比例错误');
        }

        $detail = collect($input['user_ids'])->combine($ratios);
        $group  = new SharingUserGroup();

        DB::transaction(function () use ($input, $user, $detail, $group) {
            $group->name       = $input['name'];
            $group->created_by = $user->id;
            $group->status     = SharingUserGroupStatus::Processing->value;
            $group->saveOrFail();

            $detail->each(function ($ratio, $userId) use ($group) {
                $d                        = new SharingUserGroupDetail();
                $d->sharing_user_group_id = $group->id;
                $d->user_id               = $userId;
                $d->sharing_ratio         = $ratio;
                $d->joined_at             = now();
                $d->saveOrFail();
            });
        });

        return $group;
    }
}
