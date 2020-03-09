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
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-md-6">

        <div class="card">
          <div class="card-header">
            <h3>Data Supplier</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h6>Kode Supplier</h6>
                <p>{{ $supplier->kode }}</p>
                <h6>Nama</h6>
                <p>{{ $supplier->nama }}</p>
                <h6>Alamat</h6>
                <p>{{ $supplier->alamat }}</p>
                <h6>Wilayah</h6>
                <p>{{ $supplier->wilayah->nama }}</p>
                <h6>Telepon</h6>
                <p>{{ $supplier->telp }}</p>
                <h6>Fax</h6>
                <p>{{ $supplier->fax }}</p>
                <h6>Email</h6>
                <p>{{ $supplier->email }}</p>
                <h6>Tax</h6>
                <p>{!! boolean($supplier->tax) !!}</p>
                <h6>Kredit</h6>
                <p>{!! boolean($supplier->kredit) !!}</p>
                <h6>PIC</h6>
                <p>{{ $supplier->pic }}</p>
              </div>  
            </div>  
          </div>
        </div>

      </div>

      <div class="col-md-6">

        <div class="card">
          <div class="card-header">
            <h3>Data Barang</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-striped dataTable">
                    <thead>
                      <tr>
                        <th>Kode</th>
                        <th>Merk</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($barang as $row)
                      <tr>
                        <td>{{ $row->kodeBarang }}</td>
                        <td>{{ $row->merk->nama }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>
                          <a href ="" class="btn btn-info btn-sm cil-magnifying-glass"></a>
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
        title: "Hapus Data Supplier?",
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
            url: "{{ route('supplier.destroy') }}",
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
