<?php
	/* Updates database of News given input text and news Identifier */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('cleanText.php');
	require_once('commentFill.php');
	
	$newsId = $_POST['newsId'];
	$text = $_POST['text'];
	
	//Enter into database
	if ($facebook->getUser()) {
		$id = $facebook->getUser();
		
		//clean
		$text = clean($text);
		
		if ($text != "") {
			$pdo->exec("INSERT INTO NewsComments (NewsIdentifier, UserID, Text, Date) VALUES
					   (?, ?, ?, NOW())",
					   array($newsId, 
							 $id,
							 $text));
		}
	}
?>