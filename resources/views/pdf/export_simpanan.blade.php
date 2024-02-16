<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Laporan Data Simpanan</title>
    <style>
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 50px;
            margin-right: 10px;
        }

        .header h3,
        h5 {
            font-size: 1.5em;
        }

        .content {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Additional styling to ensure proper PDF rendering */
        body {
            font-size: 12px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="mt-3" id="monthly-report">
        <div class="header">
            <img src="img/Logo-PKK.png" alt="Logo-PKK">
            <div class="text-head text-center">
                <h5>Laporan Data Simpanan</h5>
                <h3>Simpan Pinjam Pemberdayaan Kesejahteraan Keluarga (PKK)</h3>
                <h3>Kelurahan Kalitirto, Berbah, Kabupaten Sleman</h3>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Nominal Simpanan</th>
                    <th>Tanggal Simpanan</th>
                    <th>Status Simpanan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ID Anggota</td>
                    <td>Nama Anggota</td>
                    <td>Nominal Simpanan</td>
                    <td>Tanggal Simpanan</td>
                    <td>Status Simpanan</td>
                    {{-- @foreach ($savings as $saving)
                        <tr>
                            <th>{{ $saving->author_id }}</th>
                            <td>{{ $saving->author_name }}</td>
                            <td>{{ $saving->nominal_uang }}</td>
                            <td>{{ $saving->created_at }}</td>
                            <td>{{ $saving->status }}</td>
                        </tr>
                        @endforeach --}}
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="container">
            <div class="signature-text">
                <div class="text-end">
                    <p>Yogyakarta, 7 Februari 2024</p>
                    <p>Ketua PKK</p>
                    <br>
                    <br>
                    <br>
                    <p>Eni Kusrini Amd.Kep</p>
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
