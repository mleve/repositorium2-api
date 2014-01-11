<?php

class AppCriteriaModel{
	
	public static function create($app_criteria){
		$sql = 'INSERT INTO app_criteria (app_id, criterion_id) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		
		
		
		$sqlQuery->set($app_criteria['app_id']);
		$sqlQuery->set($app_criteria['criteria_id']);
		
		
		
		
		QueryExecutor::executeInsert($sqlQuery);
	}

	public static function load($appId,$criteriaId){
		$sql = 'SELECT * FROM app_criteria WHERE app_id = ? AND criterion_id = ? ';
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
		$result = $result + array('criteria_id'  => $tab[0]['criterion_id']);
		return $result;
	}
	
	
	
	protected static function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$row = array();
			if(array_key_exists("app_id",$tab[$i]))
				$row["app_id"] = $tab[$i]["app_id"];
			if(array_key_exists("criterion_id",$tab[$i]))
				$row["criterion_id"] = $tab[$i]["criterion_id"];
			$ret[$i] = $row;
		}
		return $ret;
	}
	
	public static function loadAppCriteria($app_id){
		$sql = 'SELECT criterion_id FROM app_criteria where app_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($app_id);
		return self::getList($sqlQuery);
	}
}

?>