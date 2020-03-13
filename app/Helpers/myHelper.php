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

}