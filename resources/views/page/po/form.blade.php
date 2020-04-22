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

    <form action="{{ (empty($po->id)?route('po.store'):route('po.update')) }}" method="POST" enctype="multipart/form-data" id="formPo">
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
                    <select name="supplierId" id="" class="supplierId form-control formSelect2" required>
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
                    <label for="cabangId">Penerima</label>
                    <select name="cabangId" id="" class="cabangId form-control formSelect2" required>
                      @if(!empty($po->cabangId))
                        <option value="{{ $po->cabangId }}" selected>{{ $po->cabang->nama }}</option>
                      @endif
                    </select>
                    <small class="mini-text text-muted">Cari berdasarkan nama cabang.</small>
    
                    <!-- error -->
                    @if($errors->has('cabangId'))
                      <div class="text-danger">
                        {{ $errors->first('cabangId') }}
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
                    <input type="date" class="form-control" id="tglPengiriman" name="tglPengiriman" value="{{ ($po->tglPengiriman == '1000-01-01')?'':$po->tglPengiriman }}" {{ ($po->tglPengiriman == '1000-01-01')?'readonly':'' }}>

                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="pengiriman" {{ ($po->tglPengiriman == '1000-01-01')?'checked':'' }}>
                      <label class="form-check-label" for="pengiriman">Pengiriman Bertahap</label>
                    </div>
    
                    <!-- error -->
                    @if($errors->has('tglPengiriman'))
                      <div class="text-danger">
                        {{ $errors->first('tglPengiriman') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="kredit">Masa Pembayaran <span class="text-info">*Hari</span></label>
                    <input type="number" class="form-control kredit" name="kredit" required>
    
                    <!-- error -->
                    @if($errors->has('kredit'))
                      <div class="text-danger">
                        {{ $errors->first('kredit') }}
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="jenisPembayaran">Jenis Pembayaran</label>
                    <select name="jenisPembayaran" id="jenisPembayaran" class="form-control" required>
                      <option value="">Pilih</option>
                      <option value="TF">Transfer</option>
                      <option value="BG">BG</option>
                      <option value="CASH">Cash</option>
                    </select>
    
                    <!-- error -->
                    @if($errors->has('jenisPembayaran'))
                      <div class="text-danger">
                        {{ $errors->first('jenisPembayaran') }}
                      </div>
                    @endif
                  </div>
                </div>

              </div>
              <hr>
              <div class="row mb-3">
                <div class="col-md-12">
                  
                  <div id="formPlus">
                    @if(empty($po->id))
                    <div class="form-row mb-2 formChange" data-classqty="dataQty1" data-classharga="dataHarga1" data-classdiskon="dataDiskon1" data-classtotal="dataTotal1">
                      <div class="col-md-5">
                        <label for="barangId">Barang</label>
                        <select name="barangId[]" name="barangId" id="barangId1" class="barangId form-control formSelect2 changeForm" data-setharga="price1" data-setdisc="disc1" data-setkemasan="kemasan1" required>
                        </select>

                        <!-- error -->
                          @if($errors->has('barangId'))
                          <div class="text-danger">
                            {{ $errors->first('barangId') }}
                          </div>
                        @endif
                      </div>
                      <div class="col-md-1">
                        <label for="qty">Qty</label>
                        <input type="number" name="qty[]" class="form-control dataQty1" placeholder="Qty" required>

                        <!-- error -->
                        @if($errors->has('qty'))
                          <div class="text-danger">
                            {{ $errors->first('qty') }}
                          </div>
                        @endif
                      </div>
                      <div class="col-md-1">
                        <label for="kemasan">Kemasan</label>
                        <input type="number" name="kemasan[]" class="form-control dataKemasan1 kemasan1" placeholder="" step="0.1" readonly>

                        <!-- error -->
                        @if($errors->has('kemasan'))
                          <div class="text-danger">
                            {{ $errors->first('kemasan') }}
                          </div>
                        @endif
                      </div>
                      <div class="col-md-2">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga[]" id="harga1" class="form-control price1 dataHarga1" placeholder="Harga" required>

                        <!-- error -->
                        @if($errors->has('harga'))
                          <div class="text-danger">
                            {{ $errors->first('harga') }}
                          </div>
                        @endif
                      </div>
                      <div class="col-md-1">
                        <label for="diskon">Diskon</label>
                        <input type="number" name="disc[]" class="form-control disc1 dataDiskon1" placeholder="Disc" step="0.01" required>

                        <!-- error -->
                        @if($errors->has('disc'))
                          <div class="text-danger">
                            {{ $errors->first('disc') }}
                          </div>
                        @endif
                      </div>
                      <div class="col-md-2">
                        <label for="total">Jumlah</label>
                        <input type="number" name="total[]" class="form-control total dataTotal1" placeholder="Total" readonly>
                      </div>
                    </div>
                    
                    @else
                      @php $i = 1; @endphp
                      @foreach($po->detailPO as $row) 
                      <div id="row{{ $i }}">
                        <div class="form-row mb-2 formChange" data-classqty="dataQty{{ $i }}" data-classharga="dataHarga{{ $i }}" data-classdiskon="dataDiskon{{ $i }}" data-classtotal="dataTotal{{ $i }}">
                          <div class="col-md-5">
                            @if(!empty($po->id))
                            <label for="barang">Barang</label>
                            @endif
                            <select name="barangId[]" name="barangId" id="barangId{{ $i }}" class="barangId form-control formSelect2" data-setharga="price{{ $i }}" data-setdisc="disc{{ $i }}" data-setkemasan="kemasan{{ $i }}" required>
                              <option value="{{ $row->barangId }}" selected>{{ $row->barang->kodeBarang.' - '.$row->barang->nama }}</option>
                            </select>
              
                            <!-- error -->
                              @if($errors->has('barangId'))
                              <div class="text-danger">
                                {{ $errors->first('barangId') }}
                              </div>
                            @endif
                          </div>
                          <div class="col-md-1">
                            @if(!empty($po->id))
                            <label for="qty">Qty</label>
                            @endif
                            <input type="number" name="qty[]" class="form-control dataQty{{ $i }}" placeholder="Qty" step="0.1" value="<?= $row->qty ?>" required>
              
                            <!-- error -->
                            @if($errors->has('qty'))
                              <div class="text-danger">
                                {{ $errors->first('qty') }}
                              </div>
                            @endif
                          </div>
                          <div class="col-md-1">
                            @if(!empty($po->id))
                            <label for="kemasan">Kemasan</label>
                            @endif
                            <input type="number" name="kemasan[]" class="form-control dataKemasan{{ $i }} kemasan{{ $i }}" placeholder="" step="0.01" readonly value="<?= $row->satuan ?>">
              
                            <!-- error -->
                            @if($errors->has('kemasan'))
                              <div class="text-danger">
                                {{ $errors->first('kemasan') }}
                              </div>
                            @endif
                          </div>
                          <div class="col-md-2">
                            @if(!empty($po->id))
                            <label for="harga">Harga</label>
                            @endif
                            <input type="number" name="harga[]" class="form-control price{{ $i }} dataHarga{{ $i }}" id="harga{{ $i }}" placeholder="Harga" value="<?= $row->harga ?>" required>
              
                            <!-- error -->
                            @if($errors->has('harga'))
                              <div class="text-danger">
                                {{ $errors->first('harga') }}
                              </div>
                            @endif
                          </div>
                          <div class="col-md-1">
                            @if(!empty($po->id))
                            <label for="disc">Disc</label>
                            @endif
                            <input type="number" name="disc[]" class="form-control disc{{ $i }} dataDiskon{{ $i }}" placeholder="Disc" step="0.01" value="<?= $row->disc ?>">
              
                            <!-- error -->
                            @if($errors->has('disc'))
                              <div class="text-danger">
                                {{ $errors->first('disc') }}
                              </div>
                            @endif
                          </div>

                          @php
                            $total = ($row->harga * $row->qty) - (($row->harga * $row->qty) * ($row->disc / 100));
                          @endphp

                          <div class="col-md-2">
                            @if(!empty($po->id))
                            <label for="total">Jumlah</label>
                            @endif
                            <div class="input-group">
                              <input type="number" name="total[]" class="form-control total dataTotal{{ $i }}" placeholder="Total" readonly value="{{ $total }}">
                              @if($i != 1)
                              <div class="input-group-append">
                                <button class="btn btn-danger cil-minus remove" type="button" id="{{ $i }}"></button>
                              </div>
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                      @php $i++ @endphp
                      @endforeach
                    @endif

                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-9">
                  <label for="note">Note</label>
                    <textarea name="note" id="note" rows="9" class="form-control">{{ $po->note }}</textarea>

                    <button type="submit" class="btn btn-primary mt-3"><i class="cil-save"></i> {{ (empty($po->id))?'Simpan':'Update' }}</button>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="jml">Total</label>
                    <input type="number" name="jml" class="form-control jml" step="0.01" readonly value="{{ $po->total }}">
                  </div>
                  <div class="form-group">
                    <label for="ppn">ppn <span class="text-danger">*10%</span></label>
                    <input type="number" name="ppn" class="form-control ppn" step="0.01" readonly value="{{ $po->ppn }}">
                  </div>
                  <div class="form-group">
                    <label for="grandTotal">Grand Total</label>
                    <input type="number" name="grandTotal" class="form-control grandTotal" step="0.01" readonly value="{{ $po->grandTotal }}">
                  </div>
                </div>
              </div>

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
    var supId = {{ (!empty($po->id))? $po->supplierId : '0' }};
    var i = {{ (!empty($po->id))? $i : '1' }};

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
                text: item.kode+' - '+item.nama,
                id: item.id
              }
            })
          };
        },
        cache: true
      }
    });

    $('.cabangId').select2({
      placeholder: 'Cari cabang...',
      theme: 'bootstrap',
      ajax: {
        type: 'GET',
        url: '{{ route("po.cabang") }}',
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
      supId = supplierId;

      // view data supplier
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

      // nomer PO
      $.ajax({
        type: 'GET',
        url: "{{ route('po.data.nomer') }}",
        data: {
          'id': supplierId,
        },
        success: function(data){
          $('#nomer').val(data);
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

    $(document).on('keydown', '.total', function(e){
      i++;
      
      var code = e.keyCode || e.which;
      if(code == '9'){
        console.log('asd');
        $('#formPlus').append(`
        <div id="row`+i+`">
          <div class="form-row mb-2 formChange" data-classqty="dataQty`+i+`" data-classharga="dataHarga`+i+`" data-classdiskon="dataDiskon`+i+`" data-classtotal="dataTotal`+i+`">
            <div class="col-md-5">
              <select name="barangId[]" name="barangId" id="barangId`+i+`" class="barangId form-control formSelect2" data-setharga="price`+i+`" data-setdisc="disc`+i+`" data-setkemasan="kemasan`+i+`" required>
              </select>

              <!-- error -->
                @if($errors->has('barangId'))
                <div class="text-danger">
                  {{ $errors->first('barangId') }}
                </div>
              @endif
            </div>
            <div class="col-md-1">
              <input type="number" name="qty[]" class="form-control dataQty`+i+`" placeholder="Qty" step="0.1" required>

              <!-- error -->
              @if($errors->has('qty'))
                <div class="text-danger">
                  {{ $errors->first('qty') }}
                </div>
              @endif
            </div>
            <div class="col-md-1">
              <input type="number" name="kemasan[]" class="form-control dataKemasan`+i+` kemasan`+i+`" placeholder="" step="0.01" readonly>

              <!-- error -->
              @if($errors->has('kemasan'))
                <div class="text-danger">
                  {{ $errors->first('kemasan') }}
                </div>
              @endif
            </div>
            <div class="col-md-2">
              <input type="number" name="harga[]" class="form-control price`+i+` dataHarga`+i+`" id="harga`+i+`" placeholder="Harga" required>

              <!-- error -->
              @if($errors->has('harga'))
                <div class="text-danger">
                  {{ $errors->first('harga') }}
                </div>
              @endif
            </div>
            <div class="col-md-1">
              <input type="number" name="disc[]" class="form-control disc`+i+` dataDiskon`+i+`" placeholder="Disc" step="0.01">

              <!-- error -->
              @if($errors->has('disc'))
                <div class="text-danger">
                  {{ $errors->first('disc') }}
                </div>
              @endif
            </div>
            <div class="col-md-2">
              <div class="input-group">
                <input type="number" name="total[]" class="form-control total dataTotal`+i+`" placeholder="Total" readonly>
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
        
        let total = 0;
        let ppn = 0;
        let grandTotal = 0;
        let classQty = '.'+$(this).data('classqty');
        let classHarga = '.'+$(this).data('classharga');
        let classDiskon = '.'+$(this).data('classdiskon');
        let classTotal = '.'+$(this).data('classtotal');

        let qty = $(classQty).val();
        let harga = $(classHarga).val();
        let diskon = $(classDiskon).val();

        total = (harga * qty) - ((qty * harga)*(diskon/100));
        $(classTotal).val(total);
        
        // ppn
        let arrayTotal = $('.total').map(function(){return $(this).val();}).get();
        console.log(arrayTotal);
        for(let i=0; i<arrayTotal.length; i++){
          grandTotal += parseFloat(arrayTotal[i]);
        }
        ppn = grandTotal * 0.1;
        $('.ppn').val(ppn);
        $('.jml').val(grandTotal);
        grandTotal = grandTotal + ppn;
        $('.grandTotal').val(grandTotal);
    });

    // price set
    $(document).on('change', '.barangId', function(){
      var id = $(this).val();
      var setharga = '.'+$(this).data('setharga');
      var setdisc = '.'+$(this).data('setdisc');
      var setkemasan = '.'+$(this).data('setkemasan');

      $.ajax({
        url: "{{ route('po.data.harga') }}",
        type: 'GET',
        data: {
          'barangId': id,
          'supplierId': supId,
          '_token': '{{ csrf_token() }}'
        },
        success: function(data){
          $(setharga).val(data.harga);
          $(setdisc).val(data.diskon);
          $(setkemasan).val(data.berat);
        }
      });
    });

    $(document).on('change', '.formChange', function(){
      let total = 0;
      let ppn = 0;
      let grandTotal = 0;
      let classQty = '.'+$(this).data('classqty');
      let classHarga = '.'+$(this).data('classharga');
      let classDiskon = '.'+$(this).data('classdiskon');
      let classTotal = '.'+$(this).data('classtotal');

      let qty = $(classQty).val();
      let harga = $(classHarga).val();
      let diskon = $(classDiskon).val();

      total = (harga * qty) - ((qty * harga)*(diskon/100));
      $(classTotal).val(total);
      
      // ppn
      let arrayTotal = $('.total').map(function(){return $(this).val();}).get();
      console.log(arrayTotal);
      for(let i=0; i<arrayTotal.length; i++){
        grandTotal += parseFloat(arrayTotal[i]);
      }
      ppn = grandTotal * 0.1;
      $('.ppn').val(ppn);
      $('.jml').val(grandTotal);
      grandTotal = grandTotal + ppn;
      $('.grandTotal').val(grandTotal);
    });

    $(document).ready(function(){
      // isi supplier jika edit
      @if(!empty($po->id))
      $.ajax({
        type: 'POST',
        url: "{{ route('po.data.supplier') }}",
        data: {
          'id': '{{ $po->supplierId }}',
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
      @endif

      // pengiriman bertahap
      $('#pengiriman').on('click', function(){
        if($(this).is(':checked')){
          $('#tglPengiriman').val('');
          $('#tglPengiriman').attr('readonly', 'readonly');
        }else{
          $('#tglPengiriman').removeAttr('readonly');
        }
      });

      // enter disable
      // $('#formPo').keydown(function(event)){
      //   if(event.keyCode == 13){
      //     event.preventDefault();
      //     return false;
      //   }
      // }
    });
    
  </script>
@endsection
