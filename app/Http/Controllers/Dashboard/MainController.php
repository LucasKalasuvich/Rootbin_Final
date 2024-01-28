<?php

namespace App\Http\Controllers\Dashboard;

use PDF;
use App\Models\CaseStatus;
use Illuminate\Support\Str;
use App\Models\CaseInsident;
use Illuminate\Http\Request;
use App\Models\InsidentLevel;
use App\Models\CaseInsidentPIC;
use App\Models\CaseRelatedUnit;
use App\Models\CaseRelatedStaff;
use App\Models\CaseInsidentLevel;
use App\Models\CaseInsidentStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\ImplementationAttachment;
use App\Models\CaseInsidentImplementation;
use App\Models\CaseInsidentCorrectiveAction;

class MainController extends Controller
{
    public function index()
    {
        $breadcrumb = match (auth()->user()->role) {
            'admin' => 'DASHBOARD ADMIN',
            'suoervisor' => 'DASHBOARD SUPERVISOR',
            'user' => 'DASHBOARD USER',
            'users' => 'DASHBOARD USER',
            default => 'DASHBOARD'
        };

        $grafik = collect([]);

        $month = ['January', 'February', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        foreach ($month as $key => $value) {
            $grafik[$value] =
                InsidentLevel::withCount(['insident_levels as total_case' => function ($q) use ($key) {
                    $q->whereMonth('created_at', (int) $key + 1)->whereYear('created_at', date('Y'));
                }])->get()->map(function ($q) {
                    return [
                        'name' => $q->name,
                        'total_case' => $q->total_case
                    ];
                });
        }

        return view('pages.dashboard.index', [
            'breadcrumb' => $breadcrumb,
            'grafik' => json_encode($grafik),
            'levelName' => InsidentLevel::all()->pluck('name')
        ]);
    }

    public function createCase()
    {
        $breadcrumb = match (auth()->user()->role) {
            'admin' => 'FORM INPUT (ADMIN)',
            'supervisor' => 'FORM INPUT (SUPERVISOR)',
            'user' => 'FORM INPUT (USER)',
            'users' => 'FORM INPUT (USER)',
            default => 'FORM INPUT'
        };
        return view('pages.dashboard.input-case', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function reviewCase()
    {
        $case = CaseInsident::orderBy('id', 'DESC')->get();
        return view('pages.dashboard.review-case', [
            'breadcrumb' => 'REVIEW CASE',
            'cases' => $case
        ]);
    }

    public function reviewCaseUser()
    {
        $case = CaseInsident::where('created_by', auth()->user()->id)->get();
        // $case = CaseInsident::orderBy('id', 'DESC')->get();
        return view('pages.dashboard.review-case-user', [
            'breadcrumb' => 'ALL CASE USER',
            'cases' => $case
        ]);
    }

    public function reviewCaseSupervisor(Request $request)
    {
        $case = CaseInsident::orderBy('id', 'DESC')->get();
        
        return view('pages.dashboard.review-case-supervisor', [
            'breadcrumb' => 'CASE',
            'cases' => $case
        ]);
    }

    public function reviewCaseDetail($id)
    {
        $case = CaseInsident::find(Crypt::decrypt($id));

        return view('pages.dashboard.review-case-detail', [
            'breadcrumb' => 'REVIEW CASE',
            'case' => $case,
            'levels' => InsidentLevel::all(),
            'statuses' => CaseStatus::all(),
            'implementations' => ImplementationAttachment::all(),
        ]);
    }

    public function detailCase(Request $request, $id)
    {
        $verif = false;
        $breadcrumb = 'DETAIL CASE';

        if ($request->has('act') && $request->act == 'confirm') {
            $breadcrumb = 'CASE VERIFICATION';
            $verif = true;
        }

        $case = CaseInsident::where('id', Crypt::decrypt($id))->firstOrFail();

        return view('pages.dashboard.detail-case', [
            'breadcrumb' => $breadcrumb,
            'case' => $case,
            'verification' => $verif,
        ]);
    }

    public function storeCase(Request $request)
    {
        if (!$request->has('act') && !$request->act == 'verification') {
            $request->validate([
                "name" => "required",
                "medrec" => "required",
                "insident_date" => "required",
                "insident_time" => "required",
                "chronology" => "required",
                "units"    => "required|array",
                "units.*"  => "required|string",
                "staffs"    => "required|array",
                "staffs.*"  => "required|string",
            ], [
                'name.required' => 'Nama pasien wajib diisi.',
                'medrec.required' => 'No. MedRec wajib diisi.',
                'insident_date.required' => 'Tanggal insiden wajib diisi.',
                'insident_time.required' => 'Jam insiden wajib diisi.',
                'chronology.required' => 'Kronologi wajib diisi.',
                'units.required' => 'Unit terkait wajib diisi.',
                'staff.required' => 'Staf terkait wajib diisi.',
            ]);
        }

        try {
            DB::beginTransaction();
            $message = 'New case created successfully.';
            $status = 'WAITING';

            if ($request->has('verif_insident') && (int) $request->verif_insident == 1) {
                $status = 'VERIFIED';
            }

            if ($request->has('id')) {
                if (!$request->has('act') && !$request->act == 'verification') {
                    $case = CaseInsident::find($request->id);

                    $case->update([
                        'status' => $status,
                        'patient_name' => $request->name,
                        'medrec_number' => $request->medrec,
                        'reporting_date' => $request->report_date,
                        'insident_date' => $request->insident_date,
                        'insident_time' => $request->insident_time,
                        'chronology' => $request->chronology,
                        'additional_information' => $request->additional_info,
                        // 'riskman_number' => $request->riskman_number,
                        'verified_by' => $status == 'VERIFIED' ? auth()->user()->id : NULL,
                    ]);

                    if ($case) {
                        CaseRelatedUnit::where('case_id', $case->id)->delete();
                        CaseRelatedStaff::where('case_id', $case->id)->delete();
                    }

                    $message = 'Case updated successfully.';
                } else {
                    $case = CaseInsident::find($request->id);

                    $case->update([
                        'status' => $status,
                        'additional_information' => $request->additional_info,
                        // 'riskman_number' => $request->riskman_number,
                        'verified_by' => $status == 'VERIFIED' ? auth()->user()->id : NULL,
                    ]);

                    $message = 'Case verification successfully.';
                }
            } else {

                $case = CaseInsident::create([
                    'status' => $status,
                    'patient_name' => $request->name,
                    'medrec_number' => $request->medrec,
                    'reporting_date' => $request->report_date,
                    'insident_date' => $request->insident_date,
                    'insident_time' => $request->insident_time,
                    'chronology' => $request->chronology,
                    'reporter_name' => auth()->user()->name,
                    'created_by' => auth()->user()->id,
                ]);
            }

            if (!$request->has('act') && !$request->act == 'verification') {
                if ($case) {
                    if (is_array($request->units) && !empty($request->units)) {
                        foreach ($request->units as $key => $value) {
                            CaseRelatedUnit::create(['case_id' => $case->id, 'name' => $value]);
                        }
                    }

                    if (is_array($request->staffs) && !empty($request->staffs)) {
                        foreach ($request->staffs as $key => $value) {
                            CaseRelatedStaff::create(['case_id' => $case->id, 'name' => $value]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('dashboard.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('exception', 'Error: ' . $e->getMessage());
        }
    }

    public function storeCaseInsidentDetailFile(Request $request)
    {
        DB::beginTransaction();
        if ($request->file('file')) {
            try {
                $file = $request->file('file');
                $case = CaseInsident::find($request->case_id);
                $imp_attach = ImplementationAttachment::find($request->imp_id);
                $alreadyAvailable = CaseInsidentImplementation::where('case_id', $case->id)->where('implementation_id', $request->imp_id)->first();

                $destinationPath = 'public/upload/implementation/' . Str::slug($imp_attach->name);
                $fileName = strtotime(now()) . '-' . strtoupper(Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))) . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $docPath = $file->storeAs($destinationPath, $fileName);

                if ($alreadyAvailable) {
                    $alreadyAvailable->update(['attachment' => $docPath]);
                    if (Storage::exists($alreadyAvailable->attachment)) Storage::delete($alreadyAvailable->attachment);
                } else {
                    CaseInsidentImplementation::create([
                        'case_id' => $case->id,
                        'implementation_id' => $imp_attach->id,
                        'attachment' => $docPath
                    ]);
                }

                // $imp_name = Str::replace('.', '', Str::snake($responseData->implementation->name));
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'data' => CaseInsident::find($case->id)
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => 412,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function storeCaseInsidentDetail(Request $request)
    {
        if ($request->has('category')) {
            $model = match ($request->category) {
                'level' => [
                    'class' => CaseInsidentLevel::class,
                    'column' => 'level_id'
                ],
                'status' => [
                    'class' => CaseInsidentStatus::class,
                    'column' => 'status_id'
                ],
                'implementation' => [
                    'class' => CaseInsidentImplementation::class,
                    'column' => 'implementation_id'
                ],
                'chronology' => [
                    'class' => CaseInsident::class,
                    'column' => "chronology"
                ],
                default => NULL
            };
        }

        if ($model == NULL) {
            return back();
        }

        try {
            DB::beginTransaction();
            if ($request->has('category')) {
                if ($request->category != 'chronology') {
                    $old = $model['class']::where('case_id', $request->case_id)->get();

                    if (!empty($old) || $old->isNotEmpty()) {
                        if (!empty($request->unchecks)) {
                            foreach ($request->unchecks as $key => $value) {
                                $item = $model['class']::where('case_id', $request->case_id)
                                    ->where($model['column'], $value)->first();

                                if ($item) {
                                    if ($request->category == 'implementation' && $item->attachment != NULL && Storage::exists($item->attachment)) {
                                        Storage::delete($item->attachment);
                                    }

                                    $item->delete();
                                }
                            }
                        }
                    }

                    if (!empty($request->checks)) {
                        foreach ($request->checks as $key => $value) {
                            $availableData = $model['class']::where('case_id', $request->case_id)
                                ->where($model['column'], $value)->first();
                            if (!$availableData) {
                                $model['class']::create([
                                    'case_id' => $request->case_id,
                                    $model['column'] => $value
                                ]);
                            }
                        }
                    }
                } else {
                    $model['class']::where('id', $request->case_id)->update([
                        $model['column'] => $request->chronology
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function reviewCasePDFDownload()
    {
        $cases = CaseInsident::all();

        $pdf = PDF::loadview('pages.dashboard.pdf.case-pdf', ['cases' => $cases]);

        return $pdf->download('review-case.pdf');
    }

    public function reviewCaseDetailPDFDownload($id)
    {

        $cases = CaseInsident::where('id', $id)->get();
        // $imagePath = public_path('picture/ramsay.png');
        // $type = pathinfo($imagePath, PATHINFO_EXTENSION);
        // $data = file_get_contents($imagePath);
        // $pic = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $pdf = PDF::loadview('pages.dashboard.pdf.case-detail-pdf', ['cases' => $cases]);
        $pdf->set_paper('A4', 'potrait');

        return $pdf->download('CASE SUMMARY.pdf');
    }

    public function storeCaseInsidentDetailPIC(Request $request)
    {
        DB::beginTransaction();
        try {
            $alreadyPic = CaseInsidentPIC::where('case_id', $request->case_id)->first();

            if ($alreadyPic) {
                $alreadyPic->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'due_date' => $request->due_date,
                ]);
            } else {
                CaseInsidentPIC::create([
                    'case_id' => $request->case_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'due_date' => $request->due_date,
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed'
            ], 500);
        }
    }

    public function storeCaseInsidentDetailCA(Request $request)
    {
        DB::beginTransaction();
        if ($request->file('file')) {
            try {
                $file = $request->file('file');
                $case = CaseInsident::find($request->case_id);
                $destinationPath = 'public/upload/corrective-action/' . Str::slug($request->desc);
                $fileName = strtotime(now()) . '-' . strtoupper(Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))) . '.' . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $docPath = $file->storeAs($destinationPath, $fileName);

                $data = CaseInsidentCorrectiveAction::create([
                    'case_id' => $case->id,
                    'desc' => $request->desc,
                    'attachment' => $docPath
                ]);

                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'data' => CaseInsident::find($data->case_id)
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                if (Storage::exists($docPath)) Storage::delete($docPath);
                return response()->json([
                    'status' => 412,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function deleteIMP(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = CaseInsidentImplementation::find($request->imp_id);
            $attachment = DB::table('case_insident_implementations')->find($request->imp_id)->attachment;
            if ($data) {
                if (Storage::exists($attachment)) Storage::delete($attachment);
                $data->delete();
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'data' => CaseInsident::find($data->case_id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 412,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteCA(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = CaseInsidentCorrectiveAction::find($request->ca_id);
            $attachment = DB::table('case_insident_corrective_actions')->where('id', $data->id)->first()->attachment;
            if ($data) {
                if (Storage::exists($attachment)) Storage::delete($attachment);
                $data->delete();
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'data' => CaseInsident::find($data->case_id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 412,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
