<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2013-11-16 10:53
 */
interface DownloadedDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Downloaded 
	 */
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	public function queryByUserAndDocument($userId,$docId);
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param downloaded primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Downloaded downloaded
 	 */
	public function create($downloaded);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Downloaded downloaded
 	 */
	public function update($downloaded);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByDocumentId($value);


	public function deleteByUserId($value);

	public function deleteByDocumentId($value);


}
?>