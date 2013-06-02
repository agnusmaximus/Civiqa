<?php
	//This class handles outputting the all-news
	//section, which contains bits of information posted
	//by everyone
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('contentFill.php');
	require_once('createCommentButton.php');
	
	$allNews = $pdo->query("SELECT RegarderID, Title, Text, Date, Type, identifier, Data FROM AllNews ORDER BY Date DESC");
	
	//Loop through all news pieces, and print them out
	for ($i = 0; $i < count($allNews); $i++) {
		echo fillContent($allNews[$i]->Title,
						 $allNews[$i]->Text,
						 $allNews[$i]->RegarderID,
						 $allNews[$i]->Date,
						 $allNews[$i]->Type,
						 $allNews[$i]->Data);
		echo createCommentButtonAndSpace($allNews[$i]->identifier);
		echo '<hr/>';
	}
?>