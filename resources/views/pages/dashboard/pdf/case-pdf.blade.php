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

        table .secondTrTh {
            text-align: end;
        }
    </style>

    <table id="table" class="table table-bordered border-dark m-0">
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
            <tr class="secondTrTh">
                <th>|</th>
                <th>|</th>
                <th>|</th>
                <th>|</th>
                <th>|</th>
                <th>|</th>
                <th>|</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cases as $case)
                @php($category = [])
                @foreach ($case->insident_levels as $level)
                    @php(array_push($category, $level->level->name))
                @endforeach
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
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

</body>

</html>
