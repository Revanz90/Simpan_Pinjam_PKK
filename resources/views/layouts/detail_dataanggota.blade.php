@extends('main')

@section('title', 'Detail Data Anggota')
@section('title2', 'Detail Data Anggota')
@section('judul', 'Detail Data Anggota')

@section('content')
    <div id="xtest" style="font-size: 14px"></div>
    <div class="callout callout-warning">
        <i class="fas fa-info-circle"></i>
        Halaman untuk merubah data anggota
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
        <div class="card-header">
            <h4 class="card-title font-weight-bold">DATA ANGGOTA</h4>
            <div class="card-tools">
                <input type="hidden" name="statusM" id="statusMid[2]" value="2">
            </div>
        </div>
        <div class="card-body">
            <form action="" enctype="multipart/form-data" method="POST" class="form-horizontal" id="ubahanggotaform">
            {{ csrf_field() }}
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Nama Anggota</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_anggota" class="form-control" value="{{ $member->nama_anggota }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">ID Anggota</label>
                    <div class="col-sm-10">
                        <input type="text" name="id_anggota" class="form-control" value="{{ $member->id_anggota }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Alamat Anggota</label>
                    <div class="col-sm-10">
                        <input type="text" name="alamat_anggota" class="form-control" value="{{ $member->alamat_anggota }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Email Anggota</label>
                    <div class="col-sm-10">
                        <input type="text" name="email_anggota" class="form-control" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Password</label>
                    <div class="col-sm-10">
                        <input type="text" name="password_anggota" class="form-control">
                    </div>
                </div>
                <div class="form-group row" name="gender">
                    <label class="col-sm-2 col-form-label font-weight-normal">Jenis Kelamin</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="inlineRadio1" value="pria">
                        <label class="form-check-label" for="inlineRadio1">Pria</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="inlineRadio2" value="wanita">
                        <label class="form-check-label" for="inlineRadio2">Wanita</label>
                    </div>
                </div>
                <input type="hidden" name="member_id" value="{{ $member->id }}">
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <button type="submit" form="ubahanggotaform" value="Submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>
@endsection
