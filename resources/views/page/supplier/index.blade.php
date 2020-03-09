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
                <a href="{{ route('supplier.form') }}" class="btn btn-primary">
                  <i class="cil-plus"></i> Tambah
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped dataTable">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Wilayah</th>
                    <th>Telp</th>
                    <th>Email</th>
                    <th>Tax</th>
                    <th>Kredit</th>
                    <th>Pic</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($supplier as $row)
                  <tr>
                    <td>{{ $row->kode }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->wilayah->nama }}</td>
                    <td>{{ $row->telp }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{!! boolean($row->tax) !!}</td>
                    <td>{!! boolean($row->kredit) !!}</td>
                    <td>{{ $row->pic }}</td>
                    <td>
                      <a href ="{{ route('supplier.view', ['id' => $row->id]) }}" class="btn btn-info btn-sm cil-magnifying-glass"></a>
                      <a href="{{ route('supplier.edit', ['id' => $row->id]) }}" class="btn btn-warning btn-sm cil-cog"></a>
                      <a href="#" class="btn btn-danger btn-sm cil-trash btn-delete" data-id="{{ $row->id }}"></a>
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
