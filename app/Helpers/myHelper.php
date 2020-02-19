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
}