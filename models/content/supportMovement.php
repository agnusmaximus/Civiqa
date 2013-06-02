<?php
	//Support a movement given movement id
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('movementFunctions.php');
	require_once('userFunctions.php');
	require_once('cleanText.php');

	/* Comments to a movement */
	$movementId = cleanText($_POST['movementId']);
	
	$userId = $facebook->getUser();
	
	if ($userId && doesMovementExist($movementId)) {
		//Support the movement
		$pdo->exec("INSERT INTO Supporters (MovementID, SupporterID) VALUES (?, ?)",
				   array($movementId, $userId));
		
		//Update Movement
		$previousSup = $pdo->query("SELECT NumSupporters FROM Movement WHERE MovementID = ?",
									 array($movementId));
		$newSup = $previousSup[0]->NumSupporters + 1;
		$pdo->exec("UPDATE Movement SET NumSupporters = ? WHERE MovementID = ?",
				   array($newSup, $movementId));
		
		$newsTitle = nameOfUser($userId).' supports "'.movementTitle($movementId).'"';
		$newsIdent = uniqid();
		
		//Send news to friends
		newsToFriendWithId($userId,
						   $newsTitle,
						   '',
						   $movementId,
						   "movement",
						   $newsIdent);
		sendNewsTo($userId,
				   $userId,
				   $newsTitle,
				   '',
				   $movementId,
				   "movement",
				   $newsIdent);
		
		newsToAll($userId,
				  $newsTitle,
				  '',
				  $movementId,
				  "movement",
				  $newsIdent);
	}
	else {
		echo 'crap';
	}
?>