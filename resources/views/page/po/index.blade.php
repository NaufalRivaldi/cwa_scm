@extends('dashboard.base')

@section('content')

<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-md-12">

        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-3">
                <a href="{{ route('po.form') }}" class="btn btn-primary">
                  <i class="cil-plus"></i> Tambah
                </a>
              </div>
              <div class="col-md-9">
                @php
                  $status = '';
                  $tglPO = '';
                  $supplierId = '';
                  if($_GET){
                    $status = $_GET['status'];
                    $tglPO = $_GET['tglPO'];
                    $supplierId = $_GET['supplierId'];
                  }
                @endphp
                <form action="" method="GET" id="form-filter">
                  <div class="form-row">
                    <div class="col">
                      <select name="status" id="status" class="form-control">
                        <option value="">Pilih Status...</option>
                        <option value="1" {{ ($status == '1')?'selected':'' }}>Pending</option>
                        <option value="2" {{ ($status == '2')?'selected':'' }}>Acc</option>
                        <option value="3" {{ ($status == '3')?'selected':'' }}>Ditolak</option>
                        <option value="4" {{ ($status == '4')?'selected':'' }}>Selesai</option>
                      </select>
                    </div>
                    <div class="col">
                      <input type="date" name="tglPO" id="tglPo" class="form-control" value="{{ $tglPO }}">
                    </div>
                    <div class="col">
                      <select name="supplierId" id="supplierId" class="form-control">
                        <option value="">Pilih Supplier...</option>
                        @foreach($supplier as $sply)
                          <option value="{{ $sply->id }}" {{ ($supplierId == $sply->id)?'selected':'' }}>{{ $sply->nama }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped dataTable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>NO PO</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembuat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($po as $row)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->nomer }}</td>
                    <td>{{ dateReverse($row->tglPO) }}</td>
                    <td>{{ $row->supplier->nama }}</td>
                    <td>{{ number_format($row->total) }}</td>
                    <td>{!! statusPO($row->status) !!}</td>
                    <td>{{ $row->user->nama }}</td>
                    <td>
                      <a href ="{{ route('po.view', ['id' => $row->id]) }}" class="btn btn-info btn-sm cil-magnifying-glass"></a>
                      <a href="{{ route('po.edit', ['id' => $row->id]) }}" class="btn btn-warning btn-sm cil-cog"></a>
                      @if(Auth::user()->id == $row->userId && $row->status < '3')
                        <a href="#" class="btn btn-danger btn-sm cil-trash btn-delete" data-id="{{ $row->id }}"></a>
                      @else
                        @if(Auth::user()->status == 1)
                          <a href="#" class="btn btn-danger btn-sm cil-trash btn-delete" data-id="{{ $row->id }}"></a>
                        @endif
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

@section('modal')



@endsection

@section('javascript')

  <script>
    $(document).on('click', '.btn-delete', function(e){
      e.preventDefault();

      var id = $(this).data('id');
      console.log(id);
      swal({
        title: "Hapus Data PO?",
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
            url: "{{ route('po.destroy') }}",
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
