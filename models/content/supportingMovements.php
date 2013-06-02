<?php
	/* Outputs movements that the user has supported */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('linkToMovement.php');
	
	$userId = $facebook->getUser();

	if ($userId) {
		$movements = $pdo->query("SELECT a.MovementID FROM Supporters a INNER JOIN Movement b ON a.MovementID = b.MovementID
								  WHERE a.SupporterID = ? ORDER BY b.PowerIndex DESC", 
								 array($userId));
		
		for ($i = 0; $i < count($movements); $i++) {
			echo linkToMovement($movements[$i]->MovementID);
		}
	}
?>