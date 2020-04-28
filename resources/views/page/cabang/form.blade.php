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
                <a href="{{ route('cabang.index') }}" class="btn btn-success">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <form action="{{ (empty($cabang->id)?route('cabang.store'):route('cabang.update')) }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  @if(!empty($cabang->id))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $cabang->id }}">
                  @endif

                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $cabang->nama }}">

                    <!-- error -->
                    @if($errors->has('nama'))
                      <div class="text-danger">
                        {{ $errors->first('nama') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="5" class="form-control">{{ $cabang->alamat }}</textarea>

                    <!-- error -->
                    @if($errors->has('alamat'))
                      <div class="text-danger">
                        {{ $errors->first('alamat') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="telp">Telp</label>
                    <input type="text" class="form-control" id="telp" name="telp" value="{{ $cabang->telp }}">

                    <!-- error -->
                    @if($errors->has('telp'))
                      <div class="text-danger">
                        {{ $errors->first('telp') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="pic">PIC</label>
                    <input type="text" class="form-control" id="pic" name="pic" value="{{ $cabang->pic }}">
                    <small class="form-text text-muted">Isi nama penerima atau yang bertanggung jawab di cabang terkait.</small>

                    <!-- error -->
                    @if($errors->has('pic'))
                      <div class="text-danger">
                        {{ $errors->first('pic') }}
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
