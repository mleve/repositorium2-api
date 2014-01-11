<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2013-11-16 10:53
 */
interface FilesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Files 
	 */
	public function load($id);
	
	public function getCount();

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
 	 * @param file primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Files file
 	 */
	public function create($file);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Files file
 	 */
	public function update($file);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByDocumentId($value);

	public function queryByUrl($value);


	public function deleteByDocumentId($value);

	public function deleteByUrl($value);


}
?>