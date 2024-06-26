@extends('main')

@section('title', 'Data Anggota')
@section('title2', 'Data Anggota')
@section('judul', 'Anggota')

@section('page-js-files')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@stop

@section('content')
    <section class="content">
        <div id="xtest" style="font-size: 14px"></div>
        <div class="callout callout-warning">
            <i class="fas fa-info-circle"></i>
            Halaman untuk melihat dan menambah data anggota
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
                <h4 class="card-title font-weight-bold">DATA ANGGOTA</h4>
                <div class="card-tools">
                    <input type="hidden" name="xnull" id="statusxid[2]" value="2">
                    <div class="project-actions text-center">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-plus"></i>
                            TAMBAH
                        </button>
                    </div>
                </div>
            </div>
            <!-- /Navbar Content -->

            <!-- Page Content -->
            <div class="card-body">
                <table id="examplePolos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>ID Anggota</th>
                            <th>Alamat Anggota</th>
                            <th>Jenis Kelamin</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $index => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_anggota }}</td>
                                <td>{{ $data->id_anggota }}</td>
                                <td>{{ $data->alamat_anggota }}</td>
                                <td>{{ $data->jenis_kelamin }}</td>
                                <td>
                                    <a class="btn btn-info btn-xs text-center d-flex flex-column align-items-stretch"
                                        href=" {{ route('ubahdataanggota', ['id' => $data->id]) }}">
                                        <i class="fas fa-edit">
                                        </i>
                                        Ubah
                                    </a>
                                    @hasrole('admin')
                                    <form action="{{ route('delete_anggota', ['id' => $data->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-danger btn-xs text-center d-flex flex-column align-items-stretch mt-1">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                    @endhasrole
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog" style="max-width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Anggota</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section class="content">
                        <div class="card">
                            <!-- Navbar Content -->
                            <div class="card-header ">
                                <h4 class="card-title font-weight-bold">TAMBAH ANGGOTA</h4>
                                <div class="card-tools"></div>
                            </div>
                            <!-- /Navbar Content -->
                            <!-- Page Content -->
                            <form action="" enctype="multipart/form-data" method="POST" class="form-horizontal"
                                id="anggotaform">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="form-group row">
                                                    <label for=""
                                                        class="col-sm-2 col-form-label font-weight-normal">Nama
                                                        Anggota</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nama_anggota" id="nama_anggota" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for=""
                                                        class="col-sm-2 col-form-label font-weight-normal">ID
                                                        Anggota</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="id_anggota" id="id_anggota" class="form-control" placeholder="Masukkan angka (max 3)">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for=""
                                                        class="col-sm-2 col-form-label font-weight-normal">Alamat Anggota
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="alamat_anggota" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for=""
                                                        class="col-sm-2 col-form-label font-weight-normal">Email
                                                        Anggota</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" name="email_anggota" id="email_anggota" class="form-control">
                                                        <span id="email_feedback" style="color: red; display: none;">Format email tidak valid</span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for=""
                                                        class="col-sm-2 col-form-label font-weight-normal">Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="password_anggota" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row" name="gender">
                                                    <label class="col-sm-2 col-form-label font-weight-normal">Jenis
                                                        Kelamin</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="jenis_kelamin" id="inlineRadio1" value="pria">
                                                        <label class="form-check-label" for="inlineRadio1">Pria</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="jenis_kelamin" id="inlineRadio2" value="wanita">
                                                        <label class="form-check-label" for="inlineRadio2">Wanita</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- /Page Content -->
                        </div>
                    </section>
                </div>
                <!-- /Main Content -->

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <div class="btn-savechange-reset">
                        <button type="reset" class="btn btn-sm btn-warning" style="margin-right: 5px">Reset</button>
                        <button type="submit" form="anggotaform" value="Submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal -->

    <script>
        document.getElementById('nama_anggota').addEventListener('input', function (e) {
            var input = e.target.value;
            e.target.value = input.replace(/[^A-Za-z\s]/g, '');
        });

        document.getElementById('email_anggota').addEventListener('input', function (e) {
            var input = e.target.value;
            var feedback = document.getElementById('email_feedback');
            
            // Simple email regex pattern
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            if (emailPattern.test(input)) {
                feedback.style.display = 'none';
            } else {
                feedback.style.display = 'inline';
            }
        });

        document.addEventListener('DOMContentLoaded', (event) => {
            const angkaInput = document.getElementById('id_anggota');

            angkaInput.addEventListener('input', function(e) {
                let value = angkaInput.value;

                // Hapus semua karakter yang bukan angka
                value = value.replace(/\D/g, '');

                // Batasi panjang input maksimal 3 angka
                if (value.length > 3) {
                    value = value.slice(0, 3);
                }

                // Set nilai input yang sudah difilter
                angkaInput.value = value;
            });
        });
    </script>
@endsection
