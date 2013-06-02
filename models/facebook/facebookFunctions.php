<?php
	/* This class will define basic functions for interfacing with the 
	 * facebook sdk
	 */
		
	//Require facebook init only once
	require_once('facebookInit.php');
	if (defined('PATH')) {
		require_once(PATH.'models/database/database.php');
	}
	else {
		require_once('../database/database.php');
	}
	
	$uid = $facebook->getUser();
	
	//Get all information at once
	function getAllInformation() {
		global $facebook;
		
		//Do facebook grpah api call
		$data = $facebook->api('/me');
		
		return $data;
	}
	
	$userInformation = array();
	
	//Check if the user is entered into the database
	//If so, dont get information from facebook (it's slow)
	if (userEnteredIntodatabase($uid)) {
		//input the information into the array
		$userInformation = userInfo($uid);
	}
	//else, get information from facebook and enter into database
	else {
		$userInformation = getAllInformation();
		
		//Enter user into database
		enterUserIntoDatabase($uid, $userInformation);
	}
	
	//Returns user picture for an id
	//Default id is the id of the user logged on
	function getUserPicture($id = 0) {
		//Check if picture is already stored in user Information
		if (isset($userInformation['picture'])) 
			return $userInformation['picture'];
		
		global $uid;
		global $facebook;
		
		if ($id == 0) 
			$id = $uid;
		
		//Construct the query
		$fql_query = array('method' => 'fql.query',
						   'query' => 'SELECT pic_small FROM user WHERE uid = '.$id);
		
		//Make the query
		try {
			$fql_info = $facebook->api($fql_query);
		}
		//Catch exceptions
		catch (FacebookApiException $e) {
			//Do nothing for now
//			header("Location: ../home/FrontPage.php");
		}
		
		//Everything succeeded return picture
		return $fql_info[0]['pic_small'];
	}
	
	//Returns user email
	function getUserEmail() {
		global $userInformation;
		
		return $userInformation['email'];
	}
	
	//Returns user name (first name + last name)
	function getUserName() {
		global $userInformation;
		
		return $userInformation['name'];
	}
	
	//Returns user first name 
	function getUserFirstName() {
		global $userInformation;
		
		return $userInformation['first_name'];
	}
	
	//Returns user last name
	function getUserLastName() {
		global $userInformation;
		
		return $userInformation['last_name'];
	}
	
	//Get logout url 
	function getLogoutUrl() {
		global $facebook;
		return $facebook->getLogoutUrl();
	}
?>