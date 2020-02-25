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
                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <form>
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="nama" class="form-control" id="nama" name="nama">

                      <!-- error -->
                      @if($errors->has('nama'))
                        <div class="text-danger">
                          {{ $errors->first('nama') }}
                        </div>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" name="username">

                      <!-- error -->
                      @if($errors->has('username'))
                        <div class="text-danger">
                          {{ $errors->first('username') }}
                        </div>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="ttd">Tanda Tangan</label>
                      <input type="file" class="form-control" id="ttd" name="ttd">
                      <small id="ttd" class="form-text text-muted">Type File : jpeg,bmp,png</small>

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
                        <option value="1">Admin</option>
                        <option value="2">Superuser</option>
                      </select>

                      <!-- error -->
                      @if($errors->has('level'))
                        <div class="text-danger">
                          {{ $errors->first('level') }}
                        </div>
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="cil-save"></i> Simpan</button>
                  </form>
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

    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
