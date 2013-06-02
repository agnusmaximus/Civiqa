<?php
	/* Outputs movements that the user has created */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('linkToMovement.php');
	
	$userId = $facebook->getUser();

	if ($userId) {
		$movements = $pdo->query("SELECT MovementID FROM Movement WHERE CreatorID = ? ORDER BY PowerIndex DESC", 
								 array($userId));
		
		for ($i = 0; $i < count($movements); $i++) {
			echo linkToMovement($movements[$i]->MovementID);
		}
	}
?>