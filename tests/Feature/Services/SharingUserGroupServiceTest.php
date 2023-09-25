<?php

namespace Tests\Feature\Services;

use App\Models\Sharing;
use App\Models\SharingUserGroupDetail;
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
}
