<?php
	require_once('formatDate.php');
	require_once('activateLinks.php');
	
	//Provides function that will fill comments easy
	function fillComment($speakerId, $text, $date) {
		global $pdo;
		
		$text = activateLinks($text);
		
		//Convert date
		$date = formatDate($date);
		
		//Get speaker information
		$speakerInfo = $pdo->query("SELECT FirstName, LastName, Picture FROM User WHERE UserID = ?",
								   array($speakerId));
		
		$output = '';
		$output .= '<div class="row">';
		$output .= '<div class="span1">';
		$output .= '<a data-dismiss="modal" href="#" class="thumbnail" name="user" label="'.$speakerId.'">';
		$output .= '<img src="'.$speakerInfo[0]->Picture.'" style="height:50px;width:50px;">';
		$output .= '<div style="text-align:center">'.$speakerInfo[0]->FirstName . ' ' . $speakerInfo[0]->LastName.'</div>';
		$output .= '</a>';
		$output .= '</div>';
		
		$output .= '<div class="span2">';
		$output .= $text;
		$output .= '</div>';
				
		$output .= '</div>';
		
		$output .= '<div class="label" style="text-align:center">'.$date.'</div>';
		$output .= '<hr/>';
		
		return $output;
	}
?>