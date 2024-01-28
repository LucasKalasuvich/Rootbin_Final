@extends('layout.main')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    @php
        $listUnit = ['IT', 'QMR', 'SKJ', 'ADVC'];
        $listStaff = ['Agung', 'Bayu', 'Candra', 'Dodi', 'Hendra'];
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
            <form id="newCase" action="{{ route('dashboard.store-case') }}{{ $verification ? '/?act=verification' : '' }}"
                method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Nama Pasien<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Nama Pasien" value="{{ $case->patient_name }}"
                            {{ $verification ? 'disabled' : '' }}>
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
                            name="medrec" placeholder="Nomor Medrec" value="{{ $case->medrec_number }}"
                            {{ $verification ? 'disabled' : '' }}>
                        @if ($errors->has('medrec'))
                            <span class="text-danger">{{ $errors->first('medrec') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tgl_pelaporan" class="col-sm-2 col-form-label">Tanggal Pelaporan</label>
                    <div class="col-sm-10 col-md-2">
                        <input type="date" class="form-control @error('report_date') is-invalid @enderror" id="tgl_pelaporan" 
                            value="{{ $case->reporting_date }}" name="report_date" {{ $verification ? 'disabled' : '' }}>
                        {{-- <input type="hidden" class="form-control" id="tgl_pelaporan" name="report_date"
                            value="{{ $case->reporting_date }}"> --}}
                        <input type="hidden" class="form-control" id="id" name="id"
                            value="{{ $case->id }}">
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
                            id="tgl_insiden" name="insident_date" value="{{ $case->insident_date }}"
                            {{ $verification ? 'disabled' : '' }}>
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
                            id="jam_insiden" name="insident_time" value="{{ $case->insident_time }}"
                            {{ $verification ? 'disabled' : '' }}>
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
                            multiple="multiple" {{ $verification ? 'disabled' : '' }}>
                            @foreach ($listUnit as $item)
                                @php($selected = false)
                                @foreach ($case->units as $unit)
                                    @if ($unit->name == $item)
                                        @php($selected = true)
                                    @endif
                                @endforeach
                                <option value="{{ $item }}" {{ $selected ? 'selected' : '' }}>{{ $item }}
                                </option>
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
                            multiple="multiple" {{ $verification ? 'disabled' : '' }}>
                            @foreach ($listStaff as $item)
                                @php($selected = false)
                                @foreach ($case->staffs as $staff)
                                    @if ($staff->name == $item)
                                        @php($selected = true)
                                    @endif
                                @endforeach
                                <option value="{{ $item }}" {{ $selected ? 'selected' : '' }}>{{ $item }}
                                </option>
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
                            placeholder="Kronologi" name="chronology" {{ $verification ? 'disabled' : '' }}>{{ $case->chronology }}</textarea>
                        @if ($errors->has('chronology'))
                            <span class="text-danger">{{ $errors->first('chronology') }}</span>
                        @endif
                    </div>
                </div>
                @if ($verification)
                    <div class="row mb-3">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <div class="d-flex">
                                @if (auth()->user()->isSupervisor() ||
                                        auth()->user()->isAdmin())
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="checkbox" value="1"
                                            id="verifCheckbox" name="verif_insident">
                                        <label class="form-check-label" for="verifCheckbox">
                                            Verifikasi Insiden
                                        </label>
                                    </div>
                                @endif

                                @if (auth()->user()->isUser() ||
                                        auth()->user()->isAdmin())
                                    @if ($case->status == 'WAITING')
                                        <span class="badge rounded-pill bg-danger fs-6 me-2">Menunggu verifikasi
                                            supervisor</span>
                                    @elseif ($case->status == 'WAITING')
                                        <span class="badge rounded-pill bg-success fs-6">Sudah diverifikasi
                                            supervisor</span>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->isSupervisor() ||
                            auth()->user()->isAdmin())
                        {{-- <div class="row mb-3">
                            <label for="riskman_number" class="col-sm-2 col-form-label">No. Riskman</label>
                            <div class="col-sm-10 col-md-6">
                                <textarea class="form-control" id="riskman_number" rows="3" placeholder="No. Riskman"
                                    name="riskman_number"></textarea>
                            </div>
                        </div> --}}

                        <div class="row mb-3">
                            <label for="info_tambahan" class="col-sm-2 col-form-label">Informasi Tambahan</label>
                            <div class="col-sm-10 col-md-6">
                                <textarea class="form-control" id="info_tambahan" rows="3" placeholder="Informasi Tambahan"
                                    name="additional_info"></textarea>
                            </div>
                        </div>
                    @endif
                @endif
            </form>
        </div>
        <div class="d-flex justify-content-center mt-4 mb-4">
            <button type="submit" form="newCase" class="btn border border-dark text-decoration-none p-2"
                style="background-color: #ffff">{{ $verification ? 'VERIFIKASI' : 'UPDATE' }}</button>
        </div>
    </div>
@endsection

@push('js')
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
