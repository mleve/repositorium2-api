<?php
class Users{
	
	public static function add(){
		
		$User = new User();
		
		/*
		//check for minimum set of data
		if(!isset($_POST['name']) or !isset($_POST['email']) or !isset($_POST['password']))
			return returnError('488 Incomplete request','Please provide email, name and password');
		
		$existent = DAOFactory::getUsersDAO()->queryByEmail($_POST['email']);
		if($existent!=null)
			return returnError('400 Bad Request','User already existe. Try with another email.');
		*/
		$User->email = $_POST['email'];
		$User->name = $_POST['name'];
		$User->lastname = $_POST['lastname'];
		$User->password = $_POST['password'];
		$User->username = $_POST['username'];
		$id = DAOFactory::getUsersDAO()->create($User);
		
		return $id;
	}
	
	public static function queryAll(){
		$result = DAOFactory::getUsersDAO()->queryAll();
		/*
		print_r($result);
		$userArray = array();
		while(($row =  mysql_fetch_assoc($result))) {
    		$userArray[] = $row;
		}
		*/
		//echo $result;
		return $result;
	}

	public static function login(){
		
		if(!isset($_POST['password'])){
			header('HTTP/1.1 401 Unauthorized');
			$Error = new Error();
			$Error->status = "401 Unauthorized";
			$Error->message = "Please provide an email and password";
			return $Error->toArray();
		}
		
		$password = $_POST['password'];
		$email = $_POST['email'];
		$User = DAOFactory::getUsersDAO()->queryByEmail($email);
		
		/**
		 * if passwords match, then add user to session
		 * otherwise return error message
		 */
		
		$checkPassword = array( 'self', 'checkPassword' );
		
		if(call_user_func( $checkPassword, $User->id, $password)) {
			getSession()->set('user', $User);
			return $User->toArray();
			
		}else{
			header('HTTP/1.1 401 Unauthorized');
			$Error = new Error();
			$Error->status = "401 Unauthorized";
			$Error->message = "Incorrect email or password";
			return $Error->toArray(); 
			
		}
		
	}
	
	public static function load($email){
		$user = DAOFactory::getUsersDAO()->queryByEmail($email);
		return $user;
	}
	
	public static function update($id){
		//trying to bypass PHP missing support for PUT and DELETE
		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
		
		$User = getSession()->get('user');
		
		if($User == null)
			return returnError('401 Unauthorized','User must be logged in');
		
		if($User->id != $id)
			return returnError('401 Unauthorized',"User id doesn't match user in session");
		
		if(isset($_PUT['name']))
			$User->name = $_PUT['name'];

		if(isset($_PUT['lastname']))
			$User->lastname = $_PUT['lastname'];
			
		if(isset($_PUT['new_password']) && isset($_PUT['password'])){
			
			$checkPassword = array( 'self', 'checkPassword' );
			if(call_user_func( $checkPassword, $User->id, $password)){
				$salt = DAOFactory::getUsersDAO()->getUserSalt($User->id);
				$newPassword = sha1($_PUT['new_password'].$salt);
				DAOFactory::getUsersDAO()->updatePassword($User->id,$newPassword);
				
			}else{
				return returnError('401 Unauthorized','Incorrect Password');
			}
		}
		
		//finally we update User data and the user in session
		DAOFactory::getUsersDAO()->update($User);
		getSession()->set('user', $User);
	}
	
	public static function loadRepositories($email){
		return DAOFactory::getRepositoriesDAO()->queryForUser($email);
	}
	
	
	public static function checkPassword($user_id, $password){
		$originalPassword = DAOFactory::getUsersDAO()->getUserPassword($user_id);
		$salt = DAOFactory::getUsersDAO()->getUserSalt($user_id);
		$calculatedPassword = sha1($password.$salt);
		// if passwords match, return true
		if(strcmp($calculatedPassword,$originalPassword) == 0)
			return true;
		//else
		return false;
	}
	
	public static function logout(){
		session_destroy();
	}

}
?>