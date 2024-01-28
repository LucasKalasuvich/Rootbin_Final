<!DOCTYPE html>
<html>

<head>
    <title>Case PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }

        .picContainer div {
            text-align: left !important;
            font-size: .750rem;
            margin-bottom: .675rem;
            ;
        }
    </style>

{{-- <div class="font-weight-bold mt-0">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('picture/ramsay.png'))) }}" alt="logo"
                style="width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 25%;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1;">

    <div>
        <h4>ROOT CAUSE ANALYSIS REPORT</h4>
    </div>
</div> --}}

<table class="table table-borderless">
        <tbody class="text-start">
            <tr>
                <td class="text-start">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('picture/ramsay.png'))) }}" alt="logo" style="width: 150px;
                    height: 150px;
                    overflow: hidden;
                    border-radius: 25%;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
                    position: relative;
                    z-index: 1;">
                </td>
                
                <td class="text-start">
                    <h4 class="mt-5">ROOT CAUSE ANALYSIS REPORT</h4>
                </td>
            </tr>
        </tbody></table>
<hr style="border: 1px solid black;">
<p class="text-start font-weight-bold font-italic m-2">
    CASE SUMMARY <br>
</p>
<table class="table table-borderless m-4 mt-3">
    @foreach ($cases as $case)
            @php($levels = [])
            @foreach ($case->insident_levels as $level)
                @php(array_push($levels, $level->level->name))
            @endforeach

            @php($statuses = [])
            @foreach ($case->insident_statuses as $status)
                @php(array_push($statuses, $status->status->name))
            @endforeach

            @php($implementations = [])
            @foreach ($case->insident_implementations as $implementation)
                @php(array_push($implementations, $implementation->implementation->name))
            @endforeach
        <tbody class="text-start">
            
                <tr><td class="text-start" style="width: 25%">Tingkat Insiden</td><td class="text-start">: {{ empty($levels) ? '' : implode(', ', $levels) }}</td></tr>
                <tr><td class="text-start">Nama Pelapor</td><td class="text-start">: {{ $case->reporter_name }}</td></tr>
                <tr><td class="text-start">Nama Pasien</td><td class="text-start">: {{ $case->patient_name }}</td></tr>
                <tr><td class="text-start">No. MedRec</td><td class="text-start">: {{ $case->medrec_number }}</td></tr>
                <tr><td class="text-start">Tanggal Kejadian</td><td class="text-start">: {{ \Carbon\Carbon::parse($case->insident_date)->format('d/m/y') }}</td></tr>
                <tr><td class="text-start">Kronologi</td><td class="text-start">: {{ $case->chronology }}</td></tr>
                <tr><td class="text-start">Corrective Action</td><td class="text-start">:</td></tr>
        </tbody></table>
    @endforeach


    <table id="table" class="table table-bordered border border-dark border-2 m-0">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Action</th>
                <th class="text-center">Nama PIC</th>
                <th class="text-center">Due Date</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cases as $case)
                @php($levels = [])
                @foreach ($case->insident_levels as $level)
                    @php(array_push($levels, $level->level->name))
                @endforeach

                @php($statuses = [])
                @foreach ($case->insident_statuses as $status)
                    @php(array_push($statuses, $status->status->name))
                @endforeach

                @php($implementations = [])
                @foreach ($case->insident_implementations as $implementation)
                    @php(array_push($implementations, $implementation->implementation->name))
                @endforeach

                @php($correctiveActions = [])
                @foreach ($case->insident_corrective_actions as $corrective_action)
                    @php(array_push($correctiveActions, $corrective_action->desc))
                @endforeach

                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ empty($correctiveActions) ? '' : implode(', ', $correctiveActions) }}</td>
                    {{-- <td>{{ empty($implementations) ? '' : implode(', ', $implementations) }}</td> --}}
                    <td>
                        @if ($case->insident_pic)
                            {{-- <div class="picContainer text-center"> --}}
                                <div>({{ $case->insident_pic->name }})</div>
                                <div>{{ $case->insident_pic->email }}</div>
                                {{-- <div>Due Date: <br>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $case->insident_pic->due_date)->format('d-m-Y') }}
                                </div> --}}
                            {{-- </div> --}}
                        @endif
                    </td>
                    <td>
                        @if ($case->insident_pic)
                            {{-- <div class="picContainer text-center"> --}}
                                {{-- <div>Nama: <br> {{ $case->insident_pic->name }}</div> --}}
                                {{-- <div>Email: <br> {{ $case->insident_pic->email }}</div> --}}
                                <div>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $case->insident_pic->due_date)->format('d-m-Y') }}
                                </div>
                            {{-- </div> --}}
                        @endif
                    </td>
                    <td>{{ empty($statuses) ? '' : implode(', ', $statuses) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
