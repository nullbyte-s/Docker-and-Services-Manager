<?php
session_start();
require "Config.php";
$config = new Config;
$config->load("../local.config");
$correctPassword = $config->get("general.pass");

if (isset($_GET["logout"])) {
	session_destroy();
	sleep(0.5) && clearAuthCookie();
	//unset($_SESSION['svcdbauth']);
	//unset($_COOKIE['login_svcdbauth']);
	exit();
}

if (isset($_POST["check"])) {
	if (!isset($_SESSION["svcdbauth"]) && !isset($_COOKIE["login_svcdbauth"])) {
		echo "invalid";
	} else {
		if ($_SESSION["svcdbauth"] !== $_COOKIE["login_svcdbauth"]) {
			echo "invalid";
		} else {
			echo "valid";
		}
	}
    exit();
}

if (isset($_POST["login"])) {
    if (isset($_POST["pw"])) {
        $pw = md5($_POST["pw"]);
		if ($pw == $correctPassword) {
			echo "correctCredentials";
			$token = bin2hex(random_bytes(32));
			$lifetime = 30 * 24 * 60 * 60;
			//setcookie("login_svcdbauth", $token, time() + $lifetime, "/");
			setcookie("login_svcdbauth", $token, time() + $lifetime);
			$_SESSION["svcdbauth"] = $token;
		}
    }
    exit();
}
?>
