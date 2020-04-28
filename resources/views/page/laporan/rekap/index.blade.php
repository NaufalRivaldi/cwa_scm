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
              
                <?php
                    $url = '';
                    if($_GET)
                        $url = '?'.$_SERVER['QUERY_STRING'];
                ?>
                <a href="{{ route('laporan.rekap.export').$url }}" class="btn btn-primary">
                  <i class="cil-print"></i> Export
                </a>
              </div>
              <div class="col-md-9">
                @php
                  $status = '';
                  $tglPO = '';
                  $supplierId = '';
                  $total = 0;
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
                        <option value="2" {{ ($status == '2')?'selected':'' }}>Acc</option>
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
                    <th>Tanggal</th>
                    <th>NO.PO</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Kemasan</th>
                    <th>Tonase</th>
                    <th>TRD</th>
                    <th>TDO</th>
                    <th>TD</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($detailpo as $row)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{!! dateReverse($row->po->tglPO) !!}</td>
                    <td>{{ $row->po->nomer }}</td>
                    <td>{{ $row->barang->nama }}</td>
                    <td>{{ $row->qty }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ (!empty($row->rekap->trd))?$row->rekap->trd:'' }}</td>
                    <td>{{ (!empty($row->rekap->tdo))?$row->rekap->tdo:'' }}</td>
                    <td>{{ (!empty($row->rekap->td))?$row->rekap->td:'' }}</td>
                    <td>{{ (!empty($row->rekap->keterangan))?$row->rekap->keterangan:'' }}</td>
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
