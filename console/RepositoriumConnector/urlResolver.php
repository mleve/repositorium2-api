<?php
//Clase jugo mientras no se resuelva el tema de URL en buho, servira para hacer los cambios rapidamente
class UrlResolver{
	
	//private static $baseUrl = "http://buho.dcc.uchile.cl/~mleveron/repositorium2-api/api/";
	private static $baseUrl = "http://localhost/repositorium2-api/api/";
	private static $version = "v0.1/";
	public static $login = "index.php?__route__=/users/login";
	private static $signUp = "index.php?__route__=/users";
	private static $videoUpload = "index.php?__route__=/documents";
	
	public static function getUrl($case,$custom = null){
		$url = self::$baseUrl . self::$version;
		switch($case){
			case "login":
				return $url . self::$login;
			case "signUp":
				return $url . self::$signUp;
			case "videoUpload":
				return $url . self::$videoUpload;
			case "custom":
				return $url . "index.php?__route__=" . $custom;
		}
	}
}
	