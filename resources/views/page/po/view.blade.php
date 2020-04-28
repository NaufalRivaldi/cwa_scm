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
                <a href="{{ route('po.index') }}" class="btn btn-success">
                  <i class="cil-arrow-circle-left"></i> Kembali
                </a>
                <a href="{{ route('po.print', ['id' => $po->id]) }}" class="btn btn-primary {{ ($po->status == '2')?'':'disabled' }}" target="_BLANK">
                  <i class="cil-print"></i> Print
                </a>
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
            <h3>Purchase Order</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <table class="table">
                  <tr>
                    <td width="20%">Status</td>
                    <td width="1%">:</td>
                    <td>{!! statusPO($po->status) !!} {{ ($po->status != '2')?' , Tidak dapat melakukan print PO.':'' }}</td>
                  </tr>
                  <tr>
                    <td width="20%">Nomer PO</td>
                    <td width="1%">:</tdw>
                    <td>{{ $po->nomer }}</td>
                  </tr>
                  <tr>
                    <td width="20%">Tanggal Pembuatan</td>
                    <td width="1%">:</td>
                    <td>{{ dateReverse($po->tglPO) }}</td>
                  </tr>
                  <tr>
                    <td width="20%">Tanggal Pengiriman</td>
                    <td width="1%">:</td>
                    <td>{{ ($po->tglPengiriman != '1000-01-01')?dateReverse($po->tglPengiriman):'Pengiriman Bertahap' }}</td>
                  </tr>
                  <tr>
                    <td width="20%">Masa Pembayaran</td>
                    <td width="1%">:</td>
                    <td>{{ $po->supplier->kredit }} Hari</td>
                  </tr>
                  <tr>
                    <td width="20%">Jenis Pembayaran</td>
                    <td width="1%">:</td>
                    <td>{{ metodePembayaran($po->metodePembayaran) }}</td>
                  </tr>
                  <tr>
                    <td width="20%">Pembuat</td>
                    <td width="1%">:</td>
                    <td>{{ $po->user->nama }}</td>
                  </tr>
                </table>
              </div> 
            </div>  
            <hr>
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Supplier</h5>
                  </div>
                  <div class="card-body">
                    <h6>Nama</h6>
                    <p>{{ $po->supplier->nama }}</p>
                    <h6>Alamat</h6>
                    <p>{{ $po->supplier->alamat }}</p>
                    <h6>Telepon / fax</h6>
                    <p>{{ $po->supplier->telp.' / '.$po->supplier->fax }}</p>
                    <h6>Email</h6>
                    <p>{{ $po->supplier->email }}</p>
                    <h6>UP</h6>
                    <p>{{ $po->supplier->pic }}</p>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Alamat Pengiriman</h5>
                  </div>
                  <div class="card-body">
                    <h6>Nama</h6>
                    <p>{{ $po->cabang->nama }}</p>
                    <h6>Alamat</h6>
                    <p>{{ $po->cabang->alamat }}</p>
                    <h6>Telepon</h6>
                    <p>{{ $po->cabang->telp }}</p>
                    <h6>Email</h6>
                    <p>{{ $po->cabang->pic }}</p>
                    <h6>UP</h6>
                    <p>{{ $po->cabang->pic }}</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <h5>Daftar Barang Order</h5>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Qty</th>
                      <th>Kemasan</th>
                      <th>Harga</th>
                      <th>Diskon</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($po->detailPO as $row)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $row->barang->kodeBarang }}</td>
                      <td>{{ $row->barang->nama }}</td>
                      <td>{{ $row->qty }}</td>
                      <td>{{ $row->satuan }}</td>
                      <td>{{ number_format($row->harga) }}</td>
                      <td>{{ $row->disc }}</td>
                      <td class="text-right">{{ number_format(diskon($row->harga, $row->qty, $row->disc)) }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="3" width="50%">
                        <h6>Note :</h6>
                        <p>{{ $po->note }}</p>
                      </th>
                      <th colspan="4" class="text-center">Total</th>
                      <th class="text-right">{{ number_format($po->total) }}</th>
                    </tr>
                    <tr>
                      <th colspan="8">
                        Terbilang : {{ ucwords(terbilang($po->total)) }}
                      </th>
                    </tr>
                  </tfoot>
                </table>
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
