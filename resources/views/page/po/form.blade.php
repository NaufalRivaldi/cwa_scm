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
                <a href="{{ route('po.index') }}" class="btn btn-success">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <form action="{{ (empty($po->id)?route('po.store'):route('po.update')) }}" method="POST" enctype="multipart/form-data">
      @csrf

      @if(!empty($po->id))
        @method('PUT')
        <input type="hidden" name="id" value="{{ $po->id }}">
      @endif
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Purchase Order</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="supplierId">Supplier</label>
                    <select name="supplierId" id="" class="supplierId form-control formSelect2">
                      @if(!empty($po->supplierId))
                        <option value="{{ $po->supplierId }}">{{ $po->supplier->nama }}</option>
                      @endif
                    </select>
                    <small class="mini-text text-muted">Cari berdasarkan nama supplier.</small>
    
                    <!-- error -->
                    @if($errors->has('supplierId'))
                      <div class="text-danger">
                        {{ $errors->first('supplierId') }}
                      </div>
                    @endif
                  </div>
    
                  {{-- view supplier --}}
                  <div class="card">
                    <div class="card-body dataSupplier">
                      Data Supplier
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nomer">Nomer PO</label>
                    <input type="text" class="form-control" id="nomer" name="nomer" value="{{ $po->nomer }}" readonly>
                    <small class="mini-text text-muted">Terisi secara otomatis dan tidak dapat diubah.</small>
    
                    <!-- error -->
                    @if($errors->has('nomer'))
                      <div class="text-danger">
                        {{ $errors->first('nomer') }}
                      </div>
                    @endif
                  </div>
                  
                  <div class="form-group">
                    <label for="tglPO">Tanggal Pengajuan</label>
                    <input type="date" class="form-control" id="tglPO" name="tglPO" value="{{ $po->tglPO }}" readonly>
                    <small class="mini-text text-muted">Terisi secara otomatis dan tidak dapat diubah.</small>
    
                    <!-- error -->
                    @if($errors->has('tglPO'))
                      <div class="text-danger">
                        {{ $errors->first('tglPO') }}
                      </div>
                    @endif
                  </div>
  
                  <div class="form-group">
                    <label for="tglPengiriman">Tanggal Pengiriman</label>
                    <input type="date" class="form-control" id="tglPengiriman" name="tglPengiriman" value="{{ $po->tglPengiriman }}">
    
                    <!-- error -->
                    @if($errors->has('tglPengiriman'))
                      <div class="text-danger">
                        {{ $errors->first('tglPengiriman') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="kredit">Masa Pembayaran <span class="text-info">*Hari</span></label>
                    <input type="number" class="form-control kredit" name="kredit">
    
                    <!-- error -->
                    @if($errors->has('kredit'))
                      <div class="text-danger">
                        {{ $errors->first('kredit') }}
                      </div>
                    @endif
                  </div>
                </div>

              </div>
              <hr>
              <div class="row mb-3">
                <div class="col-md-12">
                  <div id="formPlus">
                    <div class="form-row mb-2">
                      <div class="col-md-4">
                        <select name="barangId" name="barangId" id="barangId1" class="barangId form-control formSelect2">
                        </select>

                        <!-- error -->
                          @if($errors->has('barangId'))
                          <div class="text-danger">
                            {{ $errors->first('barangId') }}
                          </div>
                        @endif
                      </div>
                      <div class="col-md-1">
                        <input type="number" name="qty" class="form-control" placeholder="Qty" step="0.01">

                        <!-- error -->
                        @if($errors->has('qty'))
                          <div class="text-danger">
                            {{ $errors->first('qty') }}
                          </div>
                        @endif
                      </div>
                      <div class="col-md-3">
                        <input type="number" name="harga" class="form-control" placeholder="Harga">
                        <small>Set Harga : <span class="price1"></span></small>

                        <!-- error -->
                        @if($errors->has('harga'))
                          <div class="text-danger">
                            {{ $errors->first('harga') }}
                          </div>
                        @endif
                      </div>
                      <div class="col-md-1">
                        <input type="number" name="disc" class="form-control" placeholder="Disc" step="0.01">

                        <!-- error -->
                        @if($errors->has('disc'))
                          <div class="text-danger">
                            {{ $errors->first('disc') }}
                          </div>
                        @endif
                      </div>
                      <div class="col-md-3">
                        <input type="number" name="total" class="form-control total" placeholder="Total">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

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
        url: '{{ route("po.supplier") }}',
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

    $('.supplierId').change(function(){
      var supplierId = $(this).val();

      $.ajax({
        type: 'POST',
        url: "{{ route('po.data.supplier') }}",
        data: {
          'id': supplierId,
          '_token': '{{ csrf_token() }}'
        },
        success: function(data){
          $('.kredit').val(data.kredit);
          $('.dataSupplier').empty();
          $('.dataSupplier').append(`
            <h6>Kode</h6>
            <p>`+data.kode+`</p>
            <h6>Nama</h6>
            <p>`+data.nama+`</p>
            <h6>Alamat</h6>
            <p>`+data.alamat+`</p>
            <h6>Telp / Fax</h6>
            <p>`+data.telp+` / `+data.fax+`</p>
            <h6>PIC</h6>
            <p>`+data.pic+`</p>
          `);
        }
      });
    });

    $('.barangId').select2({
      placeholder: 'Cari barang...',
      theme: 'bootstrap',
      ajax: {
        type: 'GET',
        url: '{{ route("po.barang") }}',
        dataType: 'json',
        delay: 250,
        processResults: function(data){
          return {
            results: $.map(data, function(item){
              return {
                text: item.kodeBarang+' - '+item.nama,
                id: item.id
              }
            })
          };
        },
        cache: true
      }
    });

    $(document).on('click', '.remove', function(e){
      e.preventDefault();
      var button_id = $(this).attr("id");
      $('#row'+button_id+'').remove();
    });

    var i = 1;
    $(document).on('keydown', 'input[name=total]', function(e){
      i++;
      
      var code = e.keyCode || e.which;
      if(code == '9'){
        console.log('asd');
        $('#formPlus').append(`
        <div id="row`+i+`">
          <div class="form-row mb-2">
            <div class="col-md-4">
              <select name="barangId" name="barangId" id="barangId`+i+`" class="barangId form-control formSelect2">
              </select>

              <!-- error -->
                @if($errors->has('barangId'))
                <div class="text-danger">
                  {{ $errors->first('barangId') }}
                </div>
              @endif
            </div>
            <div class="col-md-1">
              <input type="number" name="qty" class="form-control" placeholder="Qty" step="0.01">

              <!-- error -->
              @if($errors->has('qty'))
                <div class="text-danger">
                  {{ $errors->first('qty') }}
                </div>
              @endif
            </div>
            <div class="col-md-3">
              <input type="number" name="harga" class="form-control" id="harga`+i+`" placeholder="Harga">
              <span class="price`+i+`"></span>

              <!-- error -->
              @if($errors->has('harga'))
                <div class="text-danger">
                  {{ $errors->first('harga') }}
                </div>
              @endif
            </div>
            <div class="col-md-1">
              <input type="number" name="disc" class="form-control" placeholder="Disc" step="0.01">

              <!-- error -->
              @if($errors->has('disc'))
                <div class="text-danger">
                  {{ $errors->first('disc') }}
                </div>
              @endif
            </div>
            <div class="col-md-3">
              <div class="input-group">
                <input type="number" name="total" class="form-control total" placeholder="Total">
                <div class="input-group-append">
                  <button class="btn btn-danger cil-minus remove" type="button" id="`+i+`"></button>
                </div>
              </div>
            </div>
          </div>
        </div>`);

        $('#barangId'+i).select2({
          placeholder: 'Cari barang...',
          theme: 'bootstrap',
          ajax: {
            type: 'GET',
            url: '{{ route("po.barang") }}',
            dataType: 'json',
            delay: 250,
            processResults: function(data){
              return {
                results: $.map(data, function(item){
                  return {
                    text: item.kodeBarang+' - '+item.nama,
                    id: item.id
                  }
                })
              };
            },
            cache: true
          }
        });
      }
    });

    // delete row
    $(document).on('click', '.remove', function(){
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });

    // price set
    $(document).on('change', '.barangId', function(){
      var id = $(this).val();
      
    });
  </script>
@endsection
