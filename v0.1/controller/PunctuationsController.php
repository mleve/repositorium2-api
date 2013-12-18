<?php
class PunctuationsController{
	
	
	public static function load(){
		$aux = new PunctuationsModel();
		$result = $aux->load($_POST["criterion_id"], $_POST["user_id"]);
		if($result == null){
			//Create a new relation for this user and criterion
			$punctuation = array('user_id' => $_POST['user_id'],
								 'criterion_id' => $_POST['criterion_id']);
			$aux->create($punctuation);
			$result = $aux->load($_POST["criterion_id"], $_POST["user_id"]);
		}
		
		return $result;	
	}
	
	public static function update($criterionId = null){
		if($criterionId != null){
			$aux = new PunctuationsModel();
			$previous = $aux->load($criterionId, $_POST['user_id']);
			$criterionInfo = DAOFactory::getCriteriaDAO()->load($criterionId);
			$punctuation = array('user_id' => $_POST['user_id'],
								 'criterion_id' => $criterionId);
			switch ($_POST["updateType"]){
				case "payUpload":
					$punctuation['credit'] = $previous['credit'] - $criterionInfo->uploadCost;
					$punctuation['score'] = $previous['score'];
					$punctuation['failure_rate'] = $previous['failure_rate'];
					$aux->update($punctuation);
					break;
			}
			
			
		}
	}
	
}

?>