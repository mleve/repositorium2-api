<?php
	//include all DAO files
	require_once('sql/Connection.class.php');
	require_once('sql/ConnectionFactory.class.php');
	require_once('sql/ConnectionProperty.class.php');
	require_once('sql/QueryExecutor.class.php');
	require_once('sql/Transaction.class.php');
	require_once('sql/SqlQuery.class.php');
	require_once('core/ArrayList.class.php');
	require_once('dao/DAOFactory.class.php');
 	
	require_once('dao/AppDAO.class.php');
	require_once('dto/App.class.php');
	require_once('mysql/AppMySqlDAO.class.php');
	require_once('mysql/ext/AppMySqlExtDAO.class.php');
	require_once('dao/DocumentDAO.class.php');
	require_once('dto/Document.class.php');
	require_once('mysql/DocumentMySqlDAO.class.php');
	require_once('mysql/ext/DocumentMySqlExtDAO.class.php');
	require_once('dao/DownloadedDAO.class.php');
	require_once('dto/Downloaded.class.php');
	require_once('mysql/DownloadedMySqlDAO.class.php');
	require_once('mysql/ext/DownloadedMySqlExtDAO.class.php');
	require_once('dao/FilesDAO.class.php');
	require_once('dto/File.class.php');
	require_once('mysql/FilesMySqlDAO.class.php');
	require_once('mysql/ext/FilesMySqlExtDAO.class.php');
	require_once('dao/TagDAO.class.php');
	require_once('dto/Tag.class.php');
	require_once('mysql/TagMySqlDAO.class.php');
	require_once('mysql/ext/TagMySqlExtDAO.class.php');
	require_once('dao/UsersDAO.class.php');
	require_once('dto/User.class.php');
	require_once('mysql/UsersMySqlDAO.class.php');
	require_once('mysql/ext/UsersMySqlExtDAO.class.php');

?>