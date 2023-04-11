<?php

namespace App\Http\Controllers;

use App\Http\Requests\Record\StoreRecordRequest;
use App\Http\Requests\Record\UpdateRecordRequest;
use App\Http\Resources\Record\RecordResource;
use App\Models\Record;
use App\Services\RecordService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecordRequest $request, RecordService $recordService)
    {
        $data   = $request->validated();
        $record = $recordService->store($data, $request->user());

        return $this->success(new RecordResource($record));
    }

    /**
     * Display the specified resource.
     */
    public function show(Record $record)
    {
        if ($record->user_id != Auth::user()->id) {
            return $this->failed('Not Found', Response::HTTP_NOT_FOUND);
        }

        return $this->success(new RecordResource($record));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecordRequest $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        //
    }
}
