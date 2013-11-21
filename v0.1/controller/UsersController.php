<?php
class UsersController{
	
	public static function create(){
		
		$User = new User();
		
		/* TODO check minimum data before create an user
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
		$User->username = $_POST['username'];

		//Secure password
		$salt = base64_encode(mcrypt_create_iv(24, MCRYPT_DEV_URANDOM));
		
		$User->password = hash("sha256",$salt.$_POST['password']);
		$User->salt = $salt;
		
		
		$id = DAOFactory::getUsersDAO()->create($User);
		
		return $id;
	}
	
	
	public static function queryAll($userEmail=null){
		$result=null;
		//echo $userEmail;
		if($userEmail!=null){
			$result = DAOFactory::getUsersDAO()->load($userEmail);
		}
		else{
			$result = DAOFactory::getUsersDAO()->queryAll();	
		}
		
		return $result;
	}

	public static function login(){
		
		if(!isset($_POST['password']) or !isset($_POST['username'])){
			header('HTTP/1.1 401 Unauthorized');
			$error = array('error' => 'please provide your username and password');
			return $error;
		}
		
		$password = $_POST['password'];
		$username = $_POST['username'];
		$user = (array)DAOFactory::getUsersDAO()->queryByUsername($username);
		//print_r($user);
		$user = (array)$user[0];
		//print_r($user);
		/**
		 * if passwords match, then add user to session
		 * otherwise return error message
		 */
		
		if(strcmp(hash("sha256",$user['salt'].$password), $user['password'])==0) {
			unset($user['password']);
			unset($user['salt']);
			getSession()->set('user', $user);
			return $user;
			
		}else{
			header('HTTP/1.1 401 Unauthorized');
			$error = array('error' => 'incorrect username or password');
			return $error;
			
		}
		
	}
	
	public static function checkLogin(){
		return getSession()->get('user');
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