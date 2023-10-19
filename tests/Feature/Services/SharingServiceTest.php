<?php

namespace Tests\Feature\Services;

use App\Models\Record;
use App\Models\Sharing;
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

    public function testStoreSharing(): Sharing
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

        return $sharing;
    }

    /**
     * @depends testStoreSharing
     */
    public function testUpdateSharingWhenFirstJoinIn(Sharing $sharing)
    {
        $existsSharingUsers = $sharing->users;
        $group              = SharingUserGroup::findOrFail($sharing->sharing_user_group_id);
        $this->assertNotEmpty($group);

        $groupMember = $group->details()
            ->whereNotIn('user_id', $existsSharingUsers->pluck('id'))
            ->first();
        $this->assertNotEmpty($groupMember);

        $records = Record::query()->where('user_id', $groupMember->user_id)
            ->orderByDesc('id')
            ->limit(10)
            ->get();
        $user = User::find($groupMember->user_id);

        $input = ['record_ids' => $records->pluck('id')];
        $this->service->update($sharing, $input, $user);

        $sharing->refresh();
        $this->assertEquals($records->count(), $sharing->records()->count());
    }
}
