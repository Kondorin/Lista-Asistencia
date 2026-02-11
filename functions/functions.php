<?php

function validate_campo($nombre){


 if (empty($nombre)) {
 
  return true;
 }else{
    
  return false;
 }
}

function valida_campo($newcal){
  if (!isset($newcal)) {

    echo  "<script type=\"text/javascript\"> 
  
    alert('Necesita ingresar una calificacion'); 
    </script>";

    return false;
      
  }else if(!is_numeric($newcal)){
    echo  "<script type=\"text/javascript\"> 
          alert('Solo puede ingresar numeros'); 
          </script>";

        return false;

  }else{
    return true;
  }
}

function valida_campo2($newasist){
  if (empty($newasist)) {

    echo  "<script type=\"text/javascript\"> 
  
    alert('Necesita ingresar un tipo de asistencia'); 
    </script>";

    return false;
      
  }else if(is_numeric($newasist)){
    echo  "<script type=\"text/javascript\"> 
          alert('Solo puede ingresar letras'); 
          </script>";

        return false;

  }else{
    return true;
  }
}

function sesion($a){
  if ($a==0) {
    header('Location: ../web/cerrar_session.php');
  }else if($a==1){
    header('Location: ../web/validar.php');
  }
}

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}


function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}


?>
