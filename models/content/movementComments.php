<?php
	//Shows movement comments
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('commentFill.php');
	require_once('cleanText.php');
	require_once('movementFunctions.php');
	
	if (!isset($movementId)) {
		$movementId = cleanText($_POST['movementId']);
	}
	
	if (!doesMovementExist($movementId))
		return;

	$movementComments = $pdo->query("SELECT UserID, Text, Date FROM MovementComments WHERE MovementID = ?",
									array($movementId));
	if (!empty($movementComments)) {
		echo '<div class="well">';
		for ($i = 0; $i < count($movementComments); $i++) {
			echo fillComment($movementComments[$i]->UserID,
							 $movementComments[$i]->Text,
							 $movementComments[$i]->Date);
		}
		echo '</div>';
	}
?>