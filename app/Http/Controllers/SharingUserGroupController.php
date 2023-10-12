<?php

namespace App\Http\Controllers;

use App\Http\Requests\SharingUserGroup\StoreSharingUserGroupRequest;
use App\Models\SharingUserGroup;
use App\Models\User;
use Illuminate\Http\Request;

class SharingUserGroupController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $users = User::query()->select(['id', 'name'])
            ->orderBy('id')
            ->take(10)
            ->get();

        return view('sharing-user-group.create', ['users' => $users]);
    }

    public function store(StoreSharingUserGroupRequest $request)
    {
        $input = $request->validated();

        dump($input);
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
