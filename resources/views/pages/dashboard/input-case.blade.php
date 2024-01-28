@extends('layout.main')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    @php
        $listUnit = ['IT', 'QMR', 'SKJ', 'ADVC'];
        $listStaff = ['Agung', 'Bayu', 'Candra', 'Dodi'];
    @endphp
    <div class="row mt-1 pb-2">
        <div class="border border-dark px-4 pt-4">
            @if (Session::has('exception'))
                <div class="alert alert-danger">
                    {{ Session::get('exception') }}
                    @php
                        Session::forget('exception');
                    @endphp
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Whoops!</strong> mohon periksa lagi inputan anda.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form id="newCase" action="{{ route('dashboard.store-case') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Nama Pasien<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Nama Pasien">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="medrec" class="col-sm-2 col-form-label">Nomor Medrec<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" class="form-control @error('medrec') is-invalid @enderror" id="medrec"
                            name="medrec" placeholder="Nomor Medrec">
                        @if ($errors->has('medrec'))
                            <span class="text-danger">{{ $errors->first('medrec') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tgl_pelaporan" class="col-sm-2 col-form-label">Tanggal Pelaporan</label>
                    <div class="col-sm-10 col-md-2">
                        {{-- <input type="date" class="form-control" id="tgl_pelaporan" value="{{ date('Y-m-d') }}"> --}}
                        <input type="date" class="form-control @error('report_date') is-invalid @enderror"
                            id="tgl_pelaporan" name="report_date">
                        @if ($errors->has('report_date'))
                            <span class="text-danger">{{ $errors->first('report_date') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tgl_insiden" class="col-sm-2 col-form-label">Tanggal Insiden<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-2">
                        <input type="date" class="form-control @error('insident_date') is-invalid @enderror"
                            id="tgl_insiden" name="insident_date">
                        @if ($errors->has('insident_date'))
                            <span class="text-danger">{{ $errors->first('insident_date') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jam_insiden" class="col-sm-2 col-form-label">Jam Insiden<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-2">
                        <input type="time" class="form-control @error('insident_time') is-invalid @enderror"
                            id="jam_insiden" name="insident_time">
                        @if ($errors->has('insident_time'))
                            <span class="text-danger">{{ $errors->first('insident_time') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="unit_terkait" class="col-sm-2 col-form-label">Unit Terkait<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-2">
                        <select class="form-select @error('units') is-invalid @enderror" id="unit_terkait" name="units[]"
                            multiple="multiple">
                            @foreach ($listUnit as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('units'))
                            <span class="text-danger">{{ $errors->first('units') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="staf_terkait" class="col-sm-2 col-form-label">Staf Terkait<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-2">
                        <select class="form-select @error('staffs') is-invalid @enderror" id="staf_terkait" name="staffs[]"
                            multiple="multiple">
                            @foreach ($listStaff as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('staffs'))
                            <span class="text-danger">{{ $errors->first('staffs') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="kronologi" class="col-sm-2 col-form-label">Kronologi<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-6">
                        <textarea class="form-control @error('chronology') is-invalid @enderror" id="kronologi" rows="5"
                            placeholder="Kronologi" name="chronology"></textarea>
                        @if ($errors->has('chronology'))
                            <span class="text-danger">{{ $errors->first('chronology') }}</span>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <button type="submit" form="newCase" class="btn border border-dark text-decoration-none p-2"
                style="background-color: #ffff">SUBMIT</button>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#unit_terkait').select2({
                placeholder: "Pilih unit terkait",
                allowClear: true
            });
            $('#staf_terkait').select2({
                placeholder: "Pilih staf terkait",
                allowClear: true
            });
        });
    </script>
@endpush
