@extends('main')

@section('title', 'Detail Nota Pinjaman')
@section('title2', 'Detail Nota Pinjaman')
@section('judul', 'Detail Nota Pinjaman')

@section('content')
    <div id="xtest" style="font-size: 14px"></div>
    <div class="card">
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
        <div class="d-flex bd-highlight card-header">
            <h4 class="p-2 flex-grow-1 bd-highlight card-title font-weight-bold">Detail Nota Pinjaman</h4>
        </div>

        <div class="card-body">
            <form action="" class="form-horizontal">

                {{-- <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">ID Anggota</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Tanggal pinjaman</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Nominal</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="" readonly>
                    </div>
                </div> --}}

                
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">No Nota</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="{{ $data->no_nota }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Keterangan</label>
                    <div class="col-sm-10">
                        <textarea type="text" name="" class="form-control text-bold" readonly>{{ $data->keterangan }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Bukti Transfer File</label>
                    <div class="card-footer bg-white col-sm-10">
                        <embed type="application/pdf" src="{{ url('storage/files/' . $file->files) }}" id="pdf-embed"
                            frameborder="0" width="100%" height="780">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
