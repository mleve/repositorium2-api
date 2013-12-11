<?php
chdir('..');
include_once('./v0.1/utils.php');
include_once('../epi/Epi.php');
include_once('../v0.1/model/include_dao.php');
include_once('../v0.1/controller/UsersController.php');
include_once('../v0.1/controller/CriteriaController.php');
include_once( '../v0.1/controller/AppsController.php');
include_once('../v0.1/controller/AppCriteriaController.php');
include_once('../v0.1/custom/AppCriteriaModel.php');
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
//TODO check and set session duration

//load paths
//getRoute()->load('routes.ini');
getRoute()->get('/version', 'showVersion');
getRoute()->get('/', 'welcome');

//Api Routes
getApi()->get('/users/(\w+)',array('UsersController','queryAll'), EpiApi::external);
getApi()->get('/users',array('UsersController','queryAll'), EpiApi::external);
getApi()->post('/users', array('UsersController','create'), EpiApi::external);
getApi()->post('/users/login', array('UsersController','login'), EpiApi::external);
getApi()->get('/users/login', array('UsersController', 'checkLogin'), EpiApi::external);
getApi()->post('/criteria', array('CriteriaController','create'), EpiApi::external);
getApi()->get('/criteria', array('CriteriaController','getAll'), EpiApi::external);
getApi()->post('/apps', array('AppsController','create'), EpiApi::external);
getApi()->get('/apps', array('AppsController','getAll'), EpiApi::external);
getApi()->post('/appsCriteria', array('AppCriteriaController','create'), EpiApi::external);
getApi()->post('/documents', array('DocumentsController','create'), EpiApi::external);

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