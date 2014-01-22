<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2013-11-16 10:53
 */
interface DocumentDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Document 
	 */
	
	public function getMany($idArray);
	
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param document primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Document document
 	 */
	public function create($document);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Document document
 	 */
	public function update($document);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByDescription($value);

	public function queryByCreatorId($value);

	public function queryByCreated($value);


	public function deleteByName($value);

	public function deleteByDescription($value);

	public function deleteByCreatorId($value);

	public function deleteByCreated($value);


}
?>