<?php

class PunctuationsModel{
	
	public static function create($punctuation){
		$sql = 'INSERT INTO punctuations (user_id, criterion_id, score, credit, failure_rate) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($punctuation['user_id']);
		$sqlQuery->set($punctuation['criterion_id']);
		$sqlQuery->setNumber(0);
		//initial credit for user:
		$sqlQuery->setNumber(0);
		
		$sqlQuery->setNumber(0);
		
		
		QueryExecutor::executeInsert($sqlQuery);
	}

	public static function load($criterionId, $userId){
		$sql = 'SELECT * FROM punctuations WHERE criterion_id = ? AND user_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($criterionId);
		$sqlQuery->set($userId);
		return self::getRow($sqlQuery);
	}
	
	public static function update($punctuation){
		$sql = 'UPDATE punctuations set score = ? , credit = ? , failure_rate = ? WHERE user_id= ? AND criterion_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($punctuation['score']);
		$sqlQuery->set($punctuation['credit']);
		$sqlQuery->set($punctuation['failure_rate']);
		$sqlQuery->set($punctuation['user_id']);
		$sqlQuery->set($punctuation['criterion_id']);
		QueryExecutor::executeUpdate($sqlQuery);
		
	}
	
	protected static function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		
		$result = array();
		$result = $result + array('user_id'  => $tab[0]['user_id']);
		$result = $result + array("criterion_id" => $tab[0]['criterion_id']);
		$result = $result + array('score'  => $tab[0]['score']);
		$result = $result + array('credit'  => $tab[0]['credit']);
		$result = $result + array('failure_rate'  => $tab[0]['failure_rate']);
		return $result;
	}

}

?>