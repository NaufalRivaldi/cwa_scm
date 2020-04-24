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
                <a href="{{ route('barang.index') }}" class="btn btn-success">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <form action="{{ (empty($barang->id)?route('barang.store'):route('barang.update')) }}" method="POST" enctype="multipart/form-data">
      @csrf

      @if(!empty($barang->id))
        @method('PUT')
        <input type="hidden" name="id" value="{{ $barang->id }}">
      @endif
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4>Data Barang</h4>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="merkId">Merk</label>
                <select name="merkId" id="merkId" class="form-control formSelect2">
                  @if(!empty($barang->id))
                  <option value="{{ $barang->merkId }}" selected="selected">{{ $barang->merk->nama }}</option>
                  @endif
                </select>
                <small class="mini-text text-muted">Cari berdasarkan nama merk.</small>

                <!-- error -->
                @if($errors->has('merkId'))
                  <div class="text-danger">
                    {{ $errors->first('merkId') }}
                  </div>
                @endif
              </div>
              
              <div class="form-group">
                <label for="kodebarang">Kode Barang</label>
                <input type="text" class="form-control" id="kodebarang" name="kodeBarang" value="{{ $barang->kodeBarang }}">

                <!-- error -->
                @if($errors->has('kodeBarang'))
                  <div class="text-danger">
                    {{ $errors->first('kodeBarang') }}
                  </div>
                @endif
              </div>

              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $barang->nama }}">

                <!-- error -->
                @if($errors->has('nama'))
                  <div class="text-danger">
                    {{ $errors->first('nama') }}
                  </div>
                @endif
              </div>

              <div class="form-group">
                <label for="base">Base</label>
                <select name="base" id="base" class="form-control">
                  <option value="0" {{ ($barang->base == '0')?'selected':'' }}>False</option>
                  <option value="1" {{ ($barang->base == '1')?'selected':'' }}>True</option>
                </select>

                <!-- error -->
                @if($errors->has('base'))
                  <div class="text-danger">
                    {{ $errors->first('base') }}
                  </div>
                @endif
              </div>

              <div class="form-group">
                <label for="berat">Berat</label>
                <input type="number" class="form-control" id="berat" name="berat" value="{{ $barang->berat }}" step="0.01">
                <small class="mini-text text-muted">Satuan dalam kg.</small>

                <!-- error -->
                @if($errors->has('berat'))
                  <div class="text-danger">
                    {{ $errors->first('berat') }}
                  </div>
                @endif
              </div>

              
              <div class="form-group">
                <label for="kemasan">Kemasan</label>
                <input type="text" class="form-control" id="kemasan" name="kemasan" value="{{ $barang->kemasan }}">

                <!-- error -->
                @if($errors->has('kemasan'))
                  <div class="text-danger">
                    {{ $errors->first('kemasan') }}
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4>Data Supply & Harga</h4>
            </div>
            <div class="card-body">
              @if(empty($barang->id))
              <div id="formPlus">
                <div class="form-group">
                  <label for="supplierId">Supplier</label>
                  <select name="supplierId[]" id="" class="supplierId form-control formSelect2">
                  </select>
                  <small class="mini-text text-muted">Cari berdasarkan nama supplier.</small>
  
                  <!-- error -->
                  @if($errors->has('supplierId'))
                    <div class="text-danger">
                      {{ $errors->first('supplierId') }}
                    </div>
                  @endif
                </div>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="harga">Harga <span class="text-success">*Rp.</span></label>
                      <input type="number" class="form-control" id="harga" name="harga[]" value="" step="0.01">
                      <small class="mini-text text-muted">Harga supplier terkait.</small>
  
                      <!-- error -->
                      @if($errors->has('harga'))
                        <div class="text-danger">
                          {{ $errors->first('harga') }}
                        </div>
                      @endif
                    </div>
                  </div>
  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="diskon">Diskon <span class="text-info">*%</span></label>
                      <input type="number" class="form-control" id="diskon" name="diskon[]" value="" step="0.01">
                      <small class="mini-text text-muted">Diskon supplier terkait.</small>
  
                      <!-- error -->
                      @if($errors->has('diskon'))
                        <div class="text-danger">
                          {{ $errors->first('diskon') }}
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              @else
                <div id="formPlus">
                  <?php $no="1" ?>
                  @foreach($barang->supply as $row)
                  <div id="row{{ $no }}">
                    <div class="form-group">
                      <label for="supplierId">Supplier</label>
                      <select name="supplierId[]" id="" class="supplierId form-control formSelect2">
                        <option value="{{ $row->supplierId }}">{{ $row->supplier->nama }}</option>
                      </select>
                      <small class="mini-text text-muted">Cari berdasarkan nama supplier.</small>
      
                      <!-- error -->
                      @if($errors->has('supplierId'))
                        <div class="text-danger">
                          {{ $errors->first('supplierId') }}
                        </div>
                      @endif
                    </div>
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="harga">Harga <span class="text-success">*Rp.</span></label>
                          <input type="number" class="form-control" id="harga" name="harga[]" value="{{ $row->harga }}" step="0.01">
                          <small class="mini-text text-muted">Harga supplier terkait.</small>
      
                          <!-- error -->
                          @if($errors->has('harga'))
                            <div class="text-danger">
                              {{ $errors->first('harga') }}
                            </div>
                          @endif
                        </div>
                      </div>
      
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="diskon">Diskon <span class="text-info">*%</span></label>
                          <input type="number" class="form-control" id="diskon" name="diskon[]" value="{{ $row->diskon }}" step="0.01">
                          <small class="mini-text text-muted">Diskon supplier terkait.</small>
      
                          <!-- error -->
                          @if($errors->has('diskon'))
                            <div class="text-danger">
                              {{ $errors->first('diskon') }}
                            </div>
                          @endif
                        </div>
                      </div>
                    </div>
                    <a href="#" class="btn btn-danger remove" id="{{ $no }}"><i class="cil-minus"></i></a>
                    <hr>
                  </div>
                  <?php $no++ ?>
                  @endforeach
                </div>
              @endif

              <a href="" class="btn btn-success" id="plus"><i class="cil-plus"></i></a>
              <br><br>
              <button type="submit" class="btn btn-primary"><i class="cil-save"></i> Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('javascript')
  <script>
    $('.supplierId').select2({
      placeholder: 'Cari supplier...',
      theme: 'bootstrap',
      ajax: {
        type: 'GET',
        url: '{{ route("barang.supplier") }}',
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

    $('#merkId').select2({
      placeholder: 'Cari merk...',
      theme: 'bootstrap',
      ajax: {
        type: 'GET',
        url: '{{ route("barang.merk") }}',
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

    @if(empty($barang->id))
      var i = {{ $no }};
    @else
      var i = 1;
    @endif
    $('#plus').click(function (e) {
        e.preventDefault();
        $('#formPlus').append(`
        <div id="row`+i+`">
          <div class="form-group">
            <label for="supplierId">Supplier</label>
            <select name="supplierId[]" id="supplierId`+i+`" class="form-control formSelect2">
            </select>
            <small class="mini-text text-muted">Cari berdasarkan nama supplier.</small>

            <!-- error -->
            @if($errors->has('supplierId'))
              <div class="text-danger">
                {{ $errors->first('supplierId') }}
              </div>
            @endif
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="harga">Harga <span class="text-success">*Rp.</span></label>
                <input type="number" class="form-control" id="harga" name="harga[]" value="">
                <small class="mini-text text-muted">Harga supplier terkait.</small>

                <!-- error -->
                @if($errors->has('harga'))
                  <div class="text-danger">
                    {{ $errors->first('harga') }}
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="diskon">Diskon <span class="text-info">*%</span></label>
                <input type="number" class="form-control" id="diskon" name="diskon[]" value="">
                <small class="mini-text text-muted">Diskon supplier terkait.</small>

                <!-- error -->
                @if($errors->has('diskon'))
                  <div class="text-danger">
                    {{ $errors->first('diskon') }}
                  </div>
                @endif
              </div>
            </div>
          </div>
          <a href="#" class="btn btn-danger remove" id="`+i+`"><i class="cil-minus"></i></a>
          <hr>
        </div>`);

        $('#supplierId'+i).select2({
          placeholder: 'Cari supplier...',
          theme: 'bootstrap',
          ajax: {
            type: 'GET',
            url: '{{ route("barang.supplier") }}',
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

        i++;
    });

    $(document).on('click', '.remove', function(e){
        e.preventDefault();
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });
  </script>
@endsection
