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
                <a href="{{ route('user.index') }}" class="btn btn-success">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <form action="{{ (empty($user->id)?route('user.store'):route('user.update')) }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  @if(!empty($user->id))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $user->id }}">
                  @endif

                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="nama" class="form-control" id="nama" name="nama" value="{{ $user->nama }}">

                    <!-- error -->
                    @if($errors->has('nama'))
                      <div class="text-danger">
                        {{ $errors->first('nama') }}
                      </div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">

                    <!-- error -->
                    @if($errors->has('username'))
                      <div class="text-danger">
                        {{ $errors->first('username') }}
                      </div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="ttd">Tanda Tangan</label>
                    @if(!empty($user->id))
                      @if(!empty($user->ttd))
                      <p>
                        <img src="{{ asset('upload/ttd/'.$user->ttd) }}" alt="pic-ttd" width="120">
                      </p>
                      @else
                      <p class="text-danger">Tidak ada gambar tanda tangan, silahkan upload gambar.</p>
                      @endif
                    @endif
                    <input type="file" class="form-control" id="ttd" name="ttd">
                    <input type="hidden" class="form-control" name="ttdOld" value="{{ $user->ttd }}">
                    <small id="ttd" class="form-text text-muted">Type File : jpeg,bmp,png<br><span class="text-danger">*Jika tidak merubah ttd tidak perlu upload file foto kembali.</span></small>

                    <!-- error -->
                    @if($errors->has('ttd'))
                      <div class="text-danger">
                        {{ $errors->first('ttd') }}
                      </div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="level">level</label>
                    <select name="level" id="level" class="form-control">
                      <option value="">Pilih</option>
                      <option value="1" {{ ($user->level == '1')?'selected':'' }}>Admin</option>
                      <option value="2" {{ ($user->level == '2')?'selected':'' }}>Superuser</option>
                    </select>

                    <!-- error -->
                    @if($errors->has('level'))
                      <div class="text-danger">
                        {{ $errors->first('level') }}
                      </div><br>
                    @endif
                    <small class="text-info">*Password akan tergenerate default '12345'</small>
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
