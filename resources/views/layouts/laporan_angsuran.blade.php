<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Data Angsuran</title>
</head>

<body>
    <div class="card mt-3" id="monthly-report">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="img/Logo-PKK.png" width="20%" alt="Logo-PKK">
                </a>
                <div class="text-head text-center">
                    <h3>Laporan Data Angsuran</h3>
                    <h6>Simpan Pinjam Pemberdayaan Kesejahteraan Keluarga (PKK) Kelurahan Kalitirto, Berbah,
                        Sleman
                    </h6>
                </div>
            </div>
        </nav>
    </div>

    <div class="card-body">
        <div class="container mt-5">
            <div class="col-md-6 mb-2">
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
                            <option value="november">November</option>
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


        <table class="table table-striped">
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
                @foreach ($installments as $installment)
                    <tr>
                        <th>{{ $installment->author_id }}</th>
                        <td>{{ $installment->author_name }}</td>
                        <td>{{ $installment->nominal_angsuran }}</td>
                        <td>{{ $installment->tanggal_transfer }}</td>
                        <td>{{ $installment->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 offset-md-9">
                    <div class="text-center">
                        <p>Yogyakarta, 7 Februari 2024</p>
                        <p>Ketua PKK</p>
                        <br>
                        <br>
                        <p>..........................................</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
