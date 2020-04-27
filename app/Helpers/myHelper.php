<?php 

if (! function_exists('on_php_id')) {
  
  function level($val){
    $level = '';
    switch ($val) {
      case '1':
        $level = 'Admin';
        break;

      case '2':
        $level = 'Superuser';
        break;
      
      default:
        # code...
        break;
    }
    return $level;
  }

  function status($val){
    $status = '';
    switch ($val) {
      case '1':
        $status = '<span class="badge badge-info">Aktif</span>';
        break;

      case '2':
        $status = '<span class="badge badge-danger">Tidak Aktif</span>';
        break;
      
      default:
        # code...
        break;
    }
    return $status;
  }

  function boolean($val){
    $text = '';
    switch ($val) {
      case '1':
        $text = '<span class="badge badge-success">True</span>';
        break;

      case '0':
        $text = '<span class="badge badge-danger">false</span>';
        break;
      
      default:
        # code...
        break;
    }

    return $text;
  }

  function dateReverse($date){
    return date('d-m-Y', strtotime($date));
  }

  function statusPO($val){
    $text = '';
    switch ($val) {
      case '1':
        $text = '<span class="badge badge-warning">Pending</span>';
        break;

      case '2':
        $text = '<span class="badge badge-success">Acc</span>';
        break;

      case '3':
        $text = '<span class="badge badge-danger">Ditolak</span>';
        break;
      
      default:
        $text = '<span class="badge badge-info">Selesai</span>';
        break;
    }

    return $text;
  }

  function isSU($status){
    if($status == '2'){
      return true;
    }else{
      return false;
    }
  }

  function metodePembayaran($val){
    $text = '';
    switch ($val) {
      case 'TF':
        $text = 'Transfer';
        break;
      case 'BG':
        $text = 'Bilyet Giro';
        break;
      case 'CASH':
        $text = 'Cash';
        break;
      default:
        $text = 'None';
        break;
    }

    return $text;
  }

  function diskon($harga, $qty, $disc){
    $totalDiskon = 0;
    $harga = $qty * $harga;
    $discArray = explode('+', $disc);

    for($i=0; $i<count($discArray); $i++){
      $totalDiskon = $harga * ($discArray[$i] / 100);
      $harga = $harga - $totalDiskon;
    }
    
    return $harga;
  }

  function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}

}