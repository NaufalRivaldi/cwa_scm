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
    <div class="row">
      <div class="col-md-5">

        <div class="card">
          <div class="card-header">
            <h3>Data Barang</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h6>Merk</h6>
                <p>{{ $barang->merk->kodeMerk.' - '.$barang->merk->nama }}</p>
                <h6>Kode</h6>
                <p>{{ $barang->kodeBarang }}</p>
                <h6>Nama</h6>
                <p>{{ $barang->nama }}</p>
                <h6>Base</h6>
                <p>{!! boolean($barang->base) !!}</p>
                <h6>Berat (Kg)</h6>
                <p>{{ $barang->berat }}</p>
              </div>  
            </div>  
          </div>
        </div>

      </div>

      <div class="col-md-7">

        <div class="card">
          <div class="card-header">
            <h3>Daftar Harga</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-striped dataTable">
                    <thead>
                      <tr>
                        <th>Supplier</th>
                        <th>Wilayah</th>
                        <th>Harga(Rp)</th>
                        <th>Diskon(%)</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($barang->supply as $row)
                      <tr>
                        <td>{{ $row->supplier->nama }}</td>
                        <td>{{ $row->supplier->wilayah->nama }}</td>
                        <td>{{ $row->harga }}</td>
                        <td>{{ $row->diskon }}</td>
                        <td>
                          <a href ="" class="btn btn-warning btn-sm cil-cog"></a>
                        </td>
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

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Histori PO
          </div>
          <div class="card-body">
            <table class="table table-bordered dataTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No PO</th>
                  <th>Tanggal</th>
                  <th>Supplier</th>
                  <th>Qty</th>
                </tr>
              </thead>
              <tbody>
                @php $no = 1; @endphp
                @foreach($barang->detailPO as $row)
                  @if($row->po->status != '3')
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $row->po->nomer }}</td>
                      <td>{{ $row->po->tglPO }}</td>
                      <td>{{ $row->po->supplier->nama }}</td>
                      <td>{{ $row->qty }}</td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
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
    $(document).on('click', '.btn-delete', function(e){
      e.preventDefault();

      var id = $(this).data('id');
      console.log(id);
      swal({
        title: "Hapus Data barang?",
        text: "Data akan terhapus secara permanen.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            type: 'POST',
            data: {
              'id': id,
              '_token': '{{ csrf_token() }}'
            },
            url: "{{ route('barang.destroy') }}",
            success: function(data){
              location.reload();
              // console.log(data);
            }
          });
        }
      });
    });
  </script>
  
@endsection
