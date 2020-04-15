<!DOCTYPE html>
<html>
<head>
	<title></title>
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
      width:50%;
      font-weight:bold;
    }

    .header2{
      float:right;
      width:50%;
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

    .hr {
      display: block;
      border: 1px solid black;
      margin: 20px 0px 5px px;
    }
  </style>
</head>
<body>
  <br>
  <div class="row-n">
    <div class="header1">
      Tanggal Export : {{ $date }}
    </div>
    <div class="header2">
      User: {{ $user }}
    </div>
  </div>
  <br><hr class="hr">
  <div class="row-n">
    @foreach($po as $row)  
      <table>
          <tr>
            <td>No. PO</td>
            <td>:</td>
            <td>{{ $row->nomer }}</td>
          </tr>
          <tr>
            <td>Supplier</td>
            <td>:</td>
            <td>{{ $row->supplier->nama }}</td>
          </tr>
          <tr>
            <td>Tanggal PO</td>
            <td>:</td>
            <td>{!! dateReverse($row->tglPO) !!}</td>
          </tr>
      </table> 
      @foreach($row->detailPO as $dp)
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>\
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Qty</th>
              <th>Satuan</th>
              <th>Tonase</th>
              <th>TRD</th>
              <th>TDO</th>
              <th>TD</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $dp->barang->kodeBarang }}</td>
            <td>{{ $dp->barang->nama }}</td>
            <td>{{ $dp->qty }}</td>
            <td>{{ $dp->satuan }}</td>
            <td>{{ $dp->satuan * $dp->qty }}</td>
            <td>{!! dateReverse((!empty($dp->rekap->tdo))?$dp->rekap->tdo:'') !!}</td>
            <td>{!! (!empty($dp->rekap->tdo))?dateReverse($dp->rekap->tdo):'' !!}</td>
            <td>{!! (!empty($dp->rekap->td))?dateReverse($dp->rekap->td):'' !!}</td>
            <td>{{ (!empty($dp->rekap->keterangan))?$dp->rekap->keterangan:'' }}</td>
          </tr>
        </table>
      @endforeach
    @endforeach
    <div class="alert alert-waring">
    <p>Keterangan</p>
      <ul>
        <li>TRD : Tanggal Rencana Datang</li>
        <li>TDO : Tanggal Delivery Order</li>
        <li>TD  : Tanggal Datang</li>
      </ul>
    </div>
  </div>
    
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>