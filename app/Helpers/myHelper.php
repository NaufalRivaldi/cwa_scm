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
}