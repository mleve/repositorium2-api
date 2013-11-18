<?php
chdir('..');
include_once('./v0.1/utils.php');
include_once('../epi/Epi.php');
include_once('../v0.1/model/include_dao.php');
include_once('../v0.1/controller/UsersController.php');
include_once('../v0.1/controller/TagsController.php');
/*
include_once('../v0.1/controller/repositories.php');
include_once('../v0.1/controller/documents.php');
include_once('../v0.1/controller/challenges.php');
include_once('../v1.0/controller/users.php');

*/
Epi::setPath('base', '../epi');
Epi::setPath('config', '../api/v0.1');
Epi::init('api');
Epi::init('session');
EpiSession::employ(EpiSession::PHP);

//load paths
//getRoute()->load('routes.ini');
getRoute()->get('/version', 'showVersion');
getRoute()->get('/', 'welcome');

//Api Routes
getApi()->get('/users/(\w*@\w*)*',array('UsersController','queryAll'), EpiApi::external);
getApi()->post('/users/', array('UsersController','create'), EpiApi::external);
getApi()->post('/tags/', array('TagsController','create'), EpiApi::external);
getApi()->get('/tags/', array('TagsController','getAll'), EpiApi::external);

//RUN!
getRoute()->run();

function welcome() {
	header('HTTP/1.1 200 OK');
	echo 'Hola mundo';
	exit(0);
}

function showVersion() {
  header('HTTP/1.1 200 OK');
  echo 'The version of this api is 0.1<br>';
  echo 'You can find documentation at http://cgajardo.github.com/repositorium-api';
  exit(0);
  
}

function Forbidden(){
	header('HTTP/1.1 403 Forbidden');
	echo("You can find documentation at http://cgajardo.github.com/repositorium-api/");
	exit(0);
}


?>