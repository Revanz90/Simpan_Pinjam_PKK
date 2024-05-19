@extends('main')

@section('title', 'Ubah Data Pinjaman')
@section('title2', 'Ubah Data Pinjaman')
@section('judul', 'Ubah Data Pinjaman')

@section('content')
    <div id="xtest" style="font-size: 14px"></div>
    <div class="callout callout-warning">
        <i class="fas fa-info-circle"></i>
        Halaman untuk merubah Data Pinjaman
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
            <h4 class="card-title font-weight-bold">UBAH Pinjaman</h4>
            <div class="card-tools">
                <input type="hidden" name="statusM" id="statusMid[2]" value="2">
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('update_pinjaman') }}" enctype="multipart/form-data" method="POST" class="form-horizontal" id="ubahdatapinjaman">
            {{ csrf_field() }}
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Nominal Pinjaman</label>
                    <div class="col-sm-10">
                        <input type="text" name="nominal_pinjaman" class="form-control" value="{{ $data->nominal_pinjaman }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Tanggal Transfer</label>
                    <div class="col-sm-10">                  
                        <input type="date" name="tanggal_pinjaman" class="form-control" value="{{ $data->tanggal_pinjaman ? \Carbon\Carbon::parse($data->tanggal_pinjaman)->format('Y-m-d') : '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Keterangan</label>
                    <div class="col-sm-10">
                        <textarea type="text" name="keterangan" class="form-control">{{ $data->keterangan }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="proposal_ProposalTA"
                        class="col-sm-2 col-form-label font-weight-normal">Upload Syarat Pinjaman</label>
                    <div class="col-sm-10">
                        <input type="file" name="upload_bukti" class="form-control" required>
                    </div>
                </div>

                <input type="hidden" name="pinjaman_id" value="{{ $data->id }}">
                <input type="hidden" name="filepinjaman_id" value="{{ $creditfile->id }}">

                <button type="submit" form="ubahdatapinjaman" value="Submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>
@endsection
