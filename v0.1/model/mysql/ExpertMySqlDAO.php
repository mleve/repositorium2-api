<?php
class ExpertMySqlDao implements ExpertsDAO{

	public function create($expert,$criteria){
		//print_r($expert);
		//print_r($criteria);
		$sql = 'INSERT INTO expert (user_id,criteria_id) VALUES (?,?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($expert['username']);
		$sqlQuery->set($criteria->id);
		$this->executeInsert($sqlQuery);	
		
	}
	
	public function getExpertCriteria($user){}
	
	public function getExpertForCriteria($criteria){}
	
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}

}