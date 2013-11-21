<?php
/**
 * Class that operate on table 'Criteria'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2013-11-16 10:53
 */
class CriteriaMySqlDAO implements CriteriaDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return criteriaMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM criteria WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM criteria';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM criteria ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param criteria primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM criteria WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param criteriaMySql criteria
 	 */
	public function create($criteria){
		$sql = 'INSERT INTO criteria (name, description, upload_cost, download_cost, challenge_reward, created) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($criteria->name);
		$sqlQuery->set($criteria->description);
		$sqlQuery->setNumber($criteria->uploadCost);
		$sqlQuery->setNumber($criteria->downloadCost);
		$sqlQuery->setNumber($criteria->challengeReward);
		$sqlQuery->set(date('c'));

		$id = $this->executeInsert($sqlQuery);	
		$criteria->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param criteriaMySql criteria
 	 */
	public function update($criteria){
		$sql = 'UPDATE criteria SET name = ?, description = ?, upload_cost = ?, download_cost = ?, challenge_reward = ?, created = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($criteria->name);
		$sqlQuery->set($criteria->description);
		$sqlQuery->setNumber($criteria->uploadCost);
		$sqlQuery->setNumber($criteria->downloadCost);
		$sqlQuery->setNumber($criteria->challengeReward);
		$sqlQuery->setNumber($criteria->penalty);
		$sqlQuery->set($criteria->created);

		$sqlQuery->setNumber($criteria->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM criteria';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM criteria WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDescription($value){
		$sql = 'SELECT * FROM criteria WHERE description = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUploadCost($value){
		$sql = 'SELECT * FROM criteria WHERE upload_cost = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDownloadCost($value){
		$sql = 'SELECT * FROM criteria WHERE download_cost = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByChallengeReward($value){
		$sql = 'SELECT * FROM criteria WHERE challenge_reward = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPenalty($value){
		$sql = 'SELECT * FROM criteria WHERE penalty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreated($value){
		$sql = 'SELECT * FROM criteria WHERE created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByName($value){
		$sql = 'DELETE FROM criteria WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDescription($value){
		$sql = 'DELETE FROM criteria WHERE description = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUploadCost($value){
		$sql = 'DELETE FROM criteria WHERE upload_cost = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDownloadCost($value){
		$sql = 'DELETE FROM criteria WHERE download_cost = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByChallengeReward($value){
		$sql = 'DELETE FROM criteria WHERE challenge_reward = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPenalty($value){
		$sql = 'DELETE FROM criteria WHERE penalty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreated($value){
		$sql = 'DELETE FROM criteria WHERE created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return criteriaMySql 
	 */
	protected function readRow($row){
		$criteria= new Criteria();
		
		$criteria->id = $row['id'];
		$criteria->name = $row['name'];
		$criteria->description = $row['description'];
		$criteria->uploadCost = $row['upload_cost'];
		$criteria->downloadCost = $row['download_cost'];
		$criteria->challengeReward = $row['challenge_reward'];
		$criteria->created = $row['created'];

		return $criteria;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return criteriaMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>