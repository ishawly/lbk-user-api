<?php

namespace Tests\Feature\Services;

use App\Models\Record;
use App\Models\Sharing;
use App\Models\SharingRecord;
use App\Models\SharingUserGroup;
use App\Models\SharingUserGroupDetail;
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
            'name'                  => 'test_' . fake()->text(50),
            'record_ids'            => Record::query()->where('user_id', $user->id)->select('id')->get()->pluck('id')->toArray(),
            'sharing_user_group_id' => $groupId,
        ];
        $sharing = $this->service->store($input, $user);

        // 验证分摊是否创建成功
        $this->assertNotEmpty($sharing);

        // 验证用户交易记录是否加入分摊
        $sharingRecords = SharingRecord::query()->where('user_id', $user->id)
            ->whereIn('record_id', $input['record_ids'])
            ->where('sharing_id', $sharing->id)
            ->get();

        $this->assertGreaterThan(0, $sharingRecords->count());
        $this->assertCount(count($input['record_ids']), $sharingRecords);

        // 验证分摊用户
        $groupDetailCnt = SharingUserGroupDetail::where('sharing_user_group_id', $groupId)->count();
        $this->assertCount($groupDetailCnt, $sharing->users()->get());

        return $sharing;
    }

    /**
     * @depends testStoreSharing
     */
    public function testUpdateSharingWhenFirstJoinIn(Sharing $sharing)
    {
        $existsSharingUsers = $sharing->users()->get();
        $group              = SharingUserGroup::findOrFail($sharing->sharing_user_group_id);

        $groupMember = $group->details()
            ->whereNotIn('user_id', $existsSharingUsers->pluck('id'))
            ->first();
        $this->assertNotEmpty($groupMember);

        // 准备更新数据
        $records = Record::query()->where('user_id', $groupMember->user_id)
            ->orderByDesc('id')
            ->limit(10)
            ->get();
        $user = User::find($groupMember->user_id);
        $input = ['record_ids' => $records->pluck('id')];
        $this->service->update($sharing, $input, $user);

        $sharing->refresh();
        $this->assertEquals($records->count(), $sharing->records()->where('user_id', $user->id)->count());
    }
}
