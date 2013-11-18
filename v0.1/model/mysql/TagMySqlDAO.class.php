<?php
/**
 * Class that operate on table 'tag'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2013-11-16 10:53
 */
class TagMySqlDAO implements TagDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return TagMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM tag WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM tag';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM tag ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param tag primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM tag WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param TagMySql tag
 	 */
	public function create($tag){
		$sql = 'INSERT INTO tag (name, description, upload_cost, download_cost, challenge_reward, penalty, created) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($tag->name);
		$sqlQuery->set($tag->description);
		$sqlQuery->setNumber($tag->uploadCost);
		$sqlQuery->setNumber($tag->downloadCost);
		$sqlQuery->setNumber($tag->challengeReward);
		$sqlQuery->setNumber($tag->penalty);
		$sqlQuery->set(date('c'));

		$id = $this->executeInsert($sqlQuery);	
		$tag->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param TagMySql tag
 	 */
	public function update($tag){
		$sql = 'UPDATE tag SET name = ?, description = ?, upload_cost = ?, download_cost = ?, challenge_reward = ?, penalty = ?, created = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($tag->name);
		$sqlQuery->set($tag->description);
		$sqlQuery->setNumber($tag->uploadCost);
		$sqlQuery->setNumber($tag->downloadCost);
		$sqlQuery->setNumber($tag->challengeReward);
		$sqlQuery->setNumber($tag->penalty);
		$sqlQuery->set($tag->created);

		$sqlQuery->setNumber($tag->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM tag';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM tag WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDescription($value){
		$sql = 'SELECT * FROM tag WHERE description = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUploadCost($value){
		$sql = 'SELECT * FROM tag WHERE upload_cost = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDownloadCost($value){
		$sql = 'SELECT * FROM tag WHERE download_cost = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByChallengeReward($value){
		$sql = 'SELECT * FROM tag WHERE challenge_reward = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPenalty($value){
		$sql = 'SELECT * FROM tag WHERE penalty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreated($value){
		$sql = 'SELECT * FROM tag WHERE created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByName($value){
		$sql = 'DELETE FROM tag WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDescription($value){
		$sql = 'DELETE FROM tag WHERE description = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUploadCost($value){
		$sql = 'DELETE FROM tag WHERE upload_cost = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDownloadCost($value){
		$sql = 'DELETE FROM tag WHERE download_cost = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByChallengeReward($value){
		$sql = 'DELETE FROM tag WHERE challenge_reward = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPenalty($value){
		$sql = 'DELETE FROM tag WHERE penalty = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreated($value){
		$sql = 'DELETE FROM tag WHERE created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return TagMySql 
	 */
	protected function readRow($row){
		$tag = new Tag();
		
		$tag->id = $row['id'];
		$tag->name = $row['name'];
		$tag->description = $row['description'];
		$tag->uploadCost = $row['upload_cost'];
		$tag->downloadCost = $row['download_cost'];
		$tag->challengeReward = $row['challenge_reward'];
		$tag->penalty = $row['penalty'];
		$tag->created = $row['created'];

		return $tag;
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
	 * @return TagMySql 
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