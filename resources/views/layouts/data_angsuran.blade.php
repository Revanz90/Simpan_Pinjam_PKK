@extends('layouts.main')

@section('partials.content')
@section('title', 'Data Angsuran')
@section('title2', 'Data Angsuran')
<section class="content">
    <div id="xtest" style="font-size: 14px"></div>
    <div class="callout callout-warning">
        <i class="fas fa-info-circle"></i>
        Halaman untuk melihat dan menambah data angsuran
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
            <h4 class="card-title font-weight-bold">DATA ANGSURAN</h4>
            <div class="card-tools">
                <input type="hidden" name="xnull" id="statusxid[2]" value="2">
                <div class="project-actions text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                        <i class="fas fa-plus"></i>
                        Tambah
                    </button>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-default1">
                        <i class="fas fa-plus"></i>
                        Cetak
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
                        <th>Nama Anggota</th>
                        <th>Id_Anggota</th>
                        <th>Tanggal</th>
                        <th>No. Nota Pinjaman</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama Anggota</td>
                        <td>Id_Anggota</td>
                        <td>Tanggal</td>
                        <td>No. Nota Pinjaman</td>
                        <td>Nominal</td>
                        <td>keterangan</td>
                        <td class="text-center d-flex flex-column align-items-stretch" style="gap: 4px">
                            <a class="btn btn-info btn-xs" href="{{ route('detail_angsuran') }}">
                                <i class="fas fa-folder">
                                </i>
                                Lihat
                            </a>
                        </td>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Tambah Data Angsuran -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog" style="max-width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data Angsuran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="content">
                    <div class="card">
                        <!-- Navbar Content -->
                        <div class="card-header ">
                            <h4 class="card-title font-weight-bold">TAMBAH DATA ANGSURAN</h4>
                            <div class="card-tools"></div>
                        </div>
                        <!-- /Navbar Content -->
                        <!-- Page Content -->
                        <form action="" enctype="multipart/form-data" method="POST" class="form-horizontal"
                            id="suratmasukform">
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
                                                    <input type="text" name="no_surat" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-2 col-form-label font-weight-normal">Id_Anggota</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="no_surat" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-2 col-form-label font-weight-normal">Tanggal</label>
                                                <div class="col-sm-10">
                                                    <input type="date" name="tanggal" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-2 col-form-label font-weight-normal">No. Nota Pinjaman
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="perihal" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-2 col-form-label font-weight-normal">Nominal
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="perihal" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-2 col-form-label font-weight-normal">Keterangan
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="keterangan" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="proposal_ProposalTA"
                                                    class="col-sm-2 col-form-label font-weight-normal">Upload
                                                    Syarat(.pdf)</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="Input_SuratMasuk"
                                                        class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="proposal_ProposalTA"
                                                    class="col-sm-2 col-form-label font-weight-normal">Upload Bukti
                                                    Transfer(.pdf)</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="Input_SuratMasuk"
                                                        class="form-control" required>
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
                    <button type="submit" form="suratmasukform" value="Submit"
                        class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal -->

<!-- Modal Cetak Data Angsuran -->
<div class="modal fade" id="modal-default1">
    <div class="modal-dialog" style="max-width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cetak Data Angsuran Tahunan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="content">
                    <div class="card">
                        <!-- Navbar Content -->
                        <div class="card-header ">
                            <h4 class="card-title font-weight-bold">CETAK DATA ANGSURAN TAHUNAN</h4>
                            <div class="card-tools"></div>
                        </div>
                        <!-- /Navbar Content -->
                        <!-- Page Content -->
                        <form action="" enctype="multipart/form-data" method="POST" class="form-horizontal"
                            id="suratmasukform">
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
                                                    <input type="text" name="no_surat" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-2 col-form-label font-weight-normal">Id_Anggota</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="no_surat" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-2 col-form-label font-weight-normal">Tanggal</label>
                                                <div class="col-sm-10">
                                                    <input type="date" name="tanggal" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-2 col-form-label font-weight-normal">No. Nota
                                                    Pinjaman
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="perihal" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-2 col-form-label font-weight-normal">Nominal
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="perihal" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-2 col-form-label font-weight-normal">Keterangan
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="keterangan" class="form-control">
                                                </div>
                                            </div>

                                            {{-- <div class="form-group row">
                                                <label for="proposal_ProposalTA"
                                                    class="col-sm-2 col-form-label font-weight-normal">Upload
                                                    Syarat(.pdf)</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="Input_SuratMasuk"
                                                        class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="proposal_ProposalTA"
                                                    class="col-sm-2 col-form-label font-weight-normal">Upload Bukti
                                                    Transfer(.pdf)</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="Input_SuratMasuk"
                                                        class="form-control" required>
                                                </div>
                                            </div> --}}

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
                    <button type="reset" class="btn btn-sm btn-warning" style="margin-right: 5px">Cetak</button>
                    <button type="submit" form="suratmasukform" value="Submit"
                        class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal -->
@endsection
