@extends('dashboard.base')

@section('content')

<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-md-12">

        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <a href="{{ route('wilayah.index') }}" class="btn btn-success">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <form action="{{ (empty($wilayah->id)?route('wilayah.store'):route('wilayah.update')) }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  @if(!empty($wilayah->id))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $wilayah->id }}">
                  @endif

                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $wilayah->nama }}">

                    <!-- error -->
                    @if($errors->has('nama'))
                      <div class="text-danger">
                        {{ $errors->first('nama') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="5" class="form-control">{{ $wilayah->keterangan }}</textarea>

                    <!-- error -->
                    @if($errors->has('keterangan'))
                      <div class="text-danger">
                        {{ $errors->first('keterangan') }}
                      </div>
                    @endif
                  </div>

                  <button type="submit" class="btn btn-primary"><i class="cil-save"></i> Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')

@endsection
