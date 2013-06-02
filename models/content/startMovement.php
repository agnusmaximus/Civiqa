<?php
	/* This php file starts a movement 
	 * Returns 1 if everything wen well
	 * Returns 0 if there is a duplicate movement with same title
	 */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('userFunctions.php');
	require_once('cleanText.php');
	
	$userId = $facebook->getUser();
	$title = $_POST['title'];
	$text = $_POST['text'];
	
	if ($userId) {
		//Clean title and text
		$title = clean($title);
		$text = clean($text);
		
		//Check for duplicate movement title
		$duplicate = $pdo->query("SELECT MovementID FROM Movement WHERE Title = ?",
								 array($title));
		
		if (!empty($duplicate)) {
			//Error, duplicate title
			echo 0;
		}
		
		//Insert into database
		$pdo->exec("INSERT INTO Movement (CreatorID, Title, Text, PowerIndex, Date, NumSupporters, SupporterGain) VALUES
				    (?, ?, ?, ?, NOW(), ?, ?)",
				   array($userId,
						 $title,
						 $text,
						 0, 0, 0));
		
		$newsTitle = '"'.$title.'"';
		$lastId = $pdo->query("SELECT LAST_INSERT_ID() AS id", array());
		$newsIdent = uniqid();
		
		//Send news to friends and self
		sendNewsTo($userId, 
				   $userId,
				   $newsTitle,
				   $text,
				   $lastId[0]->id,
				   "movement",
				   $newsIdent);
		
		newsToFriendWithId($userId,
						   $newsTitle,
						   $text,
						   $lastId[0]->id,
						   "movement",
						   $newsIdent);
		
		newsToAll($userId,
				  $newsTitle,
				  $text,
				  $lastId[0]->id,
				  "movement",
				  $newsIdent);
					
		//Success
		echo 1;
	}
?>