<!DOCTYPE html>
<html>
<head>
	<title>PO - {{ $po->nomer }}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
  <style type="text/css">
    body{
      font-size: .6em;
    }

		table tr td,
		table tr th{
			font-size: 1em;
		}

    .page-break {
      page-break-after: always;
    }

    .column{
      width: 50%;
      float: left;
    }

    .columnHeader1{
      float: left;
      width: 20%;
    }

    .columnHeader2{
      float: left;
      width: 60%;
    }
	</style>
  
  <div class="row">
    <div class="columnHeader1">
      <img src="{{ asset('img/logo/logo-trans.png') }}" alt="logo" width="100px">
    </div>
    <div class="columnHeader2 text-center">
      <h6>
        FORMULIR PURCHASE ORDER<br>
        {{ strtoupper($perusahaan->nama) }}<br>
        PESANAN PEMBELIAN/PURCHASE ORDER (PO)<br>
        NO.{{ $po->nomer }}
      </h6>
    </div>
    <div class="columnHeader1">
      <p>
        No Form : FO-SCM-001<br>
        No Revisi : 01<br>
        Tgl Terbit : 29/05/2017
      </p>
    </div>
  </div>
  <br><br><br><br><br><br><hr>
  <div class="row">
    <div class="column">
      <p>
        Kepada Yth,<br>
        {{ $po->supplier->nama }}<br>
        {{ $po->supplier->alamat }}<br>
      </p>
      <table>
        <tr>
          <td>Phone</td>
          <td>:</td>
          <td>{{ $po->supplier->telp }}</td>
        </tr>
        <tr>
          <td>Fax</td>
          <td>:</td>
          <td>{{ $po->supplier->fax }}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td>:</td>
          <td>{{ $po->supplier->email }}</td>
        </tr>
        <tr>
          <td>UP</td>
          <td>:</td>
          <td>{{ $po->supplier->pic }}</td>
        </tr>
      </table>
    </div>
    <div class="column">
      <table class="float-right">
        <tr>
          <td>Tanggal PO</td>
          <td>:</td>
          <td>{{ date('d F Y', strtotime($po->tglPO)) }}</td>
        </tr>
        <tr>
          <td>Cara Pembayaran</td>
          <td>:</td>
          <td>-</td>
        </tr>
        <tr>
          <td>Masa Pembayaran</td>
          <td>:</td>
          <td>{{ $po->supplier->kredit }} Hari</td>
        </tr>
        <tr>
          <td>Tanggal Pengiriman</td>
          <td>:</td>
          <td>{{ date('d F Y', strtotime($po->tglPengiriman)) }}</td>
        </tr>
        <tr>
          <td>Contact Person</td>
          <td>:</td>
          <td>{{ $po->user->nama }}</td>
        </tr>
        <tr>
          <td>E-mail</td>
          <td>:</td>
          <td>{{ $perusahaan->email }}</td>
        </tr>
      </table>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br>
	<div class="row mb-2">
    <div class="col-xs-12">
      <table class='table-bordered' width="100%">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="100px">Kode</th>
            <th width="250px">Nama</th>
            <th>Qty</th>
            <th>Kemasan</th>
            <th>Harga (Rp.)</th>
            <th>Diskon(%)</th>
            <th>Jumlah (Rp.)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($po->detailPO as $row)
          <tr>
            @php
              $total = ($row->qty * $row->harga) - (($row->qty * $row->harga) * ($row->disc / 100));
            @endphp
            <td width="5%">{{ $no++ }}</td>
            <td width="15">{{ $row->barang->kodeBarang }}</td>
            <td width="30%">{{ $row->barang->nama }}</td>
            <td>{{ $row->qty }}</td>
            <td>{{ $row->satuan }}</td>
            <td>{{ number_format($row->harga) }}</td>
            <td>{{ $row->disc }}</td>
            <td class="text-right">{{ number_format($total) }}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" rowspan="3">
              <p>Note :<br>{{ $po->note }}</p>
            </th>
            <th colspan="4" class="text-center">Total</th>
            <th class="text-right">{{ number_format($po->total) }}</th>
          </tr>
          <tr>
            <th colspan="4" class="text-center">PPN</th>
            <th class="text-right">{{ number_format($po->ppn) }}</th>
          </tr>
          <tr>
            <th colspan="4" class="text-center">Grand Total</th>
            <th class="text-right">{{ number_format($po->grandTotal) }}</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12">
      <table class='table table-bordered'>
        <tr>
          <th>Alamat Pengiriman:</th>
          <th>Alamat Penagihan:</th>
        </tr>
        <tr>
          <th>
            {{ $po->cabang->nama }}<br>
            {{ $po->cabang->alamat }}<br>
            P : {{ $po->cabang->alamat }}<br>
            UP : {{ $po->cabang->pic }}
          </th>
          <th>
            {{ $perusahaan->nama }}<br>
            {{ $perusahaan->alamat }}<br>
            P : {{ $perusahaan->alamat }}<br>
            UP : {{ $perusahaan->pic }}
          </th>
        </tr>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="column">
      <br>
        <br>
        <br>
        <br>
        ______________<br>
        {{ $po->supplier->nama }}<br>
        Sales Manajer
    </div>
    <div class="column">
      Diterbitkan oleh,<br>
        <br>
        <br>
        <br>
        <u>{{ $po->user->nama }}</u><br>
        {{ $perusahaan->nama }}<br>
        @php
          if($po->user->level == 1){
            echo "Purchasing";
          }else{
            echo "Kabag SCM";
          }
        @endphp
    </div>
  </div>
 
</body>
</html>