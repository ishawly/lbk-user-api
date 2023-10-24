<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sharing\StoreSharingRequest;
use App\Http\Requests\Sharing\UpdateSharingRequest;
use App\Models\Record;
use App\Models\Sharing;
use App\Services\RecordService;
use App\Services\SharingService;
use Illuminate\Http\Request;

class SharingController extends Controller
{
    public function __construct(
        public SharingService $sharingService
    )
    {

    }
    public function index(Request $request, RecordService $service)
    {

        return view('sharing.index');
    }

    public function create()
    {
        //
    }

    public function store(StoreSharingRequest $request)
    {
        $input = $request->validated();
        $sharing = $this->sharingService->store($input, $request->user());

        // todo
    }

    public function show(Sharing $sharing)
    {
        //
    }

    public function edit(Sharing $sharing)
    {
        //
    }

    public function update(UpdateSharingRequest $request, Sharing $sharing)
    {
        //
    }

    public function destroy(Sharing $sharing)
    {
        //
    }
}
