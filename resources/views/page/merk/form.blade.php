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
                <a href="{{ route('merk.index') }}" class="btn btn-success">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <form action="{{ (empty($merk->id)?route('merk.store'):route('merk.update')) }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  @if(!empty($merk->id))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $merk->id }}">
                  @endif
                  
                  <div class="form-group">
                    <label for="kodeMerk">Kode Merk</label>
                    <input type="text" class="form-control" id="kodeMerk" name="kodeMerk" value="{{ $merk->kodeMerk }}">

                    <!-- error -->
                    @if($errors->has('kodeMerk'))
                      <div class="text-danger">
                        {{ $errors->first('kodeMerk') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $merk->nama }}">

                    <!-- error -->
                    @if($errors->has('nama'))
                      <div class="text-danger">
                        {{ $errors->first('nama') }}
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
  <script>
    $('#wilayahId').select2({
      placeholder: 'Cari wilayah...',
      theme: 'bootstrap',
      ajax: {
        type: 'GET',
        url: '{{ route("wilayah.cari") }}',
        dataType: 'json',
        delay: 250,
        processResults: function(data){
          return {
            results: $.map(data, function(item){
              return {
                text: item.nama,
                id: item.id
              }
            })
          };
        },
        cache: true
      }
    });
  </script>
@endsection
