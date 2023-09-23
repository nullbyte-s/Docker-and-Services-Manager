<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require "backend/Config.php";
$config = new Config;
$config->load("local.config");

$auth = (isset($_SESSION["svcdbauth"])) || (isset($_COOKIE["login_svcdbauth"])) ? true : false;

$path=$_SERVER['SCRIPT_FILENAME'];
$fol=substr($path, 0, -9);

$passVal = ($config->get("general.pass")!=='c21f969b5f03d33d43e04f8f136e7682') ? "***notdefault***" : '';

$string = trim(preg_replace('/\s\s+/', '', shell_exec("hostname")));
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="apple-touch-icon" sizes="180x180" href="icons/apple-touch-icon.png?v=PYAg5Ko93z">
<link rel="icon" type="image/png" sizes="32x32" href="icons/favicon-32x32.png?v=PYAg5Ko93z">
<link rel="icon" type="image/png" sizes="16x16" href="icons/favicon-16x16.png?v=PYAg5Ko93z">
<link rel="manifest" href="icons/site.webmanifest?v=PYAg5Ko93z">
<link rel="mask-icon" href="icons/safari-pinned-tab.svg?v=PYAg5Ko93z" color="#b91d47">
<link rel="shortcut icon" href="icons/favicon.ico?v=PYAg5Ko93z">
<meta name="apple-mobile-web-app-title" content="Docker and Services Manager">
<meta name="application-name" content="Docker and Services Manager">
<meta name="msapplication-TileColor" content="#b91d47">
<meta name="msapplication-TileImage" content="icons/mstile-144x144.png?v=PYAg5Ko93z">
<meta name="msapplication-config" content="icons/browserconfig.xml?v=PYAg5Ko93z">
<meta name="theme-color" content="#b91d47">

<link rel="stylesheet" href="css/bootstrap-4.6.0.min.css">
<link rel="stylesheet" href="css/bootstrap-icons.css?v=1.4.0">
<link rel="stylesheet" href="css/darkmode.css?v=1.1.0" id="dmcss" type="text/css">
<link rel="stylesheet" href="css/mdtoast.min.css?v=2.0.2">

<title><?php system("hostname");?> - Gerenciando serviços...</title>

<style>
/* rubik-300 - latin */
@font-face {
  font-family: 'Rubik';
  font-style: normal;
  font-weight: 300;
  src: url('fonts/rubik-v12-latin-300.eot'); /* IE9 Compat Modes */
  src: local(''),
    url('fonts/rubik-v12-latin-300.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
    url('fonts/rubik-v12-latin-300.woff2') format('woff2'), /* Super Modern Browsers */
    url('fonts/rubik-v12-latin-300.woff') format('woff'), /* Modern Browsers */
    url('fonts/rubik-v12-latin-300.ttf') format('truetype'), /* Safari, Android, iOS */
    url('fonts/rubik-v12-latin-300.svg#Rubik') format('svg'); /* Legacy iOS */
}
body, .mdtoast{
  font-family: 'Rubik', sans-serif;
}
.hidden{
  display: none;
}
@media screen and (max-width: 530px) {
  #notf {
    display: block;
  }
  #dot{
    display:none;
  }
}
.doughnut-chart-container {
  height: 360px;
  width: 360px;
  float: left;
}
.preload-screen {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
}
.preload-screen:after {
  content: " ";
  display: block;
  width: 64px;
  height: 64px;
  margin: 8px;
  border-radius: 50%;
  border: 6px solid #3194f7;
  border-color: #3282d1 transparent #3282d1 transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>

</head>
<body onload="preload()" style="background-color: #eee">
<noscript style="z-index: 99999!important; position: absolute; top: 0; width: 98%; padding: 3%;"><div class="alert alert-danger" role="alert">Docker and Services Manager Web Application <b>requer</b> que o JavaScript esteja habilitado para funcionar corretamente - habilite-o para continuar!</div></noscript>
<div class="preload-screen"></div>

<div style="margin-top:30px" class="container">
  <nav style="margin-bottom:10px" class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm row<?php if(!$auth){ echo " hidden"; } ?>">
    <a class="navbar-brand" style="cursor: pointer;" onclick="testAllLinksDocker()">
      <img src="img/docker-svgrepo-com.svg" width="30" height="30" class="d-inline-block align-top" alt="Docker Logo">
      Docker
    </a>
  </nav>
  <div class="row<?php if(!$auth){ echo " hidden"; } ?>">
    <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
		<div class="card-header border-primary text-primary"><i class="bi bi-file-earmark-music"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Container1</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('docker start container1')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('docker stop container1')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
	<div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-house"></i>&nbsp;
			<a style="font-size: 16px;">Container2</a>&nbsp;
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="window.open('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('docker start container2')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('docker stop container2')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
    <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-cloud-arrow-down"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Container3</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('docker start container3')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('docker stop container3')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
    <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-earbuds"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Container4</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('docker start container4')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('docker stop container4')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
	<div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-vinyl-fill"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Container5</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('docker start container5')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('docker stop container5')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
	<div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-reception-4"></i>&nbsp;Container6</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
		  <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('/bin/bash /home/user/scripts/Container6.sh')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Renovar</button>&nbsp;
        </div>
      </div>
    </div>
  </div>
</div>
<div style="margin-top:45px" class="container">
  <nav style="margin-bottom:10px" class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm row<?php if(!$auth){ echo " hidden"; } ?>">
    <a class="navbar-brand" style="cursor: pointer;" onclick="testAllLinksServices()">
      <img src="img/services-svgrepo-com.svg" width="30" height="30" class="d-inline-block align-top" alt="Services Logo">
      Serviços
    </a>
  </nav>
  <div class="row<?php if(!$auth){ echo " hidden"; } ?>">
    <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-speedometer2"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Service1</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl start service1')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service1')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
	<div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-window-dock"></i>&nbsp;Service2</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
		  <button type="button" onclick="executeCommand('systemctl start service2')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service2')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
  <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-file-lock2"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Service3</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl start service3')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service3')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
    <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-folder-symlink"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Service4</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl start service4')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service4')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
    <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-umbrella"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Service5</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl start service5')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service5')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
  <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-cast"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Service6</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl start service6')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service6')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
    <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-bounding-box-circles"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Service7</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl start service7')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service7')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
    <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-nut"></i>&nbsp;Service8</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
		  <button type="button" onclick="executeCommand('systemctl reload service8')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Recarregar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service8')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
	<div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-gear-wide-connected"></i>&nbsp;Service9</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
		  <button type="button" onclick="executeCommand('systemctl start service9')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service9')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
	<div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-share"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Service10</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl start service10')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service10')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
    <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-film"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Service11</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl start service11')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service11')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
    <div style="margin-top:5px; margin-bottom:10px;" class="col-sm-4 pt-1 pt-md-0">
      <div class="card shadow-sm">
        <div class="card-header border-primary text-primary"><i class="bi bi-easel"></i>&nbsp;
			<a style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')">Service12</a>&nbsp;
			<a class="emoji" style="font-size: 16px; cursor: pointer;" onclick="testAndChangeEmoji('https://#/')"></a>
		</div>
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
          <button type="button" id="test-link-button" onclick="testAndOpenLink('https://#/')" class="btn btn-outline-secondary mt-1"><i class="bi bi-door-open"></i>&nbsp;Acessar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl start service12')" class="btn btn-outline-success mt-1"><i class="bi bi-play-circle"></i>&nbsp;Rodar</button>&nbsp;
		  <button type="button" onclick="executeCommand('systemctl stop service12')" class="btn btn-outline-danger mt-1"><i class="bi bi-stop-circle"></i>&nbsp;Parar</button>&nbsp;
        </div>
      </div>
    </div>
  </div>
  <div class="row pt-3<?php if(!$auth){ echo " hidden"; } ?>">
    <div class="col-10 col-sm-8 col-md-4 pt-1 pt-md-0" style="margin-left: auto;margin-right: auto;">
      <div class="card text-center border-danger shadow-sm">
        <div style="margin-left: auto;margin-right: auto;position:relative;text-align: center;" class="card-body">
		  <button type="button" data-toggle="modal" data-target="#confirmShutdownModal" class="btn btn-outline-light mt-1"><i class="bi bi-power"></i>&nbsp;Desligar</button>&nbsp;
		  <button type="button" data-toggle="modal" data-target="#confirmRestartModal" class="btn btn-outline-info mt-1"><i class="bi bi-bootstrap-reboot"></i>&nbsp;Reiniciar</button>&nbsp;<br>
		  <button type="button" onclick="logout()" class="btn btn-outline-warning mt-1"><i class="bi bi-arrow-right-square"></i>&nbsp;Sair</button>&nbsp;
		  <p id="sys11" class="card-text"></p>
        </div>
      </div>
    </div>
  </div>
  <hr id="ldiv" class="my-4<?php if(!$auth){ echo " hidden"; } ?>">
</div>

<div class="modal fade" id="confirmShutdownModal" tabindex="-1" aria-labelledby="confirmShutdownModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmShutdownModalLabel">Confirmação de Desligamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja desligar o sistema?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Cancelar">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="executeShutdownCommand()">Desligar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmRestartModal" tabindex="-1" aria-labelledby="confirmRestartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmRestartModalLabel">Confirmação de Reinício</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja reiniciar o sistema?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Cancelar">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="executeRestartCommand()">Reiniciar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-shield-lock"></i>&nbsp;Autenticação</h5>
      </div>
      <div class="modal-body">
        <div class='alert alert-info' role='alert'>Informe a senha para acessar o painel</div>
        <form onkeydown="return event.key != 'Enter';">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="myPsw">Senha</span>
            </div>
            <input type="password" class="form-control" placeholder="" aria-label="Password" aria-describedby="myPsw" id="lpwd" autofocus>
            <div class="invalid-feedback">Senha inválida!</div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-block btn-primary" onclick="loginToServer()" id="lbtn">Login</button>
      </div>
    </div>
  </div>
</div>

<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/popper-1.16.1.min.js"></script>
<script src="js/bootstrap-4.6.0.min.js"></script>
<script src="js/Chart-2.9.3.min.js"></script>
<script src="js/mdtoast.min.js?v=2.0.2"></script>
<script src="js/radialIndicator-2.0.0.min.js"></script>

<script>
var hostname = <?="'".$string."'";?>;
$('.modal').on('shown.bs.modal', function() {
  $(this).find('[autofocus]').focus();
});
</script>

<script src="js/main.js"></script>

<script>
function testAndChangeEmoji(linkToCheck) {
    var proxyUrl = 'https://#/proxy.php?url=' + encodeURIComponent(linkToCheck);

    fetch(proxyUrl)
        .then(function(response) {
            if (response.ok) {
                changeEmojiTo('🟢', linkToCheck);
            } else {
                changeEmojiTo('🔴', linkToCheck);
            }
        })
        .catch(function(error) {
            changeEmojiTo('🔴', linkToCheck);
            console.log(error);
        });
}

function changeEmojiTo(emoji, link) {
    var emojis = document.querySelectorAll('.emoji[onclick*="' + link + '"]');
    for (var i = 0; i < emojis.length; i++) {
        emojis[i].textContent = emoji;
    }
}

function testAllLinksDocker() {
    var linksToTest = [
        'https://#/',
        'https://#/',
		'https://#/',
		'https://#/',
		'https://#/',
    ];

    for (var i = 0; i < linksToTest.length; i++) {
        testAndChangeEmoji(linksToTest[i]);
    }
}

function testAllLinksServices() {
    var linksToTest = [
        'https://#/',
		'https://#/',
		'https://#/',
		'https://#/',
		'https://#/',
		'https://#/',
		'https://#/',
		'https://#/',
		'https://#/',
    ];

    for (var i = 0; i < linksToTest.length; i++) {
        testAndChangeEmoji(linksToTest[i]);
    }
}
</script>

<script>
function testAndOpenLink(link) {
    var proxyUrl = 'https://#/proxy.php?url=' + encodeURIComponent(link);

    fetch(proxyUrl)
        .then(function(response) {
            if (response.ok) {
                window.open(link, '_blank');
            } else {
                displayNotification('O link está indisponível.');
            }
        })
        .catch(function(error) {
            displayNotification('Ocorreu um erro ao testar o link.');
            console.log(error);
        });
}
</script>

<script>
function executeCommand(command) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            displayNotification(response);
        }
    };
    xhttp.open("POST", "execute_command.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("command=" + encodeURIComponent(command));
}

function displayNotification(message) {
    mdtoast(message, {
        duration: 3000,
        type: mdtoast.INFO,
        interaction: false
    });
}
</script>

<script>
function executeShutdownCommand() {
    $.ajax({
        url: 'execute_command_power.php',
        type: 'POST',
        data: { command: "screen -dm bash -c 'sleep 5 && sudo shutdown -h now'" },
        success: function(response) {
            if (response.success) {
                displayNotification('Desligamento iniciado com sucesso!');
            } else {
                displayNotification('Falha ao iniciar o desligamento.');
            }
			$('#confirmShutdownModal').modal('hide');
        },
        error: function() {
            displayNotification('Falha ao iniciar o desligamento.');
        }
    });
}

function executeRestartCommand() {
    $.ajax({
        url: 'execute_command_power.php',
        type: 'POST',
        data: { command: "screen -dm bash -c 'sleep 5 && sudo shutdown -r now'" },
        success: function(response) {
            if (response.success) {
                displayNotification('Reinício iniciado com sucesso!');
            } else {
                displayNotification('Falha ao iniciar o reinício.');
            }
			$('#confirmRestartModal').modal('hide');
        },
        error: function() {
            displayNotification('Falha ao iniciar o reinício.');
        }
    });
}
</script>

</body>
</html>
