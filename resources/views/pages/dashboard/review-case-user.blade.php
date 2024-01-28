@extends('layout.main')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <style>
        .table tr,
        .table td,
        .table th,
        .table thead,
        .table tbody {
            background-color: #ffffff !important;
        }

        #table tbody td {
            cursor: pointer;
        }

        #table tbody td:hover {
            background-color: #7b95e4 !important;
        }
    </style>
@endpush

@section('content')
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="d-flex justify-content-end">

                {{-- <a href="{{ route('dashboard.review-case.download-pdf') }}" class="text-decoration-none">Download All
                    (PDF)</a> --}}
            </div>
            <div class="card mb-3" style="background-color: #000000!important;">
                <div class="table-responsive" style="background-color: #557ae9!important;">

                    <table id="table" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center" style="vertical-align: middle">No
                                </th>
                                <th class="text-center">Tanggal Kejadian</th>
                                <th class="text-center">Tanggal Pelapor</th>
                                <th class="text-center">Nama Pelapor</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Nama Pasien</th>
                                <th class="text-center">No. MedRec</th>
                                <th class="text-center">Status</th>
                            </tr>
                            <tr>
                                <th class="text-end">|</th>
                                <th class="text-end">|</th>
                                <th class="text-end">|</th>
                                <th class="text-end">|</th>
                                <th class="text-end">|</th>
                                <th class="text-end">|</th>
                                <th class="text-end">|</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cases as $case)
                                @php($category = [])
                                @foreach ($case->insident_levels as $level)
                                    @php(array_push($category, $level->level->name))
                                @endforeach
                                <tr data-id="{{ \Illuminate\Support\Facades\Crypt::encrypt($case->id) }}"
                                    class="text-center">
                                    <td>{{ $loop->iteration }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($case->insident_date)->format('d/m/y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($case->reporting_date)->format('d/m/y') }}</td>
                                    <td>{{ $case->reporter_name }}</td>
                                    <td>{{ empty($category) ? '-' : implode(', ', $category) }}</td>
                                    <td>{{ $case->patient_name }}</td>
                                    <td>{{ $case->medrec_number }}</td>
                                    <td>
                                        {{ $case->status == 'VERIFIED' ? 'Sudah diverifikasi supervisor' : 'Belum diverifikasi supervisor' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/yjdt.js') }}"></script>
    <script>
            const table = new DataTable('#table');

        // $(document).ready(function() {
        //     const table = new DataTable('#table');

        //     $(document).on('click', '#table tbody td', function() {
        //         const caseId = $(this).parent().data('id');
        //         location.href = `{{ url('/dashboard/review-case/detail') }}/${caseId}`
        //     });
        // });
    </script>
@endpush
