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
                      <th>Kemasan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($po->detailPO as $row)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $row->barang->kodeBarang }}</td>
                      <td>{{ $row->barang->nama }}</td>
                      <td>{{ $row->qty }}</td>
                      <td>{{ $row->satuan }}</td>
                      <td><input type="checkbox" name="item[]" value="{{ $row->id }}" class="item"></td>
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
        let item = [];

        $.each($(".item:checked"), function(){
          item.push($(this).val());
        });

        console.log(item);
      });
    });
  </script>
  
@endsection
