<?php
/**
 * Class that operate on table 'downloaded'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2013-11-16 10:53
 */
class DownloadedMySqlDAO implements DownloadedDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return DownloadedMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM downloaded WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	public function queryByUserAndDocument($userId,$docId){
		$sql = 'SELECT * FROM downloaded WHERE user_id=? AND document_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($userId);
		$sqlQuery->setNumber($docId);
		return $this->getRow($sqlQuery);
	}	
	
	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM downloaded';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM downloaded ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param downloaded primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM downloaded WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param DownloadedMySql downloaded
 	 */
	public function create($downloaded){
		$sql = 'INSERT INTO downloaded (user_id, document_id) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($downloaded->userId);
		$sqlQuery->setNumber($downloaded->documentId);

		$id = $this->executeInsert($sqlQuery);	
		$downloaded->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param DownloadedMySql downloaded
 	 */
	public function update($downloaded){
		$sql = 'UPDATE downloaded SET user_id = ?, document_id = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($downloaded->userId);
		$sqlQuery->setNumber($downloaded->documentId);

		$sqlQuery->setNumber($downloaded->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM downloaded';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM downloaded WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDocumentId($value){
		$sql = 'SELECT * FROM downloaded WHERE document_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM downloaded WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDocumentId($value){
		$sql = 'DELETE FROM downloaded WHERE document_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return DownloadedMySql 
	 */
	protected function readRow($row){
		$downloaded = new Downloaded();
		
		$downloaded->id = $row['id'];
		$downloaded->userId = $row['user_id'];
		$downloaded->documentId = $row['document_id'];

		return $downloaded;
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
	 * @return DownloadedMySql 
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