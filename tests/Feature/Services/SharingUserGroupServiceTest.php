<?php

namespace Tests\Feature\Services;

use App\Models\Sharing;
use App\Models\SharingUserGroupDetail;
use App\Models\User;
use App\Services\SharingUserGroupService;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class SharingUserGroupServiceTest extends TestCase
{
    private SharingUserGroupService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new SharingUserGroupService();
    }

    public function testCheckUserGroupForSharingExists(): void
    {
        $sharing = Sharing::latest()->first();
        $flag    = $this->service->has($sharing->sharing_user_group_id);

        $this->assertTrue($flag);
    }

    public function testCheckUserGroupForSharingNotExists(): void
    {
        $flag = $this->service->has(PHP_INT_MAX);

        $this->assertFalse($flag);
    }

    public function testAUserJoinedUserGroupForSharing(): void
    {
        $detail = SharingUserGroupDetail::latest('id')->first();
        $this->assertIsObject($detail);

        $flag = $this->service->has($detail->sharing_user_group_id, $detail->user_id);
        $this->assertTrue($flag);
    }

    public function testStoreGroupWithTwoUsers(): void
    {
        $userCount = 2;
        $users     = User::query()
            ->where('id', '>', 1000)
            ->orderBy('id')
            ->take($userCount)
            ->get();
        $this->assertCount($userCount, $users);

        $input = [
            'name'           => fake()->text(100),
            'user_ids'       => $users->pluck('id'),
            'sharing_ratios' => [50, 50],
        ];
        $group = $this->service->store($input, $users->first());
        $this->assertGreaterThan(0, $group->id);

        collect($input['user_ids'])->combine($input['sharing_ratios'])
            ->each(function ($ratio, $userId) use ($group) {
                $cnt = SharingUserGroupDetail::query()
                    ->where('sharing_user_group_id', $group->id)
                    ->where('user_id', $userId)
                    ->count();
                $this->assertEquals(1, $cnt);
            });
    }
}
