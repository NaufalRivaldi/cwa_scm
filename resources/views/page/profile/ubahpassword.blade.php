@extends('dashboard.base')

@section('content')

<div class="container-fluid">
  <div class="fade-in">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header">
            <h5><i class="cil-cog"></i> Ubah Password</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('profile.repassword') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="oldPassword">Password Lama</label>
                <input type="password" name="oldPassword" id="oldPassword" class="form-control">

                <!-- error -->
                @if($errors->has('oldPassword'))
                  <div class="text-danger">
                    {{ $errors->first('oldPassword') }}
                  </div>
                @endif
              </div>
              <div class="form-group">
                <label for="newPassword">Password Baru</label>
                <input type="password" name="newPassword" id="newPassword" class="form-control">

                <!-- error -->
                @if($errors->has('newPassword'))
                  <div class="text-danger">
                    {{ $errors->first('newPassword') }}
                  </div>
                @endif
              </div>
              <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">

                <!-- error -->
                @if($errors->has('confirmPassword'))
                  <div class="text-danger">
                    {{ $errors->first('confirmPassword') }}
                  </div>
                @endif
              </div>
              <button type="submit" class="btn btn-primary btn-block"><i class="cil-save"></i> Simpan</button>
            </form>
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
