<?php
/**
 * Class that operate on table 'document'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2013-11-16 10:53
 */
class DocumentMySqlDAO implements DocumentDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return DocumentMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM document WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM document';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM document ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param document primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM document WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param DocumentMySql document
 	 */
	public function insert($document){
		$sql = 'INSERT INTO document (name, description, creator_id, created) VALUES (?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($document->name);
		$sqlQuery->set($document->description);
		$sqlQuery->set($document->creatorId);
		$sqlQuery->set($document->created);

		$id = $this->executeInsert($sqlQuery);	
		$document->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param DocumentMySql document
 	 */
	public function update($document){
		$sql = 'UPDATE document SET name = ?, description = ?, creator_id = ?, created = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($document->name);
		$sqlQuery->set($document->description);
		$sqlQuery->set($document->creatorId);
		$sqlQuery->set($document->created);

		$sqlQuery->setNumber($document->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM document';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM document WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDescription($value){
		$sql = 'SELECT * FROM document WHERE description = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreatorId($value){
		$sql = 'SELECT * FROM document WHERE creator_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreated($value){
		$sql = 'SELECT * FROM document WHERE created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByName($value){
		$sql = 'DELETE FROM document WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDescription($value){
		$sql = 'DELETE FROM document WHERE description = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreatorId($value){
		$sql = 'DELETE FROM document WHERE creator_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreated($value){
		$sql = 'DELETE FROM document WHERE created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return DocumentMySql 
	 */
	protected function readRow($row){
		$document = new Document();
		
		$document->id = $row['id'];
		$document->name = $row['name'];
		$document->description = $row['description'];
		$document->creatorId = $row['creator_id'];
		$document->created = $row['created'];

		return $document;
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
	 * @return DocumentMySql 
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