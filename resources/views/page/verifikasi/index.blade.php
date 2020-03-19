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
                <form action="{{ route('verifikasi.verifikasi') }}" method="POST" id="formValidasi">
                  @csrf
                  <input type="hidden" name="cek" class="inputCek">
                  <input type="hidden" name="setVerifikasi" class="setVerifikasi">
                  
                </form>
                <button class="btn btn-success btn-verifikasi" disabled="disabled" data-toggle="modal" data-target="#exampleModal"><i class="cil-check"></i> Verifikasi</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped dataTable">
                <thead>
                  <tr>
                    <th><input type="checkbox" name="cekAll" class="cekAll"></th>
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
                    <td><input type="checkbox" name="cek[]" class="cek" value="{{ $row->id }}"></td>
                    <td>{{ $row->nomer }}</td>
                    <td>{{ dateReverse($row->tglPO) }}</td>
                    <td>{{ $row->supplier->nama }}</td>
                    <td>{{ number_format($row->grandTotal) }}</td>
                    <td>{!! statusPO($row->status) !!}</td>
                    <td>{{ $row->user->nama }}</td>
                    <td>
                      <a href ="{{ route('verifikasi.view', ['id' => $row->id]) }}" class="btn btn-info btn-sm cil-magnifying-glass"></a>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verifikasi PO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <button class="btn btn-success btn-block setVerifikasi" data-set="1">Diterima</button>
          </div>
          <div class="col-md-6">
            <button class="btn btn-danger btn-block setVerifikasi" data-set="2">Ditolak</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <p>User ini bertanggung jawab atas verifikasi form PO ini.</p>
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

    $(document).ready(function(){
      let i = 0;
      $('.cekAll').click(function(){
        if(i == 0){
          $('.cek').attr('checked', 'checked');
          i = 1;
        }else{
          $('.cek').removeAttr('checked');
          i = 0;
        }

        setVerifikasi();
      });

      $('.cek').click(function(){
        setVerifikasi();
      });

      $('.setVerifikasi').click(function(){
        let set = $(this).data('set');
        console.log(set);
        switch (set) {
          case 1:
            $('.setVerifikasi').val('1');
            $('#formValidasi').submit();
            break;
        
          default:
            $('.setVerifikasi').val('2');
            $('#formValidasi').submit();
            break;
        }
      });

      function setVerifikasi(){
        let cek = [];

        if($('.cek').is(":checked")){
          $('.btn-verifikasi').removeAttr('disabled');
        }else{
          $('.btn-verifikasi').attr('disabled', 'disabled');
        }

        $.each($('.cek:checked'),function(){
          cek.push($(this).val());
        });

        $('.inputCek').val(cek)
        console.log($('.inputCek').val());
      }
    });
  </script>
  
@endsection
