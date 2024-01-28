@extends('layout.main')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
@endpush

@section('content')
    <div class="row mt-1 pb-5">
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
            </div>
        @endif
        <div class="col-md-2">
            <div class="d-flex flex-column">
                <a href="{{ route('dashboard.new-case') }}" class="btn border border-dark m-2 bg-white text-decoration-none"
                    style="color:#102d84"><i class="bi bi-clipboard-plus-fill float-start"></i> New Case</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('dashboard.review-case') }}"
                        class="btn border border-dark m-2 bg-white text-decoration-none" style="color:#102d84">
                        <i class="bi bi-search float-start"></i> Review Case</a>
                @endif

                @if (auth()->user()->role == 'users')

                    <a href="{{ route('dashboard.review-case-user') }}"
                        class="btn border border-dark m-2 bg-white text-decoration-none" style="color:#102d84">
                        <i class="bi bi-search float-start"></i>Case</a>
                @endif

                @if (auth()->user()->role == 'supervisor')

                    <a href="{{ route('dashboard.review-case-supervisor') }}"
                        class="btn border border-dark m-2 bg-white text-decoration-none" style="color:#102d84">
                        <i class="bi bi-search float-start"></i>Case</a>
                @endif
            </div>
        </div>
        <div class="col-md-10">
            <div class="card mb-3">
                <div class="card-header text-white" style="background-color: #405aa7">
                    <h5>LIST CASE NOT DONE</h5>
                </div>
                <div class="card-body table-responsive">
                    <table id="list-not-done" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Action</th>
                                <th>Nomor Medrec</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Pelaporan</th>
                                <th>Tanggal Insiden</th>
                                <th>Jam Insiden</th>
                                <th>Jam Pelaporan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            @if (auth()->user()->role == 'admin')
                <div class="card">
                    <div class="card-header text-white" style="background-color: #405aa7">
                        <h5>SUMMARY TOTAL CASE</h5>
                    </div>
                    <div class="card-body">
                        <div id="grafik">
                            <div class="d-flex justify-content-center" style="height: 2rem;">
                                <div class="spinner-border text-secondary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <p class="text-center mt-2 fst-italic text-secondary">Loading . . .</p>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="{{ asset('js/yjdt.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        $(document).ready(function() {

            Table('#list-not-done').init({
                url: `{{ route('ajax.datatable.list-case-not-done') }}`,
            }, [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-left'
                },
                {
                    data: 'action',
                    orderable: false,
                    searching: false
                },
                {
                    data: 'medrecNumber',
                    orderable: false,
                },
                {
                    data: 'patientName',
                    orderable: false
                },
                {
                    data: 'reportDate',
                    orderable: false,
                },
                {
                    data: 'insidentDate',
                    orderable: false,
                },
                {
                    data: 'insidentTime',
                    orderable: false,
                },
                {
                    data: 'created_at',
                    orderable: false,
                },
            ]);

            let series = [];

            $.map({!! $levelName !!}, function(x, y) {
                let data = {
                    name: x,
                    data: []
                };

                $.map({!! $grafik !!}, function(e, i) {
                    $.map(e, function(f, j) {
                        if (Object.values(data).includes(f.name)) {
                            data.data.push(f.total_case);
                        }
                    });
                });

                series.push(data);
            });

            Highcharts.chart('grafik', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Grafik Insiden Bulanan (' + new Date().getFullYear() + ')'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: ['January', 'February', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                        'September', 'Oktober', 'November', 'Desember'
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Insiden Bulanan (' + new Date().getFullYear() + ')'
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: false
                    }
                },
                series: series
            });
        });
    </script>
@endpush
