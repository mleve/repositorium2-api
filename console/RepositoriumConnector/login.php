<?php

	include_once 'curlHelper.php';
	include_once 'urlResolver.php';

	$resp = make_post(UrlResolver::getUrl("login"), $_GET);
	
	$response = json_decode($resp);
	if(key_exists("error", $response))
		echo $resp;
	else{
		session_start();
		$_SESSION["user"] = $response;
		echo $resp;
	}
	
?>