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
                <a href="{{ route('user.index') }}" class="btn btn-primary">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <form action="{{ route('user.store') }}" method="POST">
                  @csrf
                  <form>
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="email" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                      <label for="ttd">Tanda Tangan</label>
                      <input type="file" class="form-control" id="ttd" name="ttd">
                    </div>
                    <div class="form-group">
                      <label for="level">level</label>
                      <select name="level" id="level" class="form-control">
                        <option value="">Pilih</option>
                        <option value="1">Admin</option>
                        <option value="2">Superuser</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
