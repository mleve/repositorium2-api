<?php
class FullFillsController{
	
	public static function create(){
		
		
		$criteria = json_decode($_POST['criteria']);
		
		foreach ($criteria as $criterion){
		/*Check if the relation exists (and don't do anything in that case) and
		 * asing a new criterion for this document*/
			if(self::checkExistence($criterion, $_POST["document_id"]) == false){
			
			$fullfill = array();
			$fullfill = $fullfill + array("document_id" => $_POST['document_id']);
			$fullfill = $fullfill + array("criterion_id" => $criterion);
			$fullfill = $fullfill + array("status" => 0);
			$fullfill = $fullfill + array("positive" => 0);
			$fullfill = $fullfill + array("negative" => 0);
			//print_r($fullfill);
			FullFillsModel::create($fullfill);			
			}
		}
		
	}
	
	public static function get(){
		
		if(strcmp($_GET['type'], 'positive') == 0){
			$aux = FullFillsModel::getByStatus($_GET['criterion_id'], 1);
			return $aux;						
		}
		else if(strcmp($_GET['type'], 'negative') == 0){
			$aux = FullFillsModel::getByStatus($_GET['criterion_id'], -1);
			return $aux;							
		}
		else if(strcmp($_GET['type'], 'unknown') == 0){
			$aux = FullFillsModel::getByStatus($_GET['criterion_id'], 0);
			return $aux;							
		}
		
	}
	
	protected static function checkExistence($criterionId,$documentId){
		$aux = new FullFillsModel();
		$result = $aux->load($criterionId, $documentId);
		if($result != null)
			return TRUE;
		else 
			return FALSE;

	}
}

?>