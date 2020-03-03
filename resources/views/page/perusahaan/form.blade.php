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
                <a href="{{ route('perusahaan.index') }}" class="btn btn-success">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <form action="{{ (empty($perusahaan->id)?route('perusahaan.store'):route('perusahaan.update')) }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  @if(!empty($perusahaan->id))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $perusahaan->id }}">
                  @endif

                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $perusahaan->nama }}">

                    <!-- error -->
                    @if($errors->has('nama'))
                      <div class="text-danger">
                        {{ $errors->first('nama') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="5" class="form-control">{{ $perusahaan->alamat }}</textarea>

                    <!-- error -->
                    @if($errors->has('alamat'))
                      <div class="text-danger">
                        {{ $errors->first('alamat') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="telp">Telepon</label>
                    <input type="text" class="form-control" id="telp" name="telp" value="{{ $perusahaan->telp }}">

                    <!-- error -->
                    @if($errors->has('telp'))
                      <div class="text-danger">
                        {{ $errors->first('telp') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="fax">Fax</label>
                    <input type="text" class="form-control" id="fax" name="fax" value="{{ $perusahaan->fax }}">

                    <!-- error -->
                    @if($errors->has('fax'))
                      <div class="text-danger">
                        {{ $errors->first('fax') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $perusahaan->email }}">

                    <!-- error -->
                    @if($errors->has('email'))
                      <div class="text-danger">
                        {{ $errors->first('email') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="pic">PIC</label>
                    <input type="text" class="form-control" id="pic" name="pic" value="{{ $perusahaan->pic }}">

                    <!-- error -->
                    @if($errors->has('pic'))
                      <div class="text-danger">
                        {{ $errors->first('pic') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="logo">Logo</label>
                    <br>
                    <img src="{{ asset('upload/logo/'.$perusahaan->logo) }}" alt="logo-perusahaan" width="100px" class="mb-2">
                    <input type="file" class="form-control" id="logo" name="logo">
                    <small class="mini-text text-muted">Logo perusahaan terkait.</small>
                    @if(!empty($perusahaan->logo))
                    <small class="mini-text text-danger">Jika tidak merubah gambar tidak perlu upload gambar baru.</small>
                    <input type="hidden" name="logoOld" value="{{ $perusahaan->logo }}">
                    @endif

                    <!-- error -->
                    @if($errors->has('logo'))
                      <div class="text-danger">
                        {{ $errors->first('logo') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="cap">Cap</label>
                    <br>
                    <img src="{{ asset('upload/cap/'.$perusahaan->cap) }}" alt="logo-perusahaan" width="100px" class="mb-2">
                    <input type="file" class="form-control" id="cap" name="cap">
                    <small class="mini-text text-muted">Cap perusahaan terkait.</small>
                    @if(!empty($perusahaan->cap))
                    <small class="mini-text text-danger">Jika tidak merubah gambar tidak perlu upload gambar baru.</small>
                    <input type="hidden" name="capOld" value="{{ $perusahaan->cap }}">
                    @endif

                    <!-- error -->
                    @if($errors->has('cap'))
                      <div class="text-danger">
                        {{ $errors->first('cap') }}
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
