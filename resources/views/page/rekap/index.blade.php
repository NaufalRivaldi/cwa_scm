@extends('dashboard.base')

@section('content')

<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-md-6">

        <div class="card">
          <div class="card-header">
            <h3>Rekap Purchase Order</h3>
          </div>
          <div class="card-body">
            <form action="" method="GET">
              <div class="form-group">
                <label for="nomerPO">Nomer PO</label>
                <select name="id" id="nomer" class="form-control formSelect2"></select>

                <small id="nomerPO" class="form-text text-muted">Cari nomer PO yang akan direkap.</small>
              </div>
              <button type="submit" class="btn btn-primary"><i class="cil-search"></i> Cari Data</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    @if($_GET)
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h4>Nomer PO : {{ $po->nomer }}</h4>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <label for="status" class="float-right col-form-label">Status PO : </label>
                  </div>
                  <div class="col-md-6">
                    <select name="status" id="status" class="form-control" data-id="{{ $po->id }}">
                      <option value="0" {{ ($po->status < '4')?'selected':'' }}>Progress</option>
                      <option value="1" {{ ($po->status == '4')?'selected':'' }}>Selesai</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <h4 class="alert-heading">Note</h4>
              <ul>
                <li><b>TRD</b> : Tanggal Rencana Datang</li>
                <li><b>TDO</b> : Tanggal Delivery Order</li>
                <li><b>TD</b> : Tanggal Datang</li>
              </ul>

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <div class="table-responsive">
              <table class="table table-bordered custom-table rekapTable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Tonase</th>
                    <th>TRD</th>
                    <th>TDO</th>
                    <th>TD</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($detailPo as $row)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $row->barang->kodeBarang }}</td>
                      <td>{{ $row->barang->nama }}</td>
                      <td>{{ $row->qty }}</td>
                      <td>{{ $row->satuan }}</td>
                      <td>{{ $row->satuan * $row->qty }}</td>
                      <td><input type="date" name="trd" class="form-control form-control-sm form-rekap" data-id="{{ $row->id }}" data-type="1" value="{{ (!empty($row->rekap->trd))?$row->rekap->trd:'' }}"></td>
                      <td><input type="date" name="tdo" class="form-control form-control-sm form-rekap" data-id="{{ $row->id }}" data-type="2" value="{{ (!empty($row->rekap->tdo))?$row->rekap->tdo:'' }}"></td>
                      <td><input type="date" name="td" class="form-control form-control-sm form-rekap" data-id="{{ $row->id }}" data-type="3" value="{{ (!empty($row->rekap->td))?$row->rekap->td:'' }}"></td>
                      <td><input type="text" name="keterangan" class="form-control form-control-sm form-rekap" style="width:250px" data-id="{{ $row->id }}" data-type="4" value="{{ (!empty($row->rekap->keterangan))?$row->rekap->keterangan:'' }}"></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif

  </div>
</div>

@endsection

@section('modal')


@endsection

@section('javascript')

  <script>

    $(document).ready(function(){
      $('#nomer').select2({
        placeholder: 'Cari nomer PO...',
        theme: 'bootstrap',
        ajax: {
          type: 'GET',
          url: '{{ route("rekap.nopo") }}',
          dataType: 'json',
          delay: 250,
          processResults: function(data){
            return {
              results: $.map(data, function(item){
                return {
                  text: item.nomer,
                  id: item.id
                }
              })
            };
          },
          cache: true
        }
      });
    });
    
    $('.form-rekap').on('change', function(){
      let val = $(this).val();
      let id = $(this).data('id');
      let type = $(this).data('type');
      // console.log('val: '+val+ ', id: '+id+', type:'+type);
      
      $.ajax({
        type: "POST",
        url: "{{ route('rekap.store') }}",
        data: {
          'id' : id,
          'val' : val,
          'type' : type,
          '_token' : '{{ csrf_token() }}'
        },
        success: function(){
          alertify.set('notifier','position', 'top-right');
          alertify.success('Data Berhasil diinputkan.');
        },
        error: function(){
          alertify.set('notifier','position', 'top-right');
          alertify.error('Data gagal diinputkan!');
        }
      });
    });

    $('#status').on('change', function(){
      let id = $(this).data('id');
      let val = $(this).val();

      $.ajax({
        type: 'POST',
        url: "{{ route('rekap.status') }}",
        data: {
          'id' : id,
          'val' : val,
          '_token' : '{{ csrf_token() }}'
        },
        success: function(){
          alertify.set('notifier','position', 'top-right');
          alertify.success('Data PO berhasil diupdate.');
        },
        error: function(){
          alertify.set('notifier','position', 'top-right');
          alertify.error('Data PO gagal diupdate!');
        }
      });
    });
  </script>
  
@endsection
