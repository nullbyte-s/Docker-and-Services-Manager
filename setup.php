<?php
header('Access-Control-Allow-Origin: *');
session_start();

require "backend/Config.php";
$config = new Config;
$config->load("local.config");

if(isset($_POST["complete"])){

  if(isset($_POST["pw"])){
    $val=$_POST["pw"];
  }else{
    echo "Erro de configuração - nenhuma senha especificada.";
    exit();
  }
  $edit=array('general' => array ());
  $edit["general"]["pass"]=md5($val);
  $existing=$config->userconf;
  $combined=array_replace_recursive($existing, $edit);
  echo $config->save($combined);
  $_SESSION["setup"]="justfinished";
  exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Definindo a senha</title>

<link rel="stylesheet" href="css/bootstrap-4.6.0.min.css">
<link rel="stylesheet" href="css/bootstrap-icons.css?v=1.4.0">
<link rel="stylesheet" href="css/darkmode.css" id="dmcss" type="text/css">


<style>

.multisteps-form__progress {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
}

.multisteps-form__progress-btn {
  transition-property: all;
  transition-duration: 0.15s;
  transition-timing-function: linear;
  transition-delay: 0s;
  position: relative;
  padding-top: 20px;
  color: rgba(108, 117, 125, 0.7);
  text-indent: -9999px;
  border: none;
  background-color: transparent;
  outline: none !important;
  cursor: pointer;
}

@media (min-width: 500px) {
  .multisteps-form__progress-btn {
    text-indent: 0;
  }
}

.multisteps-form__progress-btn:before {
  position: absolute;
  top: 0;
  left: 50%;
  display: block;
  width: 13px;
  height: 13px;
  content: '';
  -webkit-transform: translateX(-50%);
          transform: translateX(-50%);
  transition: all 0.15s linear 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
  transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
  transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
  border: 2px solid currentColor;
  border-radius: 50%;
  background-color: #fff;
  box-sizing: border-box;
  z-index: 3;
}

.multisteps-form__progress-btn:after {
  position: absolute;
  top: 5px;
  left: calc(-50% - 13px / 2);
  transition-property: all;
  transition-duration: 0.15s;
  transition-timing-function: linear;
  transition-delay: 0s;
  display: block;
  width: 100%;
  height: 2px;
  content: '';
  background-color: currentColor;
  z-index: 1;
}

.multisteps-form__progress-btn:first-child:after {
  display: none;
}

.multisteps-form__progress-btn.js-active {
  color: #007bff;
}

.multisteps-form__progress-btn.js-active:before {
  -webkit-transform: translateX(-50%) scale(1.2);
          transform: translateX(-50%) scale(1.2);
  background-color: currentColor;
}

.multisteps-form__form {
  position: relative;
}

.multisteps-form__panel {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 0;
  opacity: 0;
  visibility: hidden;
}

.multisteps-form__panel.js-active {
  height: auto;
  opacity: 1;
  visibility: visible;
}
/* Define your own CSS3 animations in the CSS. */

.multisteps-form__panel[data-animation="scaleIn"] {
  -webkit-transform: scale(0.9);
          transform: scale(0.9);
}

.multisteps-form__panel[data-animation="scaleIn"].js-active {
  transition-property: all;
  transition-duration: 0.2s;
  transition-timing-function: linear;
  transition-delay: 0s;
  -webkit-transform: scale(1);
          transform: scale(1);
}

.multisteps-form__panel[data-animation=scaleOut]{
  -webkit-transform:scale(1.1);
  transform:scale(1.1);
}
.multisteps-form__panel[data-animation=scaleOut].js-active{
  transition-property:all;
  transition-duration:.2s;
  transition-timing-function:linear;
  transition-delay:0s;
  -webkit-transform:scale(1);
  transform:scale(1);
}
.multisteps-form__panel[data-animation=slideHorz]{
  left:50px;
}
.multisteps-form__panel[data-animation=slideHorz].js-active{
  transition-property:all;
  transition-duration:.25s;
  transition-timing-function:cubic-bezier(.2,1.13,.38,1.43);
  transition-delay:0s;left:0;
}
.multisteps-form__panel[data-animation=slideVert]{
  top:30px;
}
.multisteps-form__panel[data-animation=slideVert].js-active{
  transition-property:all;
  transition-duration:.2s;
  transition-timing-function:linear;
  transition-delay:0s;top:0;
}
.multisteps-form__panel[data-animation=fadeIn].js-active{
  transition-property:all;
  transition-duration:.3s;
  transition-timing-function:linear;
  transition-delay:0s;
}



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
</style>

</head>
<body style="background-color: #f5f5f5;">

<div class="container">

  <div style="margin:auto;margin-top: 30px" class="text-center">
    <img class="mb-4" src="img/orange-svgrepo-com.svg" alt="" width="72" height="72">
    <h1 class="headline h3 mb-2 font-weight-normal">Bem-Vindo!</h1>
    <h3 class="headline h5 mb-3 font-weight-light">Gerenciador de Aplicativos e Serviços</h3>
  </div>

  <div class="multisteps-form">
    <div class="row">
      <div class="col-12 col-lg-8 m-auto">
        <form class="multisteps-form__form" name="myForm">
          <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="scaleOut">
            <h3 class="multisteps-form__title">Alterar senha</h3>
            <div class="multisteps-form__content">
              <div class="form-row mt-4">
                <div class="col-12 col-sm-6">
                  <label for="pwinput1">Senha</label>
                  <input class="multisteps-form__input form-control" type="password" id="pwinput1" />
                </div>
                <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                  <label for="pwinput2">Senha (repita)</label>
                  <input class="multisteps-form__input form-control" type="password" id="pwinput2" onkeyup="checkPw()" />
                  <div class="invalid-feedback">As senhas não são iguais!</div>
                </div>
              </div>
              <div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Observação</h4>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                Tenha em mente que esta autenticação por senha <b>não impede</b> que invasores acessem seu painel em 100%. Convém implementar outras medidas de segurança (por exemplo, Authelia).
                <hr>
                <p class="mb-0"><li>O arquivo "local.config" deve ter permissões "775" para funcionar corretamente. Os demais arquivos devem ter permissões "755".</li>
				<li>Adicione a seguinte linha ao sudoers (via "sudo visudo"): <br><code>www-data ALL=(ALL) NOPASSWD: /usr/bin/docker, /bin/systemctl, /sbin/shutdown</code></li>
				<li><b>Certifique-se de deletar este arquivo de setup após cadastrar a senha.</b></li></p>
              </div>
              <div class="button-row d-flex mt-4">
                <button onclick="completeSetup()" id="submit" class="btn btn-success ml-auto" type="button" title="To Dashboard">Finalizar&nbsp;<i class="bi bi-forward"></i></button>
              </div>
            </div>
          </div>
        </form>
       </div>
    </div>
  </div>
</div>

<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/popper-1.16.1.min.js"></script>
<script src="js/bootstrap-4.6.0.min.js"></script>
<script>

class ntwReq {
  constructor(url, successfct, timeoutfct, type="GET", encode=false, data=null) {
    if (!navigator.onLine) {
      $('#overallstate').html('<font class="text-danger"><i class="bi bi-question-circle"></i>&nbsp;Você está offline...</font>');
    }
    this.xmlhttp = new XMLHttpRequest();
    this.xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        successfct(this);
      }
    };
    this.xmlhttp.open(type, url, true);
    if(encode){
      this.xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    }
    this.xmlhttp.timeout = 4 * 1000;
    this.xmlhttp.ontimeout = timeoutfct;
    if(type=="POST"){
      console.log("POSTING...");
      this.xmlhttp.send(data);
    }else{
      this.xmlhttp.send();
    }

  }
}
function completeSetup() {
  if(checkPw()==false){
    alert("Verifique os campos de senha.");
    $("#authbtn").click();
    return;
  }
  var value=document.getElementById("pwinput1").value;
  $("#submit").html("Processando...").prop("disabled", true);
  var vReq = new ntwReq("setup.php", function (data) {
    console.log(data.responseText);
    if(data.responseText=="1"){
      window.setTimeout(function(){
        $('#submit').html("<i class='bi bi-check-circle'></i>&nbsp;Sucesso!");
        window.setTimeout(function(){
          location.replace("index.php");
        }, 1000);
      }, 1000);
    }else{
      if(data.responseText=="perm_error"){
        confirm(("O arquivo de configuração (local.config) existe, mas não pôde ser modificado. As permissões necessárias não estão definidas corretamente.\nAtribua as permissões '775' para corrigir."))
      }
    }
  }, null, "POST", true, "complete=true&pw="+value);
}

var rad = document.myForm.myRadios;
var prev = null;
for (var i = 0; i < rad.length; i++) {
  rad[i].addEventListener('click', function() {
    adjustTheme(this.id);
  });
}

function checkPw() {
  var pw1=document.getElementById("pwinput1").value;
  var pw2=document.getElementById("pwinput2").value;
  if(pw1==""){
    return false;
  }
  if(pw1!=pw2){
    document.getElementById("pwinput2").classList.add("is-invalid");
    document.getElementById("pwinput2").classList.remove("is-valid");
    return false;
  }else{
    document.getElementById("pwinput2").classList.add("is-valid");
    document.getElementById("pwinput2").classList.remove("is-invalid");
    return true;
  }
}
</script>
</body>
</html>