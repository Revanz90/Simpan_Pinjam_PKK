@extends('main')

@section('title', 'Detail Data Simpanan')
@section('title2', 'Detail Data Simpanan')
@section('judul', 'Detail Data Simpanan')

@section('content')
    <div id="xtest" style="font-size: 14px"></div>
    <div class="callout callout-warning">
        <i class="fas fa-info-circle"></i>
        Halaman untuk melihat detail Data Simpanan
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title font-weight-bold">DATA SIMPANAN</h4>
            <div class="card-tools">
                <input type="hidden" name="statusM" id="statusMid[2]" value="2">
            </div>
        </div>
        <div class="card-body">
            <form action="" class="form-horizontal">

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">ID Anggota</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="{{ $data->author_id }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Nama Anggota</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="{{ $data->author_name }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Nominal Simpanan</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="{{ $data->nominal_uang }}"
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Tanggal Transfer</label>
                    <div class="col-sm-10">                  
                        <input type="date" name="tanggal_transfer" class="form-control" value="{{ $data->tanggal_transfer ? \Carbon\Carbon::parse($data->tanggal_transfer)->format('Y-m-d') : '' }}"
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Keterangan</label>
                    <div class="col-sm-10">
                        <textarea type="text" name="" class="form-control" readonly>{{ $data->keterangan }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Bukti Transfer</label>
                    <div class="card-footer bg-white col-sm-10">
                        <embed type="application/pdf" src="{{ url('storage/' . $file->files) }}" id="pdf-embed"
                            frameborder="0" width="100%" height="780">
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
