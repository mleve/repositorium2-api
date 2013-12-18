<?php
class DocumentsController{
	
	public static function create(){
		/*Creates a new document in the DB and uploads all attached files
		 * for this Documents as a Transaction.
		 * 
		 * Attached files go to the uploaded/ folder in the base dir of
		 * repositorium.
		 * 
		 * 
		 * */
		
		
		$user = getSession()->get('user');
		
		if($user == null){
			header('HTTP/1.1 400 wrong request');
			$error = array('error' => 'You must be logged in');
			return $error; 
		}
		
		//TODO check if the request has all the needed data and correctness
		
		//check if the user has enough credit in each criterion to upload the document
		$criteria = json_decode($_POST['criteria']);
		
		$canAfford = true;
		$errors = array();
		foreach ($criteria as $criterion){
			$punctuationParams = array('_POST' => array('user_id' => $user['username'],
														'criterion_id' => $criterion));
			$result = getApi()->invoke("/users/punctuation", EpiRoute::httpPost, $punctuationParams);
			
			$criterionAux = DAOFactory::getCriteriaDAO()->load($criterion);
			
			$uploadCost = $criterionAux->uploadCost;
			
			if($result['credit'] < $uploadCost){
				$canAfford = false;
				$errors[] = $criterionAux->name;
			}
		}
		if(!$canAfford){
			header('HTTP/1.1 400 wrong request');
			$errorMessage = "You don't have enough credit in the following criterions: ";
			foreach ($errors as $criterionName){
				$errorMessage = $errorMessage . " ". $criterionName;
			}
			$error = array('error' => $errorMessage);
			return $error; 
		}
		else{
			//Pay the upload cost for every criterion
			foreach ($criteria as $criterion){
				$punctuationParams = array('_POST' => array('user_id' => $user['username'],
															'updateType' => 'payUpload'));
				getApi()->invoke("/users/punctuation/".$criterion, EpiRoute::httpPost, $punctuationParams);
			}
		}
		
		//Copy Files to final directory and create row in files table
		
		$document = new Document();
		$document->name = $_POST['name'];
		$document->description = $_POST['description'];
		$document->creatorId = $user['username'];
		$documentId = DAOFactory::getDocumentDAO()->create($document);
		if($documentId != null){
			$uploaddir = '../uploaded/'; 
			foreach ($_FILES as $file){
				$aux = DAOFactory::getFilesDAO()->getCount();
				$rowId = $aux['0']['0']+1;
				
				$uploadedFileDestination = $uploaddir . $rowId . basename($file['name']);				
				move_uploaded_file($file['tmp_name'], $uploadedFileDestination);
				
				$fileRow = new File();
				$fileRow->id = $rowId;
				$fileRow->documentId = $documentId;
				$fileRow->url = $uploadedFileDestination;
				DAOFactory::getFilesDAO()->create($fileRow);		
			}
		}
		
		//Asign criteria for this Document
		$postParam = array('_POST' => array('document_id' => $documentId,
										'criteria' => $_POST["criteria"])); 
		getApi()->invoke("/documents/fullfill", EpiRoute::httpPost, $postParam);
		return $documentId;

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