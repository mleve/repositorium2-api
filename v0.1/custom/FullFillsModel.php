<?php

class FullFillsModel{
	
	public static function create($fullfill){
		$sql = 'INSERT INTO fullfill (criterion_id, document_id, status, positive, negative, created) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($fullfill['criterion_id']);
		$sqlQuery->set($fullfill['document_id']);
		$sqlQuery->setNumber($fullfill['status']);
		$sqlQuery->setNumber($fullfill['positive']);
		$sqlQuery->setNumber($fullfill['negative']);
		$sqlQuery->set(date('c'));
		
		
		
		
		QueryExecutor::executeInsert($sqlQuery);
	}

	public static function load($criterionId, $documentId){
		$sql = 'SELECT * FROM fullfill WHERE criterion_id = ? AND document_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($criterionId);
		$sqlQuery->setNumber($documentId);
		return self::getRow($sqlQuery);
	}
	
	protected static function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		
		$result = array();
		$result = $result + array("criterion_id" => $tab[0]['criterion_id']);
		$result = $result + array('document_id'  => $tab[0]['document_id']);
		return $result;
	}

}

?>