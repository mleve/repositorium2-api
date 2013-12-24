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
			header('HTTP/1.1 200 wrong request');
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
			header('HTTP/1.1 200 wrong request');
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
	
	public static function download($docId = null){
		
		$user = getSession()->get('user');
		if($user == null){
			header('HTTP/1.1 400 wrong request');
			$error = array('error' => 'You must be logged in');
			return $error; 
		}		
		
		//check Document existence
		$documentInfo = DAOFactory::getDocumentDAO()->load($docId);
		if($documentInfo ==null){
			header('HTTP/1.1 400 wrong request');
			$error = array('error' => 'Document not found');
			return $error; 
			
		}		
		//check if the user has already paid for this document, error otherwise
		$paymentInfo = DAOFactory::getDownloadedDAO()->queryByUserAndDocument($user['username'], $docId);
		//print_r($paymentInfo);
		if($paymentInfo == null){
			header('HTTP/1.1 400 wrong request');
			$error = array('error' => "You have not yet paid for this document");
			return $error; 
		}
		
		$response = array( "name" => $documentInfo->name,
						   "description" => $documentInfo->description,
						   "created" => $documentInfo->created);
		
		$attachedFiles = DAOFactory::getFilesDAO()->queryByDocumentId($docId);
		$i=1;
		foreach($attachedFiles as $file){
			if(substr_compare($file->url, "http://", 0,7) == 0){
				//web resource, return URL
				$response["file".$i] = $file->url;
			}
			else{
				//load file and return
				$fileContent = file_get_contents($file->url);
				
				$response["file".$i] = array("name" => substr("".$file->url, strlen('../uploaded/'.$file->id)),
											 "content" => base64_encode($fileContent));
			}
			$i++;
		}
		
		return $response;
		
	}
	
	public static function pay($docId = null){
		//TODO check all the information comming
		
		//check document existence
		$documentInfo = DAOFactory::getDocumentDAO()->load($docId);
		if($documentInfo ==null){
			header('HTTP/1.1 400 wrong request');
			$error = array('error' => 'Document not found');
			return $error; 
		}	
		//check if the user has already paid for this document, do nothing in that case
		$paymentInfo = DAOFactory::getDownloadedDAO()->queryByUserAndDocument($_POST['username'], $docId);
		//print_r($paymentInfo);
		if($paymentInfo == null){
			$appCriteria = AppCriteriaModel::loadAppCriteria($_POST['app_id']);
			//Check if the user can pay for the document in all app criteria
			$canAfford = true;
			$errors = array();
			foreach ($appCriteria as $row){
				$punctuationParams = array('_POST' => array('user_id' => $_POST['username'],
															'criterion_id' => $row["criterion_id"]));
				$result = getApi()->invoke("/users/punctuation", EpiRoute::httpPost, $punctuationParams);
				
				$criterionAux = DAOFactory::getCriteriaDAO()->load($row["criterion_id"]);
				
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
			//Pay the download cost of all criteria of this app
			foreach ($appCriteria as $row){
				$punctuationParams = array('_POST' => array('user_id' => $_POST['username'],
															'updateType' => 'payDownload'));
				getApi()->invoke("/users/punctuation/".$row["criterion_id"], EpiRoute::httpPost, $punctuationParams);
			}
			
			//Register that the user has paid for the document
			
			$downloaded = new Downloaded();
			$downloaded->userId = $_POST["username"];
			$downloaded->documentId = $docId;
			DAOFactory::getDownloadedDAO()->create($downloaded);
			
			header("HTTP/1.1 200 OK");
			return array("ok" => "Download cost paid");
		}
		header("HTTP/1.1 200 OK");
		return array("ok" => "User has already paid for this document");		
		
	}
	
}

?>