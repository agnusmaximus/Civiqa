<?php
	require_once('movementFunctions.php');
	
	/* This function links to movements */
	function linkToMovement($movementId) {
		//Will create an archive kind of link
		global $pdo, $facebook;
		
		//USer
		$uid = $facebook->getUser();
		
		//Get movement information
		$movementInfo = $pdo->query("SELECT Title, Text, PowerIndex, NumSupporters FROM Movement WHERE MovementID = ?",
									array($movementId));
		
		//Create the archive-like link
		$output = '<div class="row">';
		
		$output .= '<div class="span7">';
		$output .= '<a class="thumbnail" style="padding:20px;background-color:#FFFFFF;text-decoration:none" href="#" style="" name="movement" label="'.$movementId.'">';
		$output .= '<h3>'.$movementInfo[0]->Title.'</h3><br/>';
		$output .= '<div>'.$movementInfo[0]->Text.'</div><br/>';
		$output .= '<div style="text-align:left">';
		$output .= '<span class="label label-important">Power : '.$movementInfo[0]->PowerIndex.'</span>&nbsp;';
		$output .= '<span class="label labbel-info">#Supporters: '.$movementInfo[0]->NumSupporters.'</span>&nbsp;';
		$output .= '</div>';
		
		$output .= '<div style="text-align:right">';
		//Depending on whether the user is supporter or creator, output a label
		$relation = userRelationshipWithMovement($uid, $movementId);
		if ($relation == 'creator') {
			$output .= '<span class="label label-warning">Creator</span>';
		}
		else if ($relation == 'supporter') {
			$output .= '<span class="label label-info">Supported</span>';
		}
		$output .= '</div>';
		
		$output .= '</a>';
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
?>