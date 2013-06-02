<?php
	//Outputs personal News
	
	require_once('../facebook/facebookFunctions.php');
	require_once('../database/database.php');
	require_once('contentFill.php');
	require_once('createCommentButton.php');
	require_once('cleanText.php');
	require_once('userFunctions.php');
	
	/* This file outputs personal news given user id */
	$id = cleanText($_POST['id']);
	
	if (doesExist($id)) {
		//Make sure that there is nothing funky going on...
		if ($id == $facebook->getUser()) {
			$personalNews = $pdo->query("SELECT RegarderID, Title, Text, Date, Data, Type, identifier FROM News WHERE UserID = ? ORDER BY Date DESC",
										array($id));
			
			//Loop through all news pieces, and print them out
			for ($i = 0; $i < count($personalNews); $i++) {
				echo fillContent($personalNews[$i]->Title,
								 $personalNews[$i]->Text,
								 $personalNews[$i]->RegarderID,
								 $personalNews[$i]->Date,
								 $personalNews[$i]->Type,
								 $personalNews[$i]->Data);
				
				//Add a button for comments, and space to fill comments
				echo createCommentButtonAndSpace($personalNews[$i]->identifier);
				echo '<hr/>';
			}
		}
	}
?>