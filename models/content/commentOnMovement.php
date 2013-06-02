<?php
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('cleanText.php');
	require_once('movementFunctions.php');

	/* Comments to a movement */
	$movementId = cleanText($_POST['movementId']);
	$comment = $_POST['comment'];
	
	$userId = $facebook->getUser();
	
	if ($userId && doesMovementExist($movementId)) {
		$comment = clean($comment);
		
		if ($comment != "") {
			//Insert comment
			$pdo->exec("INSERT INTO MovementComments (MovementID, UserID, Text, Date) VALUES
					    (?, ?, ?, NOW())",
					   array($movementId, 
							 $userId,
							 $comment));
		}
	}
?>