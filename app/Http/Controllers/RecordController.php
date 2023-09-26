<?php

namespace App\Http\Controllers;

use App\Http\Requests\Record\StoreRecordRequest;
use App\Http\Requests\Record\UpdateRecordRequest;
use App\Http\Resources\Record\RecordCollection;
use App\Http\Resources\Record\RecordResource;
use App\Models\Record;
use App\Services\RecordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RecordController extends Controller
{
    public function showRecords(Request $request)
    {
        return view('record.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, RecordService $recordService)
    {
        $size                = (int) $request->input('size', 10);
        $size <= 0 and $size = 10;

        $query = $recordService->getRecordQueryBuilder($request);
        $query->where('user_id', $request->user()->id)->with('category:id,name');

        $data = $query->paginate($size);

        return $this->success(new RecordCollection($data));
    }

    public function create(Request $request, RecordService $service)
    {
        $data = [
            'types' => $service->getTypes(),
        ];

        return view('record.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecordRequest $request, RecordService $recordService)
    {
        $data = $request->validated();
        $recordService->store($data, $request->user());

        return redirect()->route('records.create')->with('record.store.success', '记录成功!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Record $record)
    {
        $this->canModify($record->user_id);

        return $this->success(new RecordResource($record));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecordRequest $request, Record $record, RecordService $recordService)
    {
        $this->canModify($record->user_id);

        $data = $request->validated();
        $recordService->update($record, $data);

        return $this->success(new RecordResource($record));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        $this->canModify($record->user_id);

        $record->delete();

        return $this->deleted();
    }

    private function canModify($userId)
    {
        if ($userId != Auth::user()->id) {
            $response = $this->failed('Not Found', Response::HTTP_NOT_FOUND);
            abort($response);
        }
    }
}
