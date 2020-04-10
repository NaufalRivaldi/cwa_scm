@extends('dashboard.base')

@section('content')

<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5>Profile</h5>
              </div>
              <div class="col-sm-6 text-right">
                <a href="{{ route('profile.edit', ['id' => Auth::user()->id]) }}" class="btn btn-success">
                  <i class="cil-cog"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="card-body profile">
            <img src="{{ asset('img/icon/user.png') }}" alt="user.png" width="40%">
            <h5>{{ Auth::user()->nama }}</h5>
            <div class="content">
              <p>
                <b>Username</b><br>
                {{ Auth::user()->username }}<br>
                <b>Jabatan</b><br>
                <span class="badge badge-success">{{ level(Auth::user()->level) }}</span><br>
                <b>Tanda Tangan</b><br>
                <img src="{{ asset('upload/ttd/'.Auth::user()->ttd) }}" alt="ttd" width="50%">
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('modal')



@endsection

@section('javascript')

  <script>
    
  </script>
  
@endsection
