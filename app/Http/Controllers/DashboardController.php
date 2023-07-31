<?php

namespace App\Http\Controllers;

use App\Http\Resources\Record\RecordCollection;
use App\Http\Resources\Record\RecordResource;
use App\Services\RecordService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, RecordService $recordService)
    {
        $query = $recordService->getRecordQueryBuilder($request);
        $query->where('user_id', $request->user()->id)->with('category:id,name');

        $paginate = $query->paginate();

//        $collection = RecordResource::collection($paginate);

        $collection = new RecordCollection($paginate);

        return view('dashboard', [
            'records' => $collection->items(),
        ]);
    }
}
