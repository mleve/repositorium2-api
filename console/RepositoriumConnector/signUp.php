<?php

include_once 'curlHelper.php';
include_once 'urlResolver.php';

$resp = make_post(UrlResolver::getUrl("signUp"), $_GET);

$response = json_decode($resp);
if(key_exists("error", $response))
	echo $resp;
else{
	$loginData['username'] = $_GET['username'];
	$loginData['password'] = $_GET['password'];
	$resp = make_post(UrlResolver::getUrl("login"), $loginData);
	$response = json_decode($resp);
	session_start();
	$_SESSION["user"] = $response;
	echo $resp;
}

?>
