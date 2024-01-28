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

        #table td {
            vertical-align: middle;
        }

        .form-check label {
            font-size: .725rem;
            float: left;
            margin-top: .3rem;
        }

        ol li {
            width: 100%;
            font-size: .775rem;
            float: left;
            text-align: left;
            margin-bottom: .5rem;
            vertical-align: top;
        }

        ol li a {
            transition: all .3s;
        }

        ol li:hover a {
            color: #0003ab !important;
            text-decoration: underline !important;
            margin-right: 2px;
        }
    </style>
@endpush
@php($url = url('/'))
@section('content')
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card mb-3" style="background-color: #000000!important;">
                <div class="table-responsive" style="background-color: #557ae9!important;">
                    <table id="table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr class="align-middle">
                                <th scope="col" class="text-center" style="vertical-align: middle">No</th>
                                <th scope="col" class="text-center">Tingkat Insiden</th>
                                <th scope="col" class="text-center">Nama Pasien</th>
                                <th scope="col" class="text-center">No. MedRec</th>
                                <th scope="col" class="text-center">Tanggal Kejadian</th>
                                <th scope="col" class="text-center">Kronologi</th>
                                <th scope="col" class="text-center">Implementasi</th>
                                <th scope="col" class="text-center">Corrective Action</th>
                                <th scope="col" class="text-center">PIC</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Download PDF</th>
                            </tr>
                            <tr>
                                <th class="text-end">|</th>
                                <th class="text-end">|</th>
                                <th class="text-end">|</th>
                                <th class="text-end">|</th>
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
                            <tr class="text-center">
                                <input type="hidden" name="case_id" id="caseId" value="{{ $case->id }}">
                                <td>{{ $case->id }}</td>
                                <td>
                                    <div id="level" class=" d-flex flex-column">
                                        @foreach ($levels as $level)
                                            @php($checkedLevel = false)
                                            @foreach ($case->insident_levels as $item)
                                                @if ($level->id == $item->level_id)
                                                    @php($checkedLevel = true)
                                                @endif
                                            @endforeach

                                            <div class="form-check">
                                                <input class="form-check-input level lv" type="checkbox"
                                                    data-id="{{ $level->id }}" name="level[]" value="{{ $level->id }}"
                                                    id="{{ \Illuminate\Support\Str::snake($level->name) }}"
                                                    data-name="{{ \Illuminate\Support\Str::snake($level->name) }}"
                                                    {{ $checkedLevel ? 'checked' : '' }}>
                                                <label class="form-check-label lv"
                                                    for="{{ \Illuminate\Support\Str::snake($level->name) }}"
                                                    data-name="{{ \Illuminate\Support\Str::snake($level->name) }}"
                                                    data-id="{{ $level->id }}">
                                                    {{ $level->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ $case->patient_name }}</td>
                                <td>{{ $case->medrec_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($case->insident_date)->format('d/m/y') }}</td>
                                <td class="w-50">
                                    <textarea class="form-control" id="kronologi" rows="4" placeholder="Kronologi" name="chronology"
                                        style="font-size: .725rem;" disabled>{{ $case->chronology }}</textarea>
                                </td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <a type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#implementationModal">
                                        Upload files
                                    </a>
                                    <div id="implementation" class=" d-flex flex-column">
                                        @if (count($case->insident_implementations) > 0)
                                            <ol>
                                                @foreach ($case->insident_implementations as $item)
                                                    {{-- @dd(Storage::url($item->attachment)) --}}
                                                    <li>
                                                        <a type="button" class="pdfPreview mt-3"
                                                            data-path="{{ url($item->attachment) }}">
                                                            {{ $item->implementation->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        @endif
                                    </div>
                                </td>
                                <td class="w-50">
                                    <!-- Button trigger modal -->
                                    <a type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#correctiveActModal">
                                        Upload files
                                    </a>
                                    <div id="listCorrectiveAction">
                                        @if (count($case->insident_corrective_actions) > 0)
                                            <ol>
                                                @foreach ($case->insident_corrective_actions as $item)
                                                    <li>
                                                        <a type="button" class="pdfPreview mt-3"
                                                            data-path="{{ url($item->attachment) }}">
                                                            {{ $item->desc }}
                                                        </a>
                                                    </li>

                                                    {{-- <a href="{{asset('public/upload/corrective-action/'. $item['attachment'])}}" class="text-primary">{{$item['attachment']}} <br><br></a>  --}}
                                                @endforeach
                                            </ol>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control pic" id="picName"
                                                placeholder="Nama PIC" value="{{ $case->insident_pic?->name }}">
                                            <label for="picName">Nama PIC</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control pic" id="picEmail"
                                                placeholder="Email" value="{{ $case->insident_pic?->email }}">
                                            <label for="picEmail">Email</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control pic" id="picDueDate"
                                                placeholder="Due Date" value="{{ $case->insident_pic?->due_date }}">
                                            <label for="picDueDate">Due Date</label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div id="status" class="d-flex flex-column">
                                        @foreach ($statuses as $status)
                                            @php($checkedStatus = false)
                                            @foreach ($case->insident_statuses as $item)
                                                @if ($status->id == $item->status_id)
                                                    @php($checkedStatus = true)
                                                @endif
                                            @endforeach

                                            <div class="form-check">
                                                <input class="form-check-input st" type="checkbox"
                                                    id="{{ \Illuminate\Support\Str::snake($status->name) }}"
                                                    data-name="{{ \Illuminate\Support\Str::snake($status->name) }}"
                                                    data-id="{{ $status->id }}" {{ $checkedStatus ? 'checked' : '' }}>
                                                <label class="form-check-label st"
                                                    for="{{ \Illuminate\Support\Str::snake($status->name) }}"
                                                    data-name="{{ \Illuminate\Support\Str::snake($status->name) }}"
                                                    data-id="{{ $status->id }}">
                                                    {{ $status->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.review-case-detail.download-pdf', ['id' => $case->id]) }}"
                                        class="fst-italic text-primary fst-italic" style="font-size: .725rem;">Download
                                        PDF</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="implementationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload file implementation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mes"></div>
                        <form class="mb-3">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <select class="form-select imp_select" aria-label="Default select example">
                                        @foreach ($implementations as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <input type="file" name="imp_file" multiple
                                            class="form-control imp_file @error('files') is-invalid @enderror"
                                            accept="application/pdf">
                                        @error('files')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 d-flex justify-content-center">
                                <button type="button" class="btn btn-success upload_file_imp">Upload</button>
                            </div>
                        </form>
                        <table id="tableImpFile" class="table my-3 w-100">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tipe File</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="correctiveActModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload file corrective action</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mes"></div>
                        <form class="mb-3">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <select class="form-select ca_text" aria-label="Default select example">
                                        {{-- @foreach ($implementations as $item) --}}
                                        <option value="Review SPO Vaksinasi">Review SPO Vaksinasi</option>
                                        <option value="Re Edukasi Staff">Re Edukasi Staff</option>
                                        <option value="Pemasangan Signed “Prinsip 6 Benar”">Pemasangan Signed “Prinsip 6
                                            Benar”</option>
                                        {{-- @endforeach --}}
                                    </select>
                                    {{-- <input type="text" name="ca_text" placeholder="Desc"
                                        class="form-control ca_text @error('files') is-invalid @enderror">
                                    @error('files')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <input type="file" name="ca_files" multiple
                                            class="form-control ca_file @error('files') is-invalid @enderror"
                                            accept="application/pdf">
                                        @error('files')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 d-flex justify-content-center">
                                <button type="button" class="btn btn-success upload_file_ca">Upload</button>
                            </div>
                        </form>
                        <table id="tableCAFile" class="table my-3 w-100">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Desc</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">PDF Preview</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="min-height: 80vh;">
                        <iframe id="pdfIframe" style="visibility:visible; width: 100%; min-height: inherit;"
                            src=""></iframe>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/v1.js') }}"></script>
    <script src="{{ asset('js/yjdt.js') }}"></script>

    <script>
        const table = new DataTable('#table');
        $(document).ready(function() {
            const url = `{{ url('/') }}`;
            const dynamicCheckbox = (eventSelector, parentId, query, checkedData = [], uncheckedData = []) => {
                $(eventSelector).click(function(e) {
                    $(parentId).each(function() {
                        $(this).children().find('input[type=checkbox]').each(function() {
                            var self = $(this);
                            if (self.is(':checked')) {
                                const elementExists = checkedData.includes(self.data(
                                    'id'));
                                if (!elementExists) {
                                    checkedData.push(self.data('id'));
                                }

                                let index = uncheckedData.indexOf(self.data('id'));
                                if (index !== -1) {
                                    uncheckedData.splice(index, 1);
                                }
                            } else {
                                const delElementExist = uncheckedData.includes(self
                                    .data('id'));
                                if (!delElementExist) {
                                    uncheckedData.push(self.data('id'));
                                }
                                let index = checkedData.indexOf(self.data('id'));
                                if (index !== -1) {
                                    checkedData.splice(index, 1);
                                }
                            }
                        });
                    });
                    const data = {
                        case_id: $('#caseId').val(),
                        checks: checkedData,
                        unchecks: uncheckedData
                    };

                    Ajax.post(`{{ route('dashboard.detail-case.store') }}/?category=${query}`, data, (
                        res) => {
                        Table('#tableImpFile').reload();
                    }, (err) => {});
                });
            };

            const checkboxList = [{
                    'eventSelector': '#level .lv',
                    'parentId': '#level',
                    'query': `level`
                },
                {
                    'eventSelector': '#status .st',
                    'parentId': '#status',
                    'query': `status`
                },
                {
                    'eventSelector': '#implementation .imp',
                    'parentId': '#implementation',
                    'query': `implementation`
                },
            ];

            $.map(checkboxList, (e) => dynamicCheckbox(e.eventSelector, e.parentId, e.query));

            $('#kronologi').dblclick(function(e) {
                let self = $(this);
                self.removeAttr('disabled');
                self.trigger('focus');
                self.focusout(function() {
                    const data = {
                        case_id: $('#caseId').val(),
                        chronology: self.val()
                    };
                    self.attr('disabled', 'disabled');
                    Ajax.post(`{{ route('dashboard.detail-case.store') }}/?category=chronology`,
                        data, (res) => {}, (err) => {});
                });
            });

            $(document).on('click', '.upload_file_imp', function(e) {
                e.preventDefault();

                if ($('.imp_file').val() == '') {
                    return $('.mes').html(
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>File kosong, silahkan input file lebih dahulu!</strong>  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                    );
                }
                let formData = new FormData();
                let dataFile = $('.imp_file').prop('files')[0];
                formData.append('file', dataFile);
                formData.append('imp_id', $('.imp_select option:selected').val());
                formData.append('case_id', $('#caseId').val());
                Ajax.postWithFile(`{{ route('dashboard.detail-case.store-file') }}`, formData,
                    (response) => {
                        $('.imp_file').val('');
                        Table('#tableImpFile').reload();
                        if (response.data.insident_implementations.length > 0) {
                            let listItem = [];
                            $.map(response.data.insident_implementations, function(e, i) {
                                listItem.push(
                                    `<li><a type="button" class="text-decoration-none text-black pdfPreview" data-path="${url+e.attachment}">${e.implementation.name}</a></li>`
                                )
                            });

                            $('#implementation').html(`
                                <ol>
                                    ${listItem.join('')}
                                </ol>
                            `);
                        } else {
                            $('#implementation').html(``);
                        }
                    },
                    (error) => {
                        return $('.mes').html(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>${error.responseJSON.message}</strong>  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                        );
                    }
                );
            });

            $(document).on('click', '.upload_file_ca', function(e) {
                e.preventDefault();
                if ($('.ca_file').val() == '' || $('.ca_text').val().length === 0) {
                    return $('.mes').html(
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>File/desc kosong, silahkan input file/desc lebih dahulu!</strong>  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                    );
                }
                let formData = new FormData();
                let dataFile = $('.ca_file').prop('files')[0];
                formData.append('file', dataFile);
                formData.append('desc', $('.ca_text').val());
                formData.append('case_id', $('#caseId').val());
                Ajax.postWithFile(`{{ route('dashboard.detail-case.store-ca') }}`, formData,
                    (response) => {
                        $('.ca_text, .ca_file').val('');
                        Table('#tableCAFile').reload();
                        if (response.data.insident_corrective_actions.length > 0) {
                            let listItem = [];
                            $.map(response.data.insident_corrective_actions, function(e, i) {
                                listItem.push(
                                    `<li><a type="button" class="text-decoration-none text-black pdfPreview" data-path="${url+e.attachment}">${e.desc}</a></li>`
                                )
                            });

                            $('#listCorrectiveAction').html(`
                                <ol>
                                    ${listItem.join('')}
                                </ol>
                            `);
                        } else {
                            $('#listCorrectiveAction').html(``);
                        }
                    },
                    (error) => {
                        return $('.mes').html(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>${error.responseJSON.message}</strong>  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                        );
                    }
                );
            });

            Table('#tableImpFile').init({
                url: `{{ route('ajax.datatable.implementationAttachmentData') }}`,
                data: (row) => {
                    row.case_id = $('#caseId').val();
                }
            }, [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'fileType',
                    orderable: false,
                    searching: false
                },
                {
                    data: 'fileName',
                    orderable: false,
                },
                {
                    data: 'action',
                    orderable: false
                }
            ]);

            Table('#tableCAFile').init({
                url: `{{ route('ajax.datatable.corectiveActionAttachmentData') }}`,
                data: (row) => {
                    row.case_id = $('#caseId').val();
                }
            }, [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'fileDesc',
                    orderable: false,
                    searching: false
                },
                {
                    data: 'fileName',
                    orderable: false,
                },
                {
                    data: 'action',
                    orderable: false
                }
            ]);

            $(document).on('focusout', '.pic', function(e) {
                e.preventDefault();
                const data = {
                    'name': $('#picName').val(),
                    'email': $('#picEmail').val(),
                    'due_date': $('#picDueDate').val(),
                    'case_id': $('#caseId').val()
                };

                Ajax.post(`{{ route('dashboard.detail-case.store-pic') }}`, data, (res) => {}, (
                    err) => {});
            });

            $(document).on('click', 'ol li a', function(e) {
                e.preventDefault();
                $('#pdfPreviewModal').modal('show');
                $('#pdfIframe').attr('src', $(this).data('path'));
            });

            $(document).on('click', '.delete_imp', function(e) {
                e.preventDefault();
                let data = {
                    'imp_id': $(this).data('id'),
                }
                Ajax.post(`{{ route('dashboard.delete-imp') }}`, data,
                    (response) => {
                        $('.imp_file').val('');
                        Table('#tableImpFile').reload();
                        if (response.data.insident_implementations.length > 0) {
                            let listItem = [];
                            $.map(response.data.insident_implementations, function(e, i) {
                                listItem.push(
                                    `<li><a type="button" class="text-decoration-none text-black pdfPreview" data-path="${url+e.attachment}">${e.implementation.name}</a></li>`
                                )
                            });

                            $('#implementation').html(`
                                <ol>
                                    ${listItem.join('')}
                                </ol>
                            `);
                        } else {
                            $('#implementation').html(``);
                        }
                    },
                    (error) => {}
                );
            });

            $(document).on('click', '.delete_ca', function(e) {
                e.preventDefault();
                let data = {
                    'ca_id': $(this).data('id'),
                }
                Ajax.post(`{{ route('dashboard.delete-ca') }}`, data,
                    (response) => {
                        $('.ca_text, .ca_file').val('');
                        Table('#tableCAFile').reload();
                        if (response.data.insident_corrective_actions.length > 0) {
                            let listItem = [];
                            $.map(response.data.insident_corrective_actions, function(e, i) {
                                listItem.push(
                                    `<li><a type="button" class="text-decoration-none text-black pdfPreview" data-path="${url+e.attachment}">${e.desc}</a></li>`
                                )
                            });

                            $('#listCorrectiveAction').html(`
                                <ol>
                                    ${listItem.join('')}
                                </ol>
                            `);
                        } else {
                            $('#listCorrectiveAction').html(``);
                        }
                    },
                    (error) => {}
                );
            });

        });
    </script>
@endpush
