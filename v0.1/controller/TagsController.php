<?php
class TagsController{
	
	public static function create(){
				
		$tag = new Tag();
		
		$tag->name = $_POST['name'];
		$tag->description = $_POST['description'];
		
		/* In this version, upload_cost, download_cost and challenge_reward
		 * and penalty are predefined, this would change in future releases
		 * */
		
		$tag->uploadCost = 10;
		$tag->downloadCost = 10;
		$tag->challengeReward = 5;
		$tag->penalty = 5;
		
		$id = DAOFactory::getTagDAO()->create($tag);
		
		
		return $id;
	}
	
	public static function getAll(){
		$result = DAOFactory::getTagDAO()->queryAll();
		return $result;
	}
}

?>