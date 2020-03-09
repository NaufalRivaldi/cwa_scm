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
                <a href="{{ route('supplier.index') }}" class="btn btn-success">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <form action="{{ (empty($supplier->id)?route('supplier.store'):route('supplier.update')) }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  @if(!empty($supplier->id))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $supplier->id }}">
                  @endif
                  
                  <div class="form-group">
                    <label for="kode">Kode Supplier</label>
                    <input type="text" class="form-control" id="kode" name="kode" value="{{ $supplier->kode }}">

                    <!-- error -->
                    @if($errors->has('kode'))
                      <div class="text-danger">
                        {{ $errors->first('kode') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $supplier->nama }}">

                    <!-- error -->
                    @if($errors->has('nama'))
                      <div class="text-danger">
                        {{ $errors->first('nama') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="tax">Tax</label>
                    <select name="tax" id="tax" class="form-control">
                      <option value="0" {{ ($supplier->tax == 0)?'selected':'' }}>False</option>
                      <option value="1" {{ ($supplier->tax == 1)?'selected':'' }}>True</option>
                    </select>

                    <!-- error -->
                    @if($errors->has('tax'))
                      <div class="text-danger">
                        {{ $errors->first('tax') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="5" class="form-control">{{ $supplier->alamat }}</textarea>

                    <!-- error -->
                    @if($errors->has('alamat'))
                      <div class="text-danger">
                        {{ $errors->first('alamat') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="wilayahId">Wilayah</label>
                    <select name="wilayahId" id="wilayahId" class="form-control formSelect2">
                      @if(!empty($supplier->id))
                      <option value="{{ $supplier->wilayahId }}" selected="selected">{{ $supplier->wilayah->nama }}</option>
                      @endif
                    </select>

                    <!-- error -->
                    @if($errors->has('wilayahId'))
                      <div class="text-danger">
                        {{ $errors->first('wilayahId') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="telp">Telepon</label>
                    <input type="text" class="form-control" id="telp" name="telp" value="{{ $supplier->telp }}">

                    <!-- error -->
                    @if($errors->has('telp'))
                      <div class="text-danger">
                        {{ $errors->first('telp') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="fax">Fax</label>
                    <input type="text" class="form-control" id="fax" name="fax" value="{{ $supplier->fax }}">

                    <!-- error -->
                    @if($errors->has('fax'))
                      <div class="text-danger">
                        {{ $errors->first('fax') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $supplier->email }}">

                    <!-- error -->
                    @if($errors->has('email'))
                      <div class="text-danger">
                        {{ $errors->first('email') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="kredit">Kredit</label>
                    <select name="kredit" id="kredit" class="form-control">
                      <option value="0" {{ ($supplier->kredit == 0)?'selected':'' }}>False</option>
                      <option value="1" {{ ($supplier->kredit == 1)?'selected':'' }}>True</option>
                    </select>

                    <!-- error -->
                    @if($errors->has('kredit'))
                      <div class="text-danger">
                        {{ $errors->first('kredit') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="pic">PIC</label>
                    <input type="text" class="form-control" id="pic" name="pic" value="{{ $supplier->pic }}">

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
