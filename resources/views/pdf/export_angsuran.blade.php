<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Laporan Data Angsuran</title>
</head>

<body>
    <div class="container-fluid mt-3">
        <div class="card" id="monthly-report">
            <div class="card-header">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container col-md-10">
                        <div class="text-head text-center">
                            <a class="navbar-brand" href="#">
                                <img src="img/Logo-PKK.png" width="20%" alt="Logo-PKK">
                            </a>
                        </div>
                        <div class="text-center col-md-8">
                            <h3>Laporan Data Angsuran</h3>
                            <h6>Simpan Pinjam Pemberdayaan Kesejahteraan Keluarga (PKK) Kelurahan Kalitirto, Berbah,
                                Sleman
                            </h6>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="container-body">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Anggota</th>
                                <th>Nama Anggota</th>
                                <th>Nominal Angsuran</th>
                                <th>Tanggal Angsuran</th>
                                <th>Status Angsuran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($installment as $installments)
                                <tr>
                                    <th>{{ $installments->author_id }}</th>
                                    <td>{{ $installments->author_name }}</td>
                                    <td>{{ $installments->nominal_angsuran }}</td>
                                    <td>{{ $installments->tanggal_transfer }}</td>
                                    <td>{{ $installments->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 offset-md-8">
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
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
