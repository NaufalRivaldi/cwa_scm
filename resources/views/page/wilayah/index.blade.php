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
                <a href="{{ route('wilayah.form') }}" class="btn btn-primary">
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
                    <th>No</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($wilayah as $row)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->keterangan }}</td>
                    <td>
                      <a href="{{ route('wilayah.edit', ['id' => $row->id]) }}" class="btn btn-warning btn-sm cil-cog"></a>
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

@section('javascript')

  <script>
    $(document).on('click', '.btn-delete', function(e){
      e.preventDefault();

      var id = $(this).data('id');
      console.log(id);
      swal({
        title: "Hapus Data Wilayah?",
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
            url: "{{ route('wilayah.destroy') }}",
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
