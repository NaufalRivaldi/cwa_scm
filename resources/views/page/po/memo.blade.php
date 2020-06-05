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
                <a href="{{ url()->previous() }}" class="btn btn-success">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
                <button class="btn btn-primary print {{ ($po->status == '2')?'':'disabled' }}" target="_BLANK">
                  <i class="cil-print"></i> Print
                </button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-md-12">

        <div class="card">
          <div class="card-header">
            <h3>Memo Pengambilan Barang : {{ $po->nomer }}</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h5>Daftar Barang Order</h5>
                <table class="table table-bordered dataTable">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Qty</th>
                      <th>Jumlah Ambil</th>
                      <th>Kemasan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $i=1; @endphp
                    @foreach($po->detailPO as $row)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $row->barang->kodeBarang }}</td>
                      <td>{{ $row->barang->nama }}</td>
                      <td>{{ $row->qty }}</td>
                      <td><input type="number" nama="jmlAmbil[]" max="{{ $row->qty }}" class="form-control form-control-sm jmlAmbil jml{{ $i }}" disabled></td>
                      <td>{{ $row->satuan }}</td>
                      <td><input type="checkbox" name="item[]" value="{{ $row->id }}" class="item" data-i="{{ $i++ }}"></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
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
    $(document).ready(function(){
      $('.print').on('click', function(){
        let item = '';
        let qty = '';

        $.each($(".item:checked"), function(){
          item = item+$(this).val()+',';
        });

        console.log($('.jmlAmbil').val());

        $.each($(".jmlAmbil"), function(){
          qty = qty+$(this).val()+',';
        });

        let newItem = item.substring(0, item.length - 1);
        let newQty = qty.substring(0, qty.length - 1);
        let link = "{{ url('po/memo/print/').'/'.$po->id }}"+'/'+newItem+'/'+newQty;
        
        if(item != ''){
          window.open(link);
        }else{
          alert('Barang tidak dipilih!');
        }
      });

      $('.item').on('click', function(){
        let i = $(this).data('i');
        
        if($(this).is(':checked')) {
          $('.jml'+i).removeAttr('disabled');
        }else{
          $('.jml'+i).prop('disabled', true);
        }
      });
    });
  </script>
  
@endsection
