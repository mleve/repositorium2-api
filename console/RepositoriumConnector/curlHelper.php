<?php
function make_post($url,$fields){
// Get cURL resource
	$curl = curl_init();
// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url,
		CURLOPT_POSTFIELDS => $fields,
		CURLOPT_COOKIEFILE => '/tmp/cookies.txt', // set cookie file to given file
		CURLOPT_COOKIEJAR => '/tmp/cookies.txt' // set same file as cookie jar
	));
// Send the request & save response to $resp
	$resp = curl_exec($curl);
// Close request to clear up some resources
	curl_close($curl);
	return $resp;
}

function make_get($url,$fields){
	// Get cURL resource
	$query = "";
	if($fields != null)
		$query = http_build_query($fields);
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url."&".$query, //FIXME encontrar otra manera de pasar los gets
		CURLOPT_COOKIEFILE => '/tmp/cookies.txt', // set cookie file to given file
		CURLOPT_COOKIEJAR => '/tmp/cookies.txt' // set same file as cookie jar
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
	return $resp;
}