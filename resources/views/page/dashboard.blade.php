@extends('dashboard.base')

@section('content')

<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-md-3">
        <div class="card text-white bg-primary">
          <div class="card-header">
            <i class="cil-cart"></i> Supplier
          </div>
          <div class="card-body">
            <h3>{{ $supplier->count() }}</h3>
            <small>Supply barang.</small>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-white bg-warning">
          <div class="card-header">
            <i class="cil-factory"></i> Cabang
          </div>
          <div class="card-body">
            <h3>{{ $cabang->count() }}</h3>
            <small>PT. CITRA WARNA JAYA ABADI</small>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-white bg-success">
          <div class="card-header">
            <i class="cil-factory"></i> Purchase Order
          </div>
          <div class="card-body">
            <h3>{{ $po->count() }}</h3>
            <small>Pending</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')

    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
