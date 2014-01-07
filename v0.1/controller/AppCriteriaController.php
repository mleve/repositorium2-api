<?php
class AppCriteriaController{
	
	public static function create(){
		
		
		$user = getSession()->get('user');
		
		$criteria = DAOFactory::getCriteriaDAO()->load($_POST['criteria_id']);
		$app = DAOFactory::getAppDAO()->load($_POST['app_id']);
		
		if($criteria == null or $app == null){
			//header('HTTP/1.1 400 Wrong Request');
			$error = array('error' => 'App or criteria not found, please try again');
			return $error; 
			
		}
		if($user == null){
			//header('HTTP/1.1 400 wrong request');
			$error = array('error' => 'You must be logged in');
			return $error; 
		}
		elseif (strcmp($user['username'],$app->developerId)!=0){
			//header('HTTP/1.1 401 UnAuthorized');
			$error = array('error' => 'you are not the developer of this app');
			return $error; 
		
		}
		if(self::checkExistence($_POST['app_id'], $_POST['criteria_id']) == TRUE){
			//header('HTTP/1.1 402 Wrong Request');
			$error = array('error' => 'This app already uses this criteria');
			return $error; 
			
		}
		
		
		
		$appCriteria = array();
		$appCriteria = $appCriteria + array('app_id' => $_POST['app_id']);
		$appCriteria = $appCriteria + array('criteria_id' => $_POST['criteria_id']);
		
		AppCriteriaModel::create($appCriteria);
		
		/*
		//in success, define that this user is an expert for this tag
		if($id != null){
		return $id;	
		}
		else{
			header('HTTP/1.1 500 Internal Server Error');
			$error = array('error' => 'could not create an App, please try again later');
			return $error; 	
		}
		*/
		
	}
	
	protected static function checkExistence($appId,$criteriaId){
		$aux = new AppCriteriaModel;
		$result = $aux->load($appId,$criteriaId);
		if($result != null)
			return TRUE;
		else 
			return FALSE;

	}
}

?>