<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2013-11-16 10:53
 */
interface UsersDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Users 
	 */
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
 	 * @param user primary key
 	 */
	public function delete($email);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Users user
 	 */
	public function create($user);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Users user
 	 */
	public function update($user);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUsername($value);

	public function queryByName($value);

	public function queryByLastname($value);

	public function queryByPassword($value);

	public function queryByCreated($value);


	public function deleteByUsername($value);

	public function deleteByName($value);

	public function deleteByLastname($value);

	public function deleteByPassword($value);

	public function deleteByCreated($value);


}
?>