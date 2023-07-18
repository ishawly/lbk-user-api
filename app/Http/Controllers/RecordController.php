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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $size       = (int) $request->input('size', 10);
        $type       = (int) $request->input('type');
        $categoryId = (int) $request->input('category_id');
        $keyword    = $request->input('keyword');

        $transactionAtStart = $request->input('transaction_at_start');
        $transactionAtEnd   = $request->input('transaction_at_end');

        $size <= 0 and $size = 10;

        $query = Record::query()->where('user_id', $request->user()->id);

        $type                 and $query->where('type', $type);
        $categoryId           and $query->where('category_id', $categoryId);
        $keyword              and $query->where('reciprocal_name', 'like', "%{$keyword}%");
        $transactionAtStart and $query->where('transaction_at', '>=', $transactionAtStart);
        $transactionAtEnd   and $query->where('transaction_at', '<=', $transactionAtEnd);

        $data = $query->paginate($size);

        return $this->success(new RecordCollection($data));
    }

    public function create(Request $request)
    {
        return view('record.store');
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
