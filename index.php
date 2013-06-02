<?php
	error_reporting(0);
	
	//Get the login url. Will be stored in $loginUrl
	require_once('path.php');
	require_once('models/facebook/facebookInit.php');
	
	if (!$facebook->getUser()) {
		require_once('views/home/FrontPage.php');
	}
	else {
		//Redirect to user home
		require_once('views/user/layout.php');
	}
?>	