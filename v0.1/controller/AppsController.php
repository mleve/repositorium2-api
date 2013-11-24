<?php
class AppsController{
	
	public static function create(){
		
		
		$user = getSession()->get('user');
		if($user == null){
			header('HTTP/1.1 401 Unauthorized');
			$error = array('error' => 'You must be logged in to create an app');
			return $error; 
		}
		//TODO check that the has not been created before
		
		$app = new App();
		
		$app->name = $_POST['name'];
		$app->description = $_POST['description'];
		$app->developerId = $user['username'];
		$id = DAOFactory::getAppDAO()->create($app);
		
		//in success, define that this user is an expert for this tag
		if($id != null){
		return $id;	
		}
		else{
			header('HTTP/1.1 500 Internal Server Error');
			$error = array('error' => 'could not create an App, please try again later');
			return $error; 	
		}
		
	}
	
	public static function getAll(){
		$result= DAOFactory::getAppDAO()->queryAll();
		return $result;
	}
}

?>