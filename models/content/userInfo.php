<?php
	//Outputs user information
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('linkToMovement.php');
	require_once('cleanText.php');
	require_once('userFunctions.php');
	
	$userId = cleanText($_POST['userId']);
	
	if (!doesExist($userId)) {
		return;
	}
	
	//Get user information
	$userInfo = $pdo->query("SELECT FirstName, LastName, LargePicture FROM User WHERE UserID = ?",
							array($userId));
	
	$name = $userInfo[0]->FirstName . ' ' . $userInfo[0]->LastName;
	
	//Print out his name
	echo '<h2>'.$name.'</h2>';
	
	//Create a message button
	echo '<div class="span2 offset6">';
	echo '<div class="btn-group" style="margin-top:-30px">';
	echo '<a href="#" name="message" label="'.$userId.'" class="btn btn-primary">Message</a>';
	echo '</div>';
	echo '</div>';
	
	echo '<hr/>';
	
	//Larger picture
	echo '<div class="row">';
	echo '<div class="span2 offset3">';
	echo '<div class="thumbnail">';
	echo '<img src="'.$userInfo[0]->LargePicture.'">';
	echo '</div>';
	//span
	echo '</div>';
	//row
	echo '</div>';
	echo '<hr/>';
	
	echo '<div class="row">';
	echo '<div class="span7">';
	echo '<p class="alert alert-success">';
	echo 'Facebook Page:   ';
	$facebookUrl = "http://www.facebook.com/profile.php?id=".$userId;
	echo '<a href="'.$facebookUrl.'" target="__blank">'.$facebookUrl.'</a>';
	echo '</p>';
	echo '</div>';
	echo '</div>';
	echo '<hr/>';
	
	echo '<h2 style="text-align:center">Created</h2>';
	echo '<hr/>';
	
	//Get all the movements this user created
	$movementCreated = $pdo->query("SELECT MovementID FROM Movement WHERE CreatorID = ?",
								   array($userId));
	for ($i = 0; $i < count($movementCreated); $i++) {
		echo linkToMovement($movementCreated[$i]->MovementID);
	}
	
	if (empty($movementCreated)) {
		echo '<p class="alert alert-info">';
		echo 'This user has not created any movements';
		echo '</p>';
	}
	
	echo '<hr/>';
	
	//Get all the movements this user supported
	echo '<h2 style="text-align:center">Supported</h2>';
	echo '<hr/>';
	$movementSupported = $pdo->query("SELECT MovementID FROM Supporters WHERE SupporterID = ?",
									 array($userId));
	for ($i = 0; $i < count($movementSupported); $i++) {
		echo linkToMovement($movementSupported[$i]->MovementID);
	}
	
	if (empty($movementSupported)) {
		echo '<p class="alert alert-info">';
		echo 'This user has not supported any movements';
		echo '</p>';
	}
	
	echo '<hr/>';
	
?>