<?php

namespace Tests\Feature\Services;

use App\Models\Record;
use App\Models\SharingRecord;
use App\Models\SharingUserGroup;
use App\Models\User;
use App\Services\SharingService;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class SharingServiceTest extends TestCase
{
    private SharingService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new SharingService();
    }

    public function testStoreSharing(): void
    {
        $user = User::query()->select('id')->has('records')
            ->has('sharingUserGroups')
            ->inRandomOrder()
            ->first();
        $this->assertNotEmpty($user);

        $groupId = SharingUserGroup::query()->whereHas('details', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->value('id');

        $input = [
            'name'                  => fake()->text(10),
            'record_ids'            => Record::query()->where('user_id', $user->id)->select('id')->get()->pluck('id')->all(),
            'sharing_user_group_id' => $groupId,
        ];
        $sharing = $this->service->store($input, $user);

        $this->assertNotEmpty($sharing);

        $sharingRecords = SharingRecord::query()->where('user_id', $user->id)
            ->whereIn('record_id', $input['record_ids'])
            ->where('sharing_id', $sharing->id)
            ->get();

        $this->assertGreaterThan(0, $sharingRecords->count());
        $this->assertCount(count($input['record_ids']), $sharingRecords);
    }
}
