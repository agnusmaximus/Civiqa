<?php
	/* Outputs movement information */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('movementFunctions.php');
	require_once('formatDate.php');
	require_once('commentFill.php');
	require_once('activateLinks.php');
	require_once('cleanText.php');
	
	$movementId = cleanText($_POST['moveId']);
	$userId = $facebook->getUser();
	
	if ($userId && doesMovementExist($movementId)) {
		//Output movement information
		//First get movement information
		$movementInfo = $pdo->query("SELECT CreatorID, Title, Text, PowerIndex, Date, NumSupporters FROM
									 Movement WHERE MovementID = ?",
									 array($movementId));
		
		//Get creator information 
		$creatorInfo = $pdo->query("SELECT FirstName, LastName, Picture FROM User WHERE
								    UserID = ?",
								   array($movementInfo[0]->CreatorID));
		
		//Output movement information in a modal
		echo '<div class="modal fade" id="modal">';
		
		//Header
		echo '<div class="modal-header">';
		echo '<a class="close" data-dismiss="modal">x</a>';
		echo '<h2>';
		echo $movementInfo[0]->Title;
		echo '</h2>';
		//Output power index
		echo '<span class="label label-important">Power: '.$movementInfo[0]->PowerIndex.'</span>&nbsp;';
		echo '<span class="label">'.$movementInfo[0]->NumSupporters.' supporter(s)</span>';
		
		//check if user already supported
		$relationship = userRelationshipWithMovement($userId, $movementId);
		if ($relationship != 'creator' &&
			$relationship != 'supporter') {
			echo '<p name="support_movement" label="'.$movementId.'" style="float:right;margin-top:-10px">';
			echo '<a data-dismiss="modal" href="#" class="btn btn-success">Support</a></p>';
		}
		else if ($relationship == 'creator') {
			echo '<p style="float:right"><span class="label label-warning">Creator</span></p>';
		}
		else if ($relationship == 'supporter') {
			echo '<p style="float:right"><span class="label label-info">Supported</span></p>';
		}
		
		echo '</div>';
		
		//Body
		echo '<div class="modal-body">';
		echo '<div class="row">';
		//Output creator information
		echo '<div class="span1">';
		echo '<a class="thumbnail" data-dismiss="modal" href="#" name="user" label="'.$movementInfo[0]->CreatorID.'">';
		echo '<p style="text-align:center">'.$creatorInfo[0]->FirstName.' '.$creatorInfo[0]->LastName.'</p>';
		echo '<img style="height:50px;width:50px" src="'.$creatorInfo[0]->Picture.'">';
		echo '</a>';
		echo '</div>';
		//Output text 
		echo '<div class="span4">';
		echo activateLinks($movementInfo[0]->Text);
		echo '</div>';
		echo '</div>';
		echo '<hr/>';
		
		echo '<div name="comment_area">';
		
		include('movementComments.php');
		
		echo '</div>';
		
		//Creat form to allow users to comment on movement
		//Create form for input
		echo '<form class="form-inline" style="text-align:center" name="comment_movement" label="'.$movementId.'">';
		echo '<input maxlength="128" style="height:30px;" type="text" class="input" placeholder="Comment...">';
		echo '</form>';
		
		//End body
		echo '</div>';
		
		//Footer
		echo '<div class="modal-footer">';
		//Output date created
		echo '<div style="text-align:left"><i>Created '.formatDate($movementInfo[0]->Date).'</i></div>';
		echo '</div>';
		
		//End modal
		echo '</div>';
	}
?>