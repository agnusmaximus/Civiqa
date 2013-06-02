<?php
	//Will handle creating buttons and spaces for comments
	function createCommentButtonAndSpace($newsId) {
		$output = '';
		$output .= '<div class="row">';
		$output .= '<div class="span5 offset2">';
		
		//Create button
		$output .= '<div class="btn-group">';
		$output .= '<a href="#" class="btn" name="personal_comment_button" label="'.$newsId.'">Comments</a>';
		$output .= '</div>';
		
		//Create space to insert comments with ajax
		$output .= '<div name="comment_space" label="'.$newsId.'">';
		
		$output .= '</div>';
		
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
?>