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
                <a href="{{ route('user.form') }}" class="btn btn-primary">
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
                    <th>Username</th>
                    <th>Tanda Tangan</th>
                    <th>Status</th>
                    <th>Level</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user as $row)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->username }}</td>
                    <td><img src="{{ asset('upload/ttd/'.$row->ttd) }}" alt="ttd-user" width="50"></td>
                    <td>{{ level($row->level) }}</td>
                    <td></td>
                    <td>
                      @if($row->status == 1)
                      <a href="{{ route('user.nonactive', ['id' => $row->id]) }}" class="btn btn-danger btn-sm cil-x-circle"></a>
                      @else
                      <a href="{{ route('user.active', ['id' => $row->id]) }}" class="btn btn-success btn-sm cil-check"></a>
                      @endif

                      <a href="{{ route('user.edit', ['id' => $row->id]) }}" class="btn btn-warning btn-sm cil-cog"></a>
                      @if(Auth::user()->id != $row->id)
                      <a href="#" class="btn btn-danger btn-sm cil-trash btn-delete" data-id="{{ $row->id }}"></a>
                      @endif
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

  <script src="{{ asset('js/Chart.min.js') }}"></script>
  <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
  <script src="{{ asset('js/main.js') }}" defer></script>

  <script>
    $(document).on('click', '.btn-delete', function(e){
      e.preventDefault();

      var id = $(this).data('id');
      console.log(id);
      swal({
        title: "Hapus Data User?",
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
            url: "{{ route('user.destroy') }}",
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
