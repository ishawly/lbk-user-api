<?php

namespace App\Http\Controllers;

use App\Http\Requests\SharingUserGroup\StoreSharingUserGroupRequest;
use App\Models\SharingUserGroup;
use App\Models\User;
use App\Services\SharingUserGroupService;
use Illuminate\Http\Request;

class SharingUserGroupController extends Controller
{
    public function __construct(
        public SharingUserGroupService $sharingUserGroupService
    )
    {

    }
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $users = User::query()->select(['id', 'name'])
            ->where('id', '>', 1000)
            ->where('id', '!=', $request->user()->id)
            ->orderBy('id')
            ->take(10)
            ->get();

        return view('sharing-user-group.create', [
            'users' => $users,
            'user'  => $request->user(),
        ]);
    }

    public function store(StoreSharingUserGroupRequest $request)
    {
        $input = $request->validated();
        $this->sharingUserGroupService->store($input, $request->user());

        return redirect()->route('user-groups.create')->with('user-groups.store.success', '创建成功!');
    }

    public function show(SharingUserGroup $sharingUserGroup)
    {
        //
    }

    public function edit(SharingUserGroup $sharingUserGroup)
    {
        //
    }

    public function update(Request $request, SharingUserGroup $sharingUserGroup)
    {
        //
    }

    public function destroy(SharingUserGroup $sharingUserGroup)
    {
        //
    }
}
