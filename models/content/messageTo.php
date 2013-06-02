<?php
	/* Message to user */
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('cleanText.php');
	require_once('userFunctions.php');
	
	$otherUser = cleanText($_POST['otherUserId']);
	$text = $_POST['text'];
	$thisUser = $facebook->getUser();
	
	if ($facebook->getUser() && doesExist($otherUser)) {
		$text = clean($text);
		
		if ($text != "") {
			//Send message
			$pdo->exec("INSERT INTO Messages (SenderID, ReceiverID, Text, Date) VALUES
					   (?, ?, ?, NOW())",
					   array($thisUser, $otherUser, $text));
		}
	}
?>