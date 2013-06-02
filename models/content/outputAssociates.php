<?php
	/* Outputs user's associates */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('contentFill.php');
	require_once('linkToUser.php');
	require_once('cleanText.php');
	require_once('userFunctions.php');
	
	$id = cleanText($_POST['id']);
	
	if (doesExist($id)) {
		if ($id == $facebook->getUser()) {
			$associates = $pdo->query("(SELECT UserID AS Id FROM Associates WHERE AssociateID = ?) UNION 
									  (SELECT AssociateID AS Id FROM Associates WHERE UserID = ?)",
									  array($id, $id));
			
			$output = '';
			
			//Create the conversation links
			for ($i = 0; $i < count($associates); $i++) {
				//Output information
				$output .= linkToUser($associates[$i]->Id, "user");
			}
			
			echo $output;
		}
	}
?>