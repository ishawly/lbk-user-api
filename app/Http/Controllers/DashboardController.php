<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Services\RecordService;
use App\Services\SharingUserGroupService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private RecordService $recordService;
    private SharingUserGroupService $sharingUserGroupService;

    public function __construct(RecordService $recordService, SharingUserGroupService $sharingUserGroupService)
    {
        $this->recordService           = $recordService;
        $this->sharingUserGroupService = $sharingUserGroupService;
    }

    public function index(Request $request)
    {
        $userId     = $request->user()->id;
        $size       = 10000;
        $type       = $request->get('type');
        $categoryId = $request->get('category_id');
        $trxStart   = $request->get('transaction_at_start');
        $trxEnd     = $request->get('transaction_at_end');
        $query      = Record::with('category:id,name')->where('user_id', $userId);

        $type       and $query->where('type', $type);
        $categoryId and $query->where('category_id', $categoryId);
        $trxStart   and $query->where('transaction_at', '>=', $trxStart);
        $trxEnd     and $query->where('transaction_at', '<=', $trxEnd);

        $query->orderByDesc('id');

        $data = [
            'types'      => $this->recordService->getTypes(),
            'userGroups' => $this->sharingUserGroupService->getByUserId($userId),
            'records'    => $query->paginate($size),
        ];

        return view('dashboard', $data);
    }
}
