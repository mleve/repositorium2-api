<?php
class ChallengesController{
	
	public static function get(){

		$user = getSession()->get('user');
		if($user == null){
			//header('HTTP/1.1 400 wrong request');
			$error = array('error' => 'You must be logged in');
			return $error; 
		}
		
		//obtener el nivel de confianza del usuario
		$punctuationParams = array('_POST' => array('user_id' => $_GET['username'],
													'criterion_id' => $_GET["criterion_id"]));
		$userPunctuation = getApi()->invoke("/users/punctuation", EpiRoute::httpPost, $punctuationParams);
		$failRate = $userPunctuation['failure_rate'];
		//obtener ids de documentos conocidos
		$fullFillParams = array('_GET' => array('criterion_id' => $_GET["criterion_id"],
													'type' => "positive"));
		$positiveDocs = getApi()->invoke("/fullFills", EpiRoute::httpGet, $fullFillParams);
		
		$fullFillParams = array('_GET' => array('criterion_id' => $_GET["criterion_id"],
													'type' => "negative"));
		$negativeDocs = getApi()->invoke("/fullFills", EpiRoute::httpGet, $fullFillParams);		
		
		//array_push($positiveDocs,$negativeDocs);
		foreach($negativeDocs as $doc){
			array_push($positiveDocs, $doc);
		}
		shuffle($positiveDocs);
		$knowDocs = $positiveDocs;
		
		//obtener ids de documentos desconocidos
		$fullFillParams = array('_GET' => array('criterion_id' => $_GET["criterion_id"],
													'type' => "unknown"));
		$unknownDocs = getApi()->invoke("/fullFills", EpiRoute::httpGet, $fullFillParams);			
		
		$KnownForChallenge;
		if($userPunctuation['failure_rate'] == 2)
			$KnownForChallenge = 2;
		else if ($userPunctuation['failure_rate'] == 1)
			$KnownForChallenge = 3;
		else 
			$KnownForChallenge = 4;

		$docsToLoad = array();
		for($i=1; $i<=$KnownForChallenge; $i++){
			array_push($docsToLoad,$knowDocs[$i-1]["document_id"]);
		}
		//echo("unknown disponibles: ".count($unknownDocs));
		$unKnownForChallenge = 4-$KnownForChallenge;
		for($i=0; $i<count($unknownDocs);$i++){
			if($i == $unKnownForChallenge)
				break;
			else 
				array_push($docsToLoad, $unknownDocs[$i]["document_id"]);
		}
		
		//Cargar documentos
		$auxParams = array('_GET' => array('docsId' => $docsToLoad));
		$docs = getApi()->invoke("/documents/challenge", EpiRoute::httpGet, $auxParams);	
		
		//Cargar info del criterio
		$criteria = DAOFactory::getCriteriaDAO()->load($_GET['criterion_id']);
		
		$response["criterion_id"] = $criteria->id;
		$response["criterion_name"] = $criteria->name;
		$response["criterion_description"] = $criteria->description;
		$response["docs"] = $docs;
		return $response;
		
		//return "hola";
	}
	
	public static function pay($docId = null){
		//TODO check all the information comming
		
		//check document existence
		$documentInfo = DAOFactory::getDocumentDAO()->load($docId);
		if($documentInfo ==null){
			//header('HTTP/1.1 400 wrong request');
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
				//header('HTTP/1.1 400 wrong request');
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