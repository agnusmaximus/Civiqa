<?php
	/* Creates an archive-formatted link to the user with id */
	function linkToUser($id, $name) {
		global $pdo;
		
		//Get the user's information
		$userInfo = $pdo->query("SELECT FirstName, LastName, Picture FROM User WHERE UserID = ?",
								array($id));
		
		//Create the archive-like link
		$output = '<div class="row">';
		
		$output .= '<div class="span5 offset1">';
		$output .= '<a href="#" style="background-color:#FFFFFF" class="thumbnail" name="'.$name.'" label="'.$id.'">';
		$output .= $userInfo[0]->FirstName . ' ' . $userInfo[0]->LastName;
		$output .= '<img src="'.$userInfo[0]->Picture.'" style="height:50px;width:50px">';
		$output .= '</a>';
		$output .= '</div>';
		
		$output .= '</div>';
		
		return $output;
	}
?>