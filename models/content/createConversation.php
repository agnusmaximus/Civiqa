<?php
	/* Creates conversation between user and other user */
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('cleanText.php');
	
	$otherUser = cleanText($_POST['otherUserId']);
	$thisUser = $facebook->getUser();
		
	//Create conversation
	if ($thisUser && doesExist($otherUser)) {
		$doesExist = $pdo->query("SELECT UserID1 FROM Conversations WHERE UserID1 = ? AND UserID2 = ? UNION
								  SELECT UserID1 FROM Conversations WHERE UserID1 = ? AND UserID2 = ?",
								 array($thisUser, $otherUser,
									   $otherUser, $thisUser));
		if (empty($doesExist)) {
			//Enter into the database
			$pdo->exec("INSERT INTO Conversations (UserID1, UserID2) VALUES (?, ?)",
					   array($otherUser, $thisUser));
		}
	}
?>