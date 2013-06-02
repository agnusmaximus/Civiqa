<?php
	//Provides a function that will make it easier to fill
	//content
	
	require_once('formatDate.php');
	require_once('activateLinks.php');
	require_once('movementFunctions.php');
	
	//Fill content given title, text, regarderId, and date
	function fillContent($title, $text, $regarderId, $date, $name, $label) {
		global $pdo;
		
		$text = activateLinks($text);
		
		$output = '';
		
		$regarderData = $pdo->query("SELECT FirstName, LastName, UserID, Picture FROM User WHERE UserID = ?",
									array($regarderId));
		
		$regarderName = $regarderData[0]->FirstName . ' ' . $regarderData[0]->LastName;
		
		//Format date
		$date = formatDate($date);
		
		//Create regarder picture
		$output .= '<div class="row">';

		$output .= '<div class="span2">';
		$output .= '<a class="thumbnail" style="background-color:#FFFFFF" name="user" label="'.$regarderId.'" href="#">';
		$output .= '<p>'.$regarderName.'</p>';
		$output .= '<img style="width:50px;height:50px" src="'.$regarderData[0]->Picture.'">';
		$output .= '</a>';
		
		//Add the date
		$output .= '<p class="label label-info">';
		$output .= $date;
		$output .= '</p>';
		
		//End span
		$output .= '</div>';
		
		//Generate topic
		$output .= '<div class="span5">';
		$output .= '<h3><a name="'.$name.'" label="'.$label.'" href="#">'.colorcode($title).'</a></h3>';
		$output .= '<hr/>';
		if (strlen(trim($text)) != 0) {
			$output .= '<div class="well">';
			$output .= trim($text);
			$output .= '<div style="text-align:center;font-size:30px;"><br/>...</div>';
			$output .= '</div>';
		}
		
		//End span
		$output .= '</div>';
		
		//End row
		$output .= '</div>';
		
		return $output;
	}
?>