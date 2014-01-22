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
	
	public static function getByStatus($criterionId,$type){
		$sql = 'SELECT * FROM fullfill WHERE criterion_id = ? AND status = ? ORDER BY RAND() LIMIT 10';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($criterionId);
		$sqlQuery->setNumber($type);
		return self::getList($sqlQuery);
		
	}
	
	protected static function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$row = array();
			if(array_key_exists("criterion_id",$tab[$i]))
				$row["criterion_id"] = $tab[$i]["criterion_id"];
			if(array_key_exists("document_id",$tab[$i]))
				$row["document_id"] = $tab[$i]["document_id"];
			if(array_key_exists("status",$tab[$i]))
				$row["status"] = $tab[$i]["status"];
			if(array_key_exists("positive",$tab[$i]))
				$row["positive"] = $tab[$i]["positive"];
			if(array_key_exists("negative",$tab[$i]))
				$row["negative"] = $tab[$i]["negative"];
			if(array_key_exists("created",$tab[$i]))
				$row["created"] = $tab[$i]["created"];
			if(array_key_exists("validated_date",$tab[$i]))
				$row["validated_date"] = $tab[$i]["validated_date"];
			
			
			$ret[$i] = $row;
		}
		return $ret;
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