<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Cetak Laporan Angsuran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .header-text {
            place-items: center;
            text-align: center;
            margin-top: 1.6rem;
            margin-bottom: 1.6rem;
            margin-left: 10px;
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
    <!-- Header Content -->
    <header class="header">
        <div class="d-flex">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Logo-PKK.png'))) }}"
                alt="Logo SMK" name="logo-smk-yapemda" class="brand-image img-circle elevation-3">
            <div class="header-text">
                <p><strong>Sistem Informasi Simpan Pinjam</strong></p>
                <p><strong>Pemberdayaan Kesejahteraan Keluarga (PKK)</strong></p>
                <p><strong>Kelurahan Kalitirto, Berbah, Sleman</strong></p>
            </div>
        </div>
    </header>

    <div class="card-body">
        <div class="col-md-6">
            <form action="" method="GET">
                <div class="flex input-group gap-4">
                    <select class="form-select"name="month_filter">
                        <option value="">Bulan</option>
                        <option value="januari">Januari</option>
                        <option value="februari">Februari</option>
                        <option value="maret">Maret</option>
                        <option value="april">April</option>
                        <option value="mei">Mei</option>
                        <option value="juni">Juni</option>
                        <option value="juli">Juli</option>
                        <option value="agustus">Agustus</option>
                        <option value="september">September</option>
                        <option value="oktober">Oktober</option>
                        <option value="november" type="submit">November</option>
                        <option value="desember">Desember</option>
                    </select>

                    <select class="form-select"name="year_filter">
                        <option value="">Tahun</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
                <a href="{{ route('export_angsuran') }}" class="btn btn-warning mt-3">Cetak Angsuran</a>
            </form>
        </div>
    </div>

    <!-- Title -->
    <div class="title">
        <div class="title-container">
            <p><strong>Laporan Angsuran Bulanan</strong></p>
        </div>
    </div>

    <!-- Table Content -->
    <div class="table-container">
        <table id="examplePolos" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Nominal Angsuran</th>
                    <th>Tanggal Angsuran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $installment => $data)
                    <tr>
                        <th>{{ $data->author_id }}</th>
                        <td>{{ $data->author_name }}</td>
                        <td>{{ $data->nominal_angsuran }}</td>
                        <td>{{ $data->tanggal_transfer }}</td>
                        <td>{{ $data->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p><strong>Catatan : Jatuh tempo PEMBAYARAN paling lambat Tanggal 10 tiap bulan</strong></p>
    </div>

    <!-- Signature -->
    <div class="signature mb-3">
        <div class="signature-content">
            <p><strong>Yogyakarta, 18 Februari 2024</strong></p>
            <p><strong>Ketua PKK,</strong></p>
            <br><br><br>
            <p><strong>Eni Kusrini Amd.Kep</strong></p>
        </div>
    </div>

</body>

</html>
