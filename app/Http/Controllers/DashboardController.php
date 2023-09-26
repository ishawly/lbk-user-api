<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Services\RecordService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, RecordService $recordService)
    {
        $size       = 10000;
        $type       = $request->get('type');
        $categoryId = $request->get('category_id');
        $trxStart   = $request->get('transaction_at_start');
        $trxEnd     = $request->get('transaction_at_end');
        $query      = Record::with('category:id,name')->where('user_id', $request->user()->id);

        $type       and $query->where('type', $type);
        $categoryId and $query->where('category_id', $categoryId);
        $trxStart   and $query->where('transaction_at', '>=', $trxStart);
        $trxEnd     and $query->where('transaction_at', '<=', $trxEnd);

        $data = [
            'types'   => $recordService->getTypes(),
            'records' => $query->paginate($size),
        ];

        return view('dashboard', $data);
    }
}
