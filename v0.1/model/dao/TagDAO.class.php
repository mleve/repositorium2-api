<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2013-11-16 10:53
 */
interface TagDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Tag 
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
 	 * @param tag primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Tag tag
 	 */
	public function create($tag);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Tag tag
 	 */
	public function update($tag);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByDescription($value);

	public function queryByUploadCost($value);

	public function queryByDownloadCost($value);

	public function queryByChallengeReward($value);

	public function queryByPenalty($value);

	public function queryByCreated($value);


	public function deleteByName($value);

	public function deleteByDescription($value);

	public function deleteByUploadCost($value);

	public function deleteByDownloadCost($value);

	public function deleteByChallengeReward($value);

	public function deleteByPenalty($value);

	public function deleteByCreated($value);


}
?>