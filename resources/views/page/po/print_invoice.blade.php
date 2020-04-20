<!DOCTYPE html>
<html>
<head>
	<title>PO - {{ $po->nomer }}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  
  <style>
    body{
      font-size: 9px;
      padding: 0;
      margin: 0;
    }

    .row-n{
      width: 100%;
      height: auto;
      display: block;
    }
    
    .header1{
      float:left;
      width:20%;
    }

    .header2{
      float:left;
      width:60%;
      text-align:center;
      font-weight:bold;
    }

    .column{
      float: left;
      width: 50%;
    }

    .img-ttd{
      position: absolute;
      top: 5;
    }

    .img-cap{
      position: absolute;
      top: 15;
      opacity: .5;
    }

    .table-custom > thead > tr > th{
      border: 1px solid #000 !important;
    }

    .table-custom > tbody > tr > td{
      border: 1px solid #000 !important;
    }

    .table-custom > tfoot > tr > th{
      border: 1px solid #000 !important;
    }
  </style>
</head>
<body>
  <div class="row-n">
    <div class="header1">
      <img src="{{ asset('upload/logo/'.$perusahaan->logo) }}" alt="logo" width="70px">
    </div>
    <div class="header2">
      <p>
        FORMULIR PURCHASE ORDER<br>
        {{ strtoupper($perusahaan->nama) }}<br>
        PESANAN PEMBELIAN/PURCHASE ORDER (PO)<br>
        NO.{{ $po->nomer }}
      </p>
    </div>
    <div class="header1" style="font-size:.8em">
      <p>
        No Form : FO-SCM-001<br>
        No Revisi : 01<br>
        Tgl Terbit : 29/05/2017
      </p>
    </div>
  </div>
  <br><br><br><br><br>
  <hr>
  <div class="row-n">
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
  <div class="row-n">
    <table class='table-custom' width="100%">
      <thead>
        <tr>
          <th width="5%">No</th>
          <th width="70px">Kode</th>
          <th width="120px">Nama</th>
          <th>Qty</th>
          <th>Kemasan</th>
          <th>Harga (Rp.)</th>
          <th>Disc(%)</th>
          <th width="70px">Jumlah (Rp.)</th>
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
  <br><br><br><br>
  <div class="row-n">
    <table class='table table-custom'>
      <thead>
        <tr>
          <th>Alamat Pengiriman:</th>
          <th>Alamat Penagihan:</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            {{ $po->cabang->nama }}<br>
            {{ $po->cabang->alamat }}<br>
            P : {{ $po->cabang->alamat }}<br>
            UP : {{ $po->cabang->pic }}
          </td>
          <td>
            {{ $perusahaan->nama }}<br>
            {{ $perusahaan->alamat }}<br>
            P : {{ $perusahaan->alamat }}<br>
            UP : {{ $perusahaan->pic }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="row-n">
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
      <img src="{{ asset('upload/ttd/'.$po->user->ttd) }}" alt="ttd-user" width="75" class="img-ttd">
      <img src="{{ asset('upload/cap/'.$perusahaan->cap) }}" alt="ttd-user" width="65" class="img-cap">
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


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>