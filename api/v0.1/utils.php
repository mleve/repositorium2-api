<?php

/**
* source http://stackoverflow.com/questions/1397036
*/

function array_to_xml($array, &$xml) {
	foreach($array as $key => $value) {
		if(is_array($value)) {
        	if(!is_numeric($key)){
            	$subnode = $xml->addChild("$key");
                array_to_xml($value, $subnode);
            }
            else array_to_xml($value, $xml);
       	}
        else $xml->addChild("$key","$value");
	}
}

function returnError($code, $message){
	$Error = new Error();
	$Error->status = $code;
	$Error->message = $message;
	header('HTTP/1.1 '.$code);
	return $Error->toArray();
}
?>