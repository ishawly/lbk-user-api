<?php

namespace App\Http\Controllers;

use App\Services\RecordService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, RecordService $recordService)
    {
        $query = $recordService->getRecordQueryBuilder($request);
        $query->where('user_id', $request->user()->id)->with('category:id,name');

        $records = $query->get();

        return view('dashboard', [
            'records' => $records,
        ]);
    }
}
