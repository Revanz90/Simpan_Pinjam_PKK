@extends('main')

@section('title', 'Detail Transaksi Angsuran')
@section('title2', 'Detail Transaksi Angsuran')
@section('judul', 'Detail Transaksi Angsuran')

@section('page-js-files')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@stop

@section('content')
    <section class="content">
        <div id="xtest" style="font-size: 14px"></div>
        <div class="callout callout-warning">
            <i class="fas fa-info-circle"></i>
            Halaman untuk melihat Detail Transaksi Angsuran
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <div class="card">
            <!-- Navbar Content -->
            <div class="card-header">
                <h4 class="card-title font-weight-bold">Detail Transaksi Angsuran</h4>
                <div class="card-tools">
                    <input type="hidden" name="xnull" id="statusxid[2]" value="2">
                    <div class="project-actions text-center">
                        <a href="{{ route('laporan_simpanan') }}" class="btn btn-warning" role="button" data-bs-toggle="button">
                            <i class="fas fa-print"></i>
                            CETAK
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Navbar Content -->

            <!-- Page Content -->
            <div class="card-body">
                <table id="examplePolos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Jumlah Angsuran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggotaid as $anggota)
                            <tr>
                                <td>{{ $anggota->id_anggota }}</td>
                                <td>{{ $anggota->nama_anggota }}</td>
                                <td>
                                    @if($user->hasRole('admin'))
                                        {{ $nominalPerAuthor[$anggota->id_user] ?? 0 }}
                                    @else
                                        {{ $totalNominal }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    
@endsection
