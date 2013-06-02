<?php
	/* Outputs top movements */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('linkToMovement.php');
	
	$userId = $facebook->getUser();

	if ($userId) {
		$movements = $pdo->query("SELECT MovementID FROM Movement ORDER BY PowerIndex DESC", array());
		
		for ($i = 0; $i < count($movements); $i++) {
			echo linkToMovement($movements[$i]->MovementID);
		}
	}
?>