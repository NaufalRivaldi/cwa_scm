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

                <button class="btn btn-info" data-toggle="modal" data-target="#modalImport">
                  <i class="cil-file"></i> Import Barang
                </button>
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
                    <label for="metodePembayaran">Jenis Pembayaran</label>
                    <select name="metodePembayaran" id="metodePembayaran" class="form-control" required>
                      <option value="">Pilih</option>
                      <option value="TF" {{ ($po->metodePembayaran == 'TF')?'selected':'' }}>Transfer</option>
                      <option value="BG" {{ ($po->metodePembayaran == 'BG')?'selected':'' }}>BG</option>
                      <option value="CASH" {{ ($po->metodePembayaran == 'CASH')?'selected':'' }}>Cash</option>
                    </select>
    
                    <!-- error -->
                    @if($errors->has('metodePembayaran'))
                      <div class="text-danger">
                        {{ $errors->first('metodePembayaran') }}
                      </div>
                    @endif
                  </div>
                </div>

              </div>
              <hr>
              <div class="form-row">
                <div class="col-md-5">
                  <label for="barangId">Barang</label>
                </div>
                <div class="col-md-1">
                  <label for="qty">Qty</label>
                </div>
                <div class="col-md-1">
                  <label for="kemasan">Kemasan</label>
                </div>
                <div class="col-md-2">
                  <label for="harga">Harga <small class="text-info">*include ppn</small></label>
                </div>
                <div class="col-md-1">
                  <label for="diskon">Diskon</label>
                </div>
                <div class="col-md-2">
                  <label for="total">Jumlah</label>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-12">
                  
                  <div id="formPlus">
                    @php $i=1; @endphp
                    @if(empty($po->id))
                      @if(!$_POST)
                        <div id="row1">
                          <input type="hidden" name="item[]" value="{{ $i }}">
                          <div class="form-row mb-2 formChange" data-classqty="dataQty1" data-classharga="dataHarga1" data-classdiskon="dataDiskon1" data-classtotal="dataTotal1">
                            <div class="col-md-5">
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
                              <input type="number" name="qty[]" class="form-control dataQty1" placeholder="Qty" required>
      
                              <!-- error -->
                              @if($errors->has('qty'))
                                <div class="text-danger">
                                  {{ $errors->first('qty') }}
                                </div>
                              @endif
                            </div>
                            <div class="col-md-1">
                              <input type="text" name="kemasan[]" class="form-control dataKemasan1 kemasan1" placeholder="" readonly>
      
                              <!-- error -->
                              @if($errors->has('kemasan'))
                                <div class="text-danger">
                                  {{ $errors->first('kemasan') }}
                                </div>
                              @endif
                            </div>
                            <div class="col-md-2">
                              <input type="number" name="harga[]" id="harga1" class="form-control price1 dataHarga1" placeholder="Harga" required>
      
                              <!-- error -->
                              @if($errors->has('harga'))
                                <div class="text-danger">
                                  {{ $errors->first('harga') }}
                                </div>
                              @endif
                            </div>
                            <div class="col-md-1">
                              <input type="text" name="disc[]" class="form-control disc1 dataDiskon1" placeholder="Disc" step="0.01" required>
      
                              <!-- error -->
                              @if($errors->has('disc'))
                                <div class="text-danger">
                                  {{ $errors->first('disc') }}
                                </div>
                              @endif
                            </div>
                            <div class="col-md-2">
                              <div class="input-group">
                                <input type="number" name="total[]" class="form-control total dataTotal1" placeholder="Total" readonly>
                                <div class="input-group-append">
                                  <button class="btn btn-danger cil-minus remove" type="button" id="1"></button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @else
                        @foreach($imports as $import)
                          <div id="row{{$i}}">
                            <input type="hidden" name="item[]" value="{{ $i }}">
                            <div class="form-row mb-2 formChange" data-classqty="dataQty{{$i}}" data-classharga="dataHarga{{$i}}" data-classdiskon="dataDiskon{{$i}}" data-classtotal="dataTotal{{$i}}">
                              <div class="col-md-5">
                                <select name="barangId[]" name="barangId" id="barangId{{$i}}" class="barangId form-control formSelect2 changeForm" data-setharga="price{{$i}}" data-setdisc="disc{{$i}}" data-setkemasan="kemasan{{$i}}" required>
                                  <option value="{{ $import->barangId }}">{{ $import->barang->kodeBarang.' - '.$import->barang->nama }}</option>
                                </select>
        
                                <!-- error -->
                                  @if($errors->has('barangId'))
                                  <div class="text-danger">
                                    {{ $errors->first('barangId') }}
                                  </div>
                                @endif
                              </div>
                              <div class="col-md-1">
                                <input type="number" name="qty[]" class="form-control dataQty{{$i}}" placeholder="Qty" value="{{ $import->order }}" required>
        
                                <!-- error -->
                                @if($errors->has('qty'))
                                  <div class="text-danger">
                                    {{ $errors->first('qty') }}
                                  </div>
                                @endif
                              </div>
                              <div class="col-md-1">
                                <input type="text" name="kemasan[]" class="form-control dataKemasan{{$i}} kemasan{{$i}}" value="{{ $import->barang->kemasan }}" placeholder="" readonly>
        
                                <!-- error -->
                                @if($errors->has('kemasan'))
                                  <div class="text-danger">
                                    {{ $errors->first('kemasan') }}
                                  </div>
                                @endif
                              </div>
                              <div class="col-md-2">
                                <input type="number" name="harga[]" id="harga{{$i}}" class="form-control price1 dataHarga{{$i}}" placeholder="Harga" value="0" required>
        
                                <!-- error -->
                                @if($errors->has('harga'))
                                  <div class="text-danger">
                                    {{ $errors->first('harga') }}
                                  </div>
                                @endif
                              </div>
                              <div class="col-md-1">
                                <input type="text" name="disc[]" class="form-control disc{{$i}} dataDiskon{{$i}}" value="0" placeholder="Disc" step="0.01" required>
        
                                <!-- error -->
                                @if($errors->has('disc'))
                                  <div class="text-danger">
                                    {{ $errors->first('disc') }}
                                  </div>
                                @endif
                              </div>
                              <div class="col-md-2">
                                <div class="input-group">
                                  <input type="number" name="total[]" class="form-control total dataTotal{{$i}}" placeholder="Total" value="0" readonly>
                                  <div class="input-group-append">
                                    <button class="btn btn-danger cil-minus remove" type="button" id="{{ $i++ }}"></button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                        @php $i-- @endphp
                      @endif
                    
                    
                    @else
                      @foreach($po->detailPO as $row) 
                      <div id="row{{ $i }}">
                        <input type="hidden" name="item[]" value="{{ $i }}">
                        <div class="form-row mb-2 formChange" data-classqty="dataQty{{ $i }}" data-classharga="dataHarga{{ $i }}" data-classdiskon="dataDiskon{{ $i }}" data-classtotal="dataTotal{{ $i }}">
                          <div class="col-md-5">
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
                            @endif
                            <input type="text" name="kemasan[]" class="form-control dataKemasan{{ $i }} kemasan{{ $i }}" placeholder="" readonly value="<?= $row->barang->kemasan ?>">
              
                            <!-- error -->
                            @if($errors->has('kemasan'))
                              <div class="text-danger">
                                {{ $errors->first('kemasan') }}
                              </div>
                            @endif
                          </div>
                          <div class="col-md-2">
                            <input type="number" name="harga[]" class="form-control price{{ $i }} dataHarga{{ $i }}" id="harga{{ $i }}" placeholder="Harga" value="<?= $row->harga ?>" required>
              
                            <!-- error -->
                            @if($errors->has('harga'))
                              <div class="text-danger">
                                {{ $errors->first('harga') }}
                              </div>
                            @endif
                          </div>
                          <div class="col-md-1">
                            <input type="text" name="disc[]" class="form-control disc{{ $i }} dataDiskon{{ $i }}" placeholder="Disc" value="<?= $row->disc ?>">
              
                            <!-- error -->
                            @if($errors->has('disc'))
                              <div class="text-danger">
                                {{ $errors->first('disc') }}
                              </div>
                            @endif
                          </div>

                          <div class="col-md-2">
                            <div class="input-group">
                              <input type="number" name="total[]" class="form-control total dataTotal{{ $i }}" placeholder="Total" readonly value="{{ diskon($row->harga, $row->qty, $row->disc) }}">
                              <div class="input-group-append">
                                <button class="btn btn-danger cil-minus remove" type="button" id="{{ $i }}"></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @php $i++ @endphp
                      @endforeach
                      @php $i-- @endphp
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
                    <small class="text-info">*include ppn</small>

                    <!-- error -->
                    @if($errors->has('jml'))
                      <div class="text-danger">
                        {{ $errors->first('jml') }}
                      </div>
                    @endif
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

@section('modal')

<!-- Modal -->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalImportLabel">Import List Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('po.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="file">File excel:</label>
            <input type="file" name="file" class="form-control" required>
            <small class="small-text">*Format xlsx, lihat format import <a href="{{ asset('format/list-barang.xlsx') }}">disini</a>.</small><br>
            
            <!-- error -->
            @if($errors->has('file'))
              <small class="text-danger">{{ $errors->first('file') }}</small>
            @endif
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Import Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('javascript')
  <script>
    var supId = {{ (!empty($po->id))? $po->supplierId : '0' }};
    var i = {{ $i }};
    console.log(i);

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
      var countItem = $('#countItem').data('val');
      let jumlah = 0;

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

      // set harga
      $('input[name^="item"]').each(function() {
        var item = $(this).val();

        $.ajax({
          url: "{{ route('po.data.harga') }}",
          type: 'GET',
          data: {
            'barangId': $('#barangId'+item).val(),
            'supplierId': supId
          },
          success: function(data){
            $('.dataHarga'+item).val(data.harga);
            $('.dataDiskon'+item).val(data.diskon);

            let qty = $('.dataQty'+item).val();
            let harga = data.harga;
            let diskon = data.diskon;
            let valArray = diskon.split("+");
            let totalHarga = 0;
            let totalDiskon = 0;
            let total = 0;

            if(diskon != 0){
              for(let i=0; i<valArray.length; i++){
                if(i>0){
                  totalDiskon += (totalHarga)*(valArray[i]/100);
                }else{
                  totalDiskon += (qty * harga)*(valArray[i]/100);
                  totalHarga = ((qty * harga) - totalDiskon);
                }
              }
            }else{
              totalDiskon = 0;
            }

            total = (harga * qty) - totalDiskon;
            $('.dataTotal'+item).val(total);
            jumlah += total;
            $('.jml').val(jumlah);
          }
        });
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

    $(document).on('keydown', '.total', function(e){
      i++;
      
      var code = e.keyCode || e.which;
      var countItem = parseInt($('#countItem').data('val'), 10);

      if(code == '9'){
        $('#formPlus').append(`
        <div id="row`+i+`">
          <input type="hidden" name="item[]" value="`+i+`">
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
              <input type="text" name="kemasan[]" class="form-control dataKemasan`+i+` kemasan`+i+`" placeholder="" readonly>

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
              <input type="text" name="disc[]" class="form-control disc`+i+` dataDiskon`+i+`" placeholder="Disc" step="0.01">

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
        let totalDiskon = 0;
        let ppn = 0;
        let grandTotal = 0;

        let arrayTotal = $('.total').map(function(){return $(this).val();}).get();
        for(let i=0; i<arrayTotal.length; i++){
          grandTotal += parseFloat(arrayTotal[i]);
        }

        $('.jml').val(grandTotal);
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
          $(setkemasan).val(data.kemasan);
        }
      });
    });

    $(document).on('change', '.formChange', function(){
      let total = 0;
      let totalDiskon = 0;
      let ppn = 0;
      let grandTotal = 0;
      let classQty = '.'+$(this).data('classqty');
      let classHarga = '.'+$(this).data('classharga');
      let classDiskon = '.'+$(this).data('classdiskon');
      let classTotal = '.'+$(this).data('classtotal');

      let qty = $(classQty).val();
      let harga = $(classHarga).val();
      let diskon = $(classDiskon).val();
      let valArray = diskon.split("+");
      let totalHarga = 0;

      if(diskon != 0){
        for(let i=0; i<valArray.length; i++){
          if(i>0){
            totalDiskon += (totalHarga)*(valArray[i]/100);
          }else{
            totalDiskon += (qty * harga)*(valArray[i]/100);
            totalHarga = ((qty * harga) - totalDiskon);
          }
        }
      }else{
        totalDiskon = 0;
      }

      total = (harga * qty) - totalDiskon;
      $(classTotal).val(total);

      let arrayTotal = $('.total').map(function(){return $(this).val();}).get();
      for(let i=0; i<arrayTotal.length; i++){
        grandTotal += parseFloat(arrayTotal[i]);
      }
      $('.jml').val(grandTotal);
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
          var today = new Date();
          var dd = String(today.getDate()).padStart(2, '0');
          var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
          var yyyy = today.getFullYear();

          today = yyyy + '-' + mm + '-' + dd;
          $('#tglPengiriman').removeAttr('readonly');
          $('#tglPengiriman').val(today);
        }
      });
    });

    $(document).keypress(
      function(event){
        if (event.which == '13') {
          $(this).next().focus();
          event.preventDefault();
        }
    });
    
  </script>
@endsection
