<?php
	/* This php file outputs comments given a news identifier */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('commentFill.php');
	require_once('cleanText.php');
	
	$newsId = cleanText($_POST['newsId']);
	
	$personalComments = $pdo->query("SELECT UserID, Text, Date, CommentsIdentifier FROM NewsComments WHERE
									NewsIdentifier = ? ORDER BY Date ASC",
									array($newsId));
	
	//Loop through all comments and print them out
	if (!empty($personalComments)) {
		echo '<div label="'.$newsId.'" name="comments_section" class="well" style="background-color:#FFFFFF">';

		for ($i = 0; $i < count($personalComments); $i++) {
			echo fillComment($personalComments[$i]->UserID,
							 $personalComments[$i]->Text,
							 $personalComments[$i]->Date);
		}
		
		echo '</div>';
	}
	else {
		echo '<div label="'.$newsId.'" name="comments_section">';
		echo '<br/><div class="alert alert-error">There are no comments</div>';
		echo '</div>';
	}
	
	//Write a comment
//	echo '<form class="form-inline" style="text-align:center" name="comment_input" label="'.$newsId.'">';
//	echo '<input style="height:30px;" type="text" class="input" placeholder="Comment...">';
//	echo '</form>';
	
	'<form class="form-inline" style="text-align:center" name="comment_input" label="'.$newsId.'"><input style="height:30px;" type="text" class="input" placeholder="Comment..."></form>';
?>