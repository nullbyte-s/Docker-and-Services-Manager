<?php
session_start();
if(!isset($_SESSION["svcdbauth"])){
  $output = array('auth' => 'false');
  echo json_encode($output);
  exit();
}
?>
