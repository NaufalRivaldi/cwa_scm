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
                <a href="{{ route('barang.form') }}" class="btn btn-primary">
                  <i class="cil-plus"></i> Tambah
                </a>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importModal">
                  <i class="cil-file"></i> Import Master
                </button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importBarangSupplier">
                  <i class="cil-file"></i> Import Harga Barang
                </button>
              </div>
              <div class="col-md-6">
                <form action="" method="GET">
                  <select name="merkId" id="merkId" class="form-control col-md-6 float-right filter-merk">
                    <option value="">Pilih Merk...</option>
                    @foreach($merk as $mr)
                      <option value="{{ $mr->id }}">{{ $mr->nama }}</option>
                    @endforeach
                  </select>
                </form>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-custom tableBarang">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Merk</th>
                    <th>Nama</th>
                    <th>Berat (Kg)</th>
                    <th>Kemasan</th>
                    <th>Base</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
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

<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import Data Excel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('barang.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Pastikan merk sudah ada dimasukkan kedalam data master dan kode merk sama dengan di excel, jika berbeda data tidak akan masuk ke sistem.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="form-group">
            <label for="file">Pilih file excel</label>
            <input type="file" name="file" id="file" class="form-control" required>
            <small>*format file excel dapat di download <a href="{{ asset('format/barang.xlsx') }}">disini</a></small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Import</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="importBarangSupplier" tabindex="-1" role="dialog" aria-labelledby="importBarangSupplierLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importBarangSupplierLabel">Import Data Harga Barang + Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('barang.import.harga') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Pastikan barang dan supplier sudah dimasukkan ke sistem, jika tidak maka proses akan berhenti pada barang atau supplier yang belum diinputkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="form-group">
            <label for="file">Pilih file excel</label>
            <input type="file" name="file" id="file" class="form-control" required>
            <small>*format file excel dapat di download <a href="{{ asset('format/harga-supplier.xlsx') }}">disini</a></small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Import</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('javascript')

  <script>
    $(document).ready(function(){
      // table fill able
      fillTable();

      function fillTable(merkId = ''){
        $('.tableBarang').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url: "{{ route('barang.index') }}",
            type: 'GET',
            data: {
              'merkId': merkId
            }
          },
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'kodeBarang', name: 'kdoeBarang' },
            { data: 'kodeMerk', name: 'kodeMerk' },
            { data: 'nama', name: 'nama' },
            { data: 'berat', name: 'berat' },
            { data: 'kemasan', name: 'kemasan' },
            { data: 'bolBase', name: 'bolBase' },
            { data: 'action', name: 'action' }
          ]
        });
      }

      $('.filter-merk').on('change', function(){
        let val = $(this).val();
        $('.tableBarang').DataTable().destroy();
        fillTable(val);
      });
    });

    $(document).on('click', '.btn-delete', function(e){
      e.preventDefault();

      var id = $(this).data('id');
      console.log(id);
      swal({
        title: "Hapus Data Barang?",
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
