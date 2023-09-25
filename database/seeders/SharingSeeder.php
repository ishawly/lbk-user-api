<?php

namespace Database\Seeders;

use App\Enums\SharingStatus;
use App\Enums\SharingUserGroupStatus;
use App\Models\Record;
use App\Models\Sharing;
use App\Models\SharingRecord;
use App\Models\SharingUser;
use App\Models\SharingUserGroup;
use App\Models\SharingUserGroupDetail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SharingSeeder extends Seeder
{
    private $faker;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker       = fake('zh_CN');
        $this->faker = $faker;

        $userCount = random_int(2, 5);
        $users     = User::factory($userCount)->create();

        $userGroup = $this->createSharingUserGroup($users);

        $sharing = $this->createSharing($users, $userGroup);

        $totalAmount  = 0;
        $sharingUsers = collect();
        foreach ($users as $user) {
            // created sharing related users
            $sharingUser             = new SharingUser();
            $sharingUser->sharing_id = $sharing->id;
            $sharingUser->user_id    = $user->id;
            $sharingUser->status     = SharingStatus::Processing->value;
            $sharingUser->save();
            $sharingUsers->add($sharingUser);

            // create user related records
            $recordCount = random_int(1, 10);
            $records     = Record::factory($recordCount)->create(['user_id' => $user->id]);

            // created sharing related records
            $amount = 0;
            foreach ($records as $record) {
                $amount += ($record->amount * $record->type);

                $sRecord                 = new SharingRecord();
                $sRecord->sharing_id     = $sharing->id;
                $sRecord->record_id      = $record->id;
                $sRecord->user_id        = $record->user_id;
                $sRecord->type           = $record->type;
                $sRecord->amount         = $record->amount;
                $sRecord->transaction_at = $record->transaction_at;
                $sRecord->snapshot       = $record;
                $sRecord->save();
            }

            // Calculating total amount
            $totalAmount += $amount;
        }

        $sharing->amount = $totalAmount;
        $sharing->update();

        $this->setSharingRatioTo($sharingUsers, $totalAmount);
    }

    private function createSharingUserGroup(Collection $users): SharingUserGroup
    {
        $userGroup             = new SharingUserGroup();
        $userGroup->name       = 'sharing_user_group_' . $this->faker->text(5);
        $userGroup->created_by = $users->first()->id;
        $userGroup->status     = SharingUserGroupStatus::Finished->value;
        $userGroup->num        = $users->count();
        $userGroup->save();

        foreach ($users as $user) {
            $detail                        = new SharingUserGroupDetail();
            $detail->sharing_user_group_id = $userGroup->id;
            $detail->user_id               = $user->id;
            $detail->joined_at             = now();
            $detail->save();
        }

        return $userGroup;
    }

    private function createSharing(Collection $users, $userGroup): Sharing
    {
        $sharing                        = new Sharing();
        $sharing->sharing_user_group_id = $userGroup->id;
        $sharing->name                  = 'sharing_' . $this->faker->text(10);
        $sharing->created_by            = $users->first()->id;
        $sharing->status                = SharingStatus::Processing->value;
        $sharing->save();

        return $sharing;
    }

    private function setSharingRatioTo(Collection $sharingUsers, $totalAmount)
    {
        $totalRatio = 0;
        $ratioArr   = [];

        foreach ($sharingUsers as $sharingUser) {
            $ratioArr[$sharingUser->id] = random_int(1, 10);
            $totalRatio += $ratioArr[$sharingUser->id];
        }

        foreach ($sharingUsers as $sharingUser) {
            $sharingUser->sharing_ratio = $ratioArr[$sharingUser->id] / $totalRatio * 10000;
            $sharingUser->update();
        }
    }
}
