<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\CaseInsident;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CaseInsidentCorrectiveAction;
use App\Models\CaseInsidentImplementation;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function listCaseNotDone(Request $request)
    {
        if ($request->ajax()) {

            $data = CaseInsident::where('status', 'WAITING');

            if (auth()->user()->role == 'user' || auth()->user()->role == 'users') $data->where('created_by', auth()->user()->id);
            // if (auth()->user()->role == 'user' || auth()->user()->role == 'supervisor') $data->where('created_by', auth()->user()->id);

            $data->latest();
            return DataTables::of($data)
                ->addColumn('status', function ($row) {
                    return $row->status;
                })
                ->addColumn('chronology', function ($row) {
                    return $row->chronology;
                })
                ->addColumn('patientName', function ($row) {
                    return $row->patient_name;
                })
                ->addColumn('medrecNumber', function ($row) {
                    return $row->medrec_number;
                })
                ->addColumn('reportDate', function ($row) {
                    return Carbon::parse($row->reporting_date)->format('d/m/y');
                })
                ->addColumn('insidentDate', function ($row) {
                    return Carbon::parse($row->insident_date)->format('d/m/y');
                })
                ->addColumn('insidentTime', function ($row) {
                    return $row->insident_time;
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('H:i:s');
                })
                ->addColumn('action', function ($row) {
                    $action = '';
                    if (!auth()->user()->isUser()) {
                        $action .= '<a class="btn btn-sm btn-outline-success me-1" href="' . route('dashboard.detail-case', ['id' => Crypt::encrypt($row->id)]) . '/?act=confirm" role="button"><i class="bi bi-clipboard-check"></i></a>';
                    }
                    $action .= '<a class="btn btn-sm btn-outline-primary" href="' . route('dashboard.detail-case', ['id' => Crypt::encrypt($row->id)]) . '" role="button"><i class="bi bi-search"></i></a>';

                    return $action;
                })
                ->orderColumn('DT_RowIndex', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()->make(true);
        }
    }

    public function implementationAttachmentData(Request $request)
    {
        if ($request->ajax()) {
            $data = CaseInsidentImplementation::with('implementation', 'case')
                ->whereNotNull('attachment');
            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->has('case_id')) {
                        $query->where('case_id', $request->case_id);
                    }
                    $query->latest();
                })
                ->addColumn('fileType', function ($row) {
                    return $row->implementation->name;
                })
                ->addColumn('fileName', function ($row) {
                    $fileName = explode('/', $row->attachment);
                    return end($fileName);
                })
                ->addColumn('action', function ($row) {
                    $action = '<a class="btn btn-sm btn-danger delete_imp" data-id="' . $row->id . '" role="button"><i class="bi bi-trash"></i></a>';
                    return $action;
                })
                ->orderColumn('DT_RowIndex', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()->make(true);
        }
    }

    public function corectiveActionAttachmentData(Request $request)
    {
        if ($request->ajax()) {
            $data = CaseInsidentCorrectiveAction::with('case')
                ->whereNotNull('attachment');
            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->has('case_id')) {
                        $query->where('case_id', $request->case_id);
                    }
                    $query->latest();
                })
                ->addColumn('fileDesc', function ($row) {
                    return $row->desc;
                })
                ->addColumn('fileName', function ($row) {
                    $fileName = explode('/', $row->attachment);
                    return end($fileName);
                })
                ->addColumn('action', function ($row) {
                    $action = '<a class="btn btn-sm btn-danger delete_ca" data-id="' . $row->id . '" role="button"><i class="bi bi-trash"></i></a>';
                    return $action;
                })
                ->orderColumn('DT_RowIndex', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()->make(true);
        }
    }
}
