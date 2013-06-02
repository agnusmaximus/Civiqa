<?php
	/* Outputs a user's conversations given an id */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('contentFill.php');
	require_once('linkToUser.php');
	require_once('userFunctions.php');
	require_once('cleanText.php');
	
	$id = cleanText($_POST['id']);
	
	//Make sure id does exist
	if (doesExist($id)) {
		if ($id == $facebook->getUser()) {
			$conversations = $pdo->query("(SELECT UserID2 AS Id FROM Conversations WHERE UserID1 = ?) UNION 
										 (SELECT UserID1 AS Id FROM Conversations WHERE UserID2 = ?)",
										 array($id, $id));
			
			$output = '';
			
			//Create the conversation links
			for ($i = 0; $i < count($conversations); $i++) {
				//Output information
				$output .= linkToUser($conversations[$i]->Id,
									  "messages");
			}
			
			echo $output;
		}
	}
?>