<?php
session_start();

$auth = isset($_COOKIE["login_svcdbauth"]) || isset($_SESSION["svcdbauth"]);

$output = array('auth' => $auth ? 'true' : 'false');
echo json_encode($output);
exit();
?>