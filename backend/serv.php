<?php
session_start();
require "Config.php";
$config = new Config;
$config->load("../local.config");
$correctPassword = $config->get("general.pass");

if (isset($_GET["logout"])) {
	//session_destroy();
	// sleep(0.5) && clearAuthCookie();
	unset($_SESSION['svcdbauth']);
	unset($_COOKIE['login_svcdbauth']);
	exit();
}

if (isset($_POST["check"])) {
    if(isset($_COOKIE["login_svcdbauth"])){		
	  if(!isset($_SESSION["svcdbauth"])){
	    $_SESSION["svcdbauth"] = time();
	    echo "valid"; 
	  }else{
	    echo "valid";
	  }
	}else{
	  echo "invalid";
	}
    exit();
}

if (isset($_POST["login"])) {
    if (isset($_POST["pw"])) {
        $pw = md5($_POST["pw"]);
        if ($pw == $correctPassword) {
            echo "correctCredentials";
			setcookie("login_svcdbauth", "valid", time() + (86400 * 30), "/");
            $_SESSION["svcdbauth"] = time();
        } else {
            echo "wrongCredentials";
        }
    }
    exit();
}
?>
