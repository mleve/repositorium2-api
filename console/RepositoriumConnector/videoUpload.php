<?php
include_once 'curlHelper.php';
include_once 'urlResolver.php';

$toSend;
foreach ($_GET as $key => $value){
	$toSend[$key] = json_encode($value);
}

$resp = make_post(UrlResolver::getUrl("videoUpload"), $toSend);


echo $resp;

?>
