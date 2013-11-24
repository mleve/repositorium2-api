<?php

class AppCriteriaModel{
	
	public static function create($app_criteria){
		$sql = 'INSERT INTO app_criteria (app_id, criteria_id) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		
		
		
		$sqlQuery->set($app_criteria['app_id']);
		$sqlQuery->set($app_criteria['criteria_id']);
		
		
		
		
		QueryExecutor::executeInsert($sqlQuery);
	}

	public static function load($appId,$criteriaId){
		$sql = 'SELECT * FROM app_criteria WHERE app_id = ? AND criteria_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($appId);
		$sqlQuery->setNumber($criteriaId);
		return self::getRow($sqlQuery);
	}
	
	protected static function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		
		$result = array();
		$result = $result + array("app_id" => $tab[0]['app_id']);
		$result = $result + array('criteria_id'  => $tab[0]['criteria_id']);
		return $result;
	}
}

?>