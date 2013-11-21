<?php
class CriteriaController{
	
	public static function create(){
		
		
		$user = getSession()->get('user');
		if($user == null){
			header('HTTP/1.1 401 Unauthorized');
			$error = array('error' => 'You must be logged in to create a criteria');
			return $error; 
		}
		$criteria= new Criteria();
		
		$criteria->name = $_POST['name'];
		$criteria->description = $_POST['description'];
		
		/* In this version, upload_cost, download_cost and challenge_reward
		 * and penalty are predefined, this would change in future releases
		 * */
		
		$criteria->uploadCost = 10;
		$criteria->downloadCost = 10;
		$criteria->challengeReward = 5;
		
		$id = DAOFactory::getCriteriaDAO()->create($criteria);
		
		//in success, define that this user is an expert for this tag
		if($id != null){
		$criteria = DAOFactory::getCriteriaDAO()->load($id);
		DAOFactory::getExpertDAO()->create($user, $criteria);
		return $id;	
		}
		else{
			header('HTTP/1.1 500 Internal Server Error');
			$error = array('error' => 'could not create a Criteria, please try again later');
			return $error; 	
		}
		
	}
	
	public static function getAll($tagId = null){
		$result= null;
		if($tagId != null){
			$result = DAOFactory::getCriteriaDAO()->load($tagId);
		}
		else{
			$result = DAOFactory::getCriteriaDAO()->queryAll();
		}
		return $result;
	}
}

?>