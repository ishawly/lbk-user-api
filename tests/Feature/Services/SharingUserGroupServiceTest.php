<?php

namespace Tests\Feature\Services;

use App\Models\Sharing;
use App\Models\SharingUserGroupDetail;
use App\Services\SharingUserGroupService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SharingUserGroupServiceTest extends TestCase
{
    private SharingUserGroupService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new SharingUserGroupService();
    }

    public function test_check_user_group_for_sharing_exists(): void
    {
        $sharing = Sharing::latest()->first();
        $flag = $this->service->has($sharing->sharing_user_group_id);

        $this->assertTrue($flag);
    }

    public function test_check_user_group_for_sharing_not_exists(): void
    {
        $flag = $this->service->has(PHP_INT_MAX);

        $this->assertFalse($flag);
    }

    public function test_a_user_joined_user_group_for_sharing(): void
    {
        $detail = SharingUserGroupDetail::latest('id')->first();
        $this->assertIsObject($detail);

        $flag = $this->service->has($detail->sharing_user_group_id, $detail->user_id);
        $this->assertTrue($flag);
    }
}
