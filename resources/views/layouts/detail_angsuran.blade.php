@extends('layouts.main')

@section('title', 'Detail Data Angsuran')
@section('title2', 'Detail Data Angsuran')
@section('judul', 'Detail Data Angsuran')

@section('partials.content')
    <div id="xtest" style="font-size: 14px"></div>
    <div class="callout callout-warning">
        <i class="fas fa-info-circle"></i>
        Halaman untuk melihat detail data angsuran
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title font-weight-bold">DATA ANGSURAN</h4>
            <div class="card-tools">
                <input type="hidden" name="statusM" id="statusMid[2]" value="2">
            </div>
        </div>
        {{-- @foreach ($datadetailsm as $data) --}}
        <div class="card-body">
            <form action="" class="form-horizontal">

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Nama Anggota</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Id_Anggota</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" name="" class="form-control" value="" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">No. Nota Pinjaman</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Nominal</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control" value="" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Keterangan</label>
                    <div class="col-sm-10">
                        <textarea type="text" name="" class="form-control text-bold" readonly></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label font-weight-normal">Surat
                        Masuk File</label>
                    <div class="card-footer bg-white col-sm-10">
                        {{-- <p><a href="{{ url('storage/files/' . $file->files) }}"
                                class="mailbox-attachment-name"><u>{{ $file->files }}</u></a></p> --}}
                        <embed type="application/pdf" src="" id="pdf-embed" frameborder="0" width="100%"
                            height="780">
                    </div>
                </div>
            </form>
        </div>
        {{-- @endforeach --}}
    </div>
@endsection
