<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Kartu Angsuran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            position: relative;
            /* Set header to relative positioning */
            /* padding-top: 3rem; */
        }

        .header-content {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            /* Add space between image and text */
        }

        .header img {
            position: absolute;
            /* Set image to absolute positioning */
            top: 0;
            left: 0;
            opacity: 0.8;
            z-index: -1;
            /* Move the image behind the content */
        }

        .header-text p {
            text-align: center;
            margin-top: 1rem;
            /* Remove default top margin */
            margin-bottom: 1rem;
            /* Remove default bottom margin */
        }

        .brand-image {
            max-width: 150px;
        }

        .title {
            text-align: center;
            padding-top: 2rem;
        }

        .title-container {
            text-align: center;
        }

        .content {
            display: flex;
            justify-content: left;
        }

        .student-info {
            margin-right: 1rem;
        }

        .student-info p {
            margin: 0;
            line-height: 1.5;
        }

        .table-container {
            padding-top: 2rem;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
            vertical-align: middle;
        }

        .signature {
            display: flex;
            justify-content: flex-end;
            padding-top: 1.5rem;
        }

        .signature-content {
            text-align: center;
        }

        .signature p {
            margin: 0;
        }

        hr {
            border: none;
            border-top: 2px solid black;
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="header-content">
            <div class="header-text">
                <p><strong>Sistem Informasi Simpan Pinjam</strong></p>
                <p><strong>Pemberdayaan Kesejahteraan Keluarga (PKK)</strong></p>
                <p><strong>Kelurahan Kalitirto, Berbah, Sleman</strong></p>
            </div>
        </div>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Logo-PKK.png'))) }}"
            alt="Logo SMK" name="logo-smk-yapemda" class="brand-image img-circle elevation-3">
        <hr>
    </header>

    <!-- Title -->
    <div class="title">
        <div class="title-container">
            <p><strong>Laporan Angsuran Bulanan</strong></p>
        </div>
    </div>

    <!-- Table Content -->
    <div class="table-container">
        <table id="resume-angsuran-table" class="table table-bordered table-striped mb-4">
            <thead>
                <tr>
                    <th>Total Angsuran</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rp{{ $totalNilaiAngsuran }}</td>
                </tr>
            </tbody>
        </table>

        <table id="detail-angsuran-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Nominal Angsuran</th>
                    <th>Tanggal Angsuran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($getAngsurans as $angsuran)
                    <tr>
                        <th>{{ $no++ }}</th>
                        <th>{{ $angsuran->author_id }}</th>
                        <td>{{ $angsuran->author_name }}</td>
                        <td>{{ $angsuran->nominal_angsuran }}</td>
                        <td>{{ \Carbon\Carbon::parse($angsuran->tanggal_transfer)->formatLocalized('%d %B %Y') ?? '' }}</td>
                        <td>{{ $angsuran->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p><strong>Catatan : Jatuh tempo PEMBAYARAN paling lambat Tanggal 10 tiap bulan</strong></p>
    </div>

    <!-- Signature -->
    <div class="signature mb-3">
        <div class="signature-content">
            <p><strong>Yogyakarta, {{ \Carbon\Carbon::parse($dateNow)->translatedFormat('d F Y') }}</strong></p>
            <p><strong>Ketua PKK,</strong></p>
            <br><br><br>
            <p><strong>Eni Kusrini Amd.Kep</strong></p>
        </div>
    </div>

</body>

</html>
