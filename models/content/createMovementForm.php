<?php 
	//Creates a modal form that allows the user to easily start a movement
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('movementFunctions.php');
	require_once('userFunctions.php');
	
	echo '<div class="modal fade fade" id="start_movement">';
	echo '<div class="modal-header">';
	echo '<a class="close" data-dismiss="modal">×</a>';
	echo '<h3>Create A Movement</h3>';
	echo '</div>';
	echo '<div class="modal-body">';
	echo '<p style="text-align:center">';
	
	//Create the form
	echo '<form style="text-align:center" class="well form-search">';
	echo '<div class="control-group" id="control">';
	echo '<input maxlength="128" style="height:35px" type="text" name="movement_title" class="span3" placeholder="Title..."></input>';
	echo '</div>';
	echo '<hr/>';
	echo '<textarea maxlength="512" class="input-xlarge" rows="9" name="movement_info" cols="7" style="resize:none" placeholder="Info..."/>';
	echo '</form>';
	
	echo '</p>';
	echo '</div>';
	echo '<div class="modal-footer">';
	echo '<a href="#" name="create_movement" class="btn btn-success">+ Create</a>';
	echo '</div>';
	echo '</div>';
?>