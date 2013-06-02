<?php
	/* Updates database of News given input text and news Identifier */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('commentFill.php');
	require_once('cleanText.php');
	require_once('userFunctions.php');
	
	$otherUser = cleanText($_POST['otherUserId']);
	$thisUser = $facebook->getUser();
	
	if (doesExist($otherUser)) {
		//Make sure user logged in
		if ($thisUser) {
			echo '<div name="messages_section" label="'.$otherUser.'">';
			echo '<h2>Messages</h2>';
			echo '<hr/>';
			echo '<div class="well" style="background-color:#FFFFFF">';
			
			//get Message Data
			$messages = $pdo->query("SELECT SenderID, Text, Date FROM Messages WHERE SenderID = ? AND ReceiverID = ? UNION 
									SELECT SenderID, Text, Date FROM Messages WHERE ReceiverID = ? AND SenderID = ?
									ORDER BY Date",
									array($otherUser, $thisUser,
										  $otherUser, $thisUser));
			
			for ($i = 0; $i < count($messages); $i++) {
				echo fillcomment($messages[$i]->SenderID,
								 $messages[$i]->Text,
								 $messages[$i]->Date);
			}
			
			echo '</div>';
			echo '</div>';
			
//			//Create form for input
//			echo '<form class="form-inline" style="text-align:center" name="messageTo" label="'.$otherUser.'">';
//			echo '<input maxlength="256" style="height:30px;" type="text" class="input" placeholder="Message...">';
//			echo '</form>';
		}
	}
?>