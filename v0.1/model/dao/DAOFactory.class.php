<?php

/**
 * DAOFactory
 * @author: http://phpdao.com
 * @date: ${date}
 */
class DAOFactory{
	
	/**
	 * @return AppDAO
	 */
	public static function getAppDAO(){
		return new AppMySqlExtDAO();
	}

	/**
	 * @return DocumentDAO
	 */
	public static function getDocumentDAO(){
		return new DocumentMySqlExtDAO();
	}

	/**
	 * @return DownloadedDAO
	 */
	public static function getDownloadedDAO(){
		return new DownloadedMySqlExtDAO();
	}

	/**
	 * @return FilesDAO
	 */
	public static function getFilesDAO(){
		return new FilesMySqlExtDAO();
	}

	/**
	 * @return CriteriaDAO
	 */
	public static function getCriteriaDAO(){
		return new CriteriaMySqlDAO();
	}

	/**
	 * @return UsersDAO
	 */
	public static function getUsersDAO(){
		return new UsersMySqlExtDAO();
	}
	
	public static function getExpertDAO(){
		return new ExpertMySqlDAO();
	}


}
?>