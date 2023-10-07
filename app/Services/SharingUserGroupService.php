<?php

namespace App\Services;

use App\Models\SharingUserGroup;
use App\Models\SharingUserGroupDetail;
use Illuminate\Database\Eloquent\Builder;

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
}
