<?php
  ob_start(); // output buffering is turned on

  require_once('functions.php');
  require_once('database.php');
  require_once('query_functions.php');
  

  $db = db_connect(); 

?>
