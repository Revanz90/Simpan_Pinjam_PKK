@extends('main')

@section('title', 'Ubah Data Angsuran')
@section('title2', 'Ubah Data Angsuran')
@section('judul', 'Ubah Data Angsuran')

@section('content')
    <div id="xtest" style="font-size: 14px"></div>
    <div class="callout callout-warning">
        <i class="fas fa-info-circle"></i>
        Halaman untuk merubah Data Angsuran
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
            <h4 class="card-title font-weight-bold">UBAH ANGSURAN</h4>
            <div class="card-tools">
                <input type="hidden" name="statusM" id="statusMid[2]" value="2">
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('updateangsuran') }}" enctype="multipart/form-data" method="POST" class="form-horizontal" id="ubahdataangsuran">
            {{ csrf_field() }}
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Nominal Angsuran</label>
                    <div class="col-sm-10">
                        <input type="text" name="nominal_angsuran" class="form-control" value="{{ $data->nominal_angsuran }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Tanggal Transfer</label>
                    <div class="col-sm-10">                  
                        <input type="date" name="tanggal_transfer" class="form-control" value="{{ $data->tanggal_transfer ? \Carbon\Carbon::parse($data->tanggal_transfer)->format('Y-m-d') : '' }}">
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
                        class="col-sm-2 col-form-label font-weight-normal">Upload Bukti Transfer</label>
                    <div class="col-sm-10">
                        <input type="file" name="upload_bukti" class="form-control" required>
                    </div>
                </div>

                <input type="hidden" name="angsuran_id" value="{{ $data->id }}">
                <input type="hidden" name="angsuran_file_id" value="{{ $file->id }}">

                <button type="submit" form="ubahdataangsuran" value="Submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>
@endsection
