<?php
	/* This class handles various aspects of interfacing with the database
	 */
		
	require_once('QueryObject.php');
	
	//Create the pdo object
	$pdo = new QueryObject();
	
	//This function returns true if the given id
	//is found in the database of users
	function userEnteredIntoDatabase($id) {
		global $pdo;
		
		//Make query
		$userExists = $pdo->query("SELECT UserID FROM User WHERE UserID = ".$id,
								  array());
		return !empty($userExists);
	}
	
	//This function returns an array that contains the given
	//user's information
	function userInfo($id) {
		global $pdo;
		
		$data = $pdo->query("SELECT Email, Picture, FirstName, LastName FROM User WHERE UserID = ".$id,
							array());
		
		$simplified = array();
		$simplified['email'] = $data[0]->Email;
		$simplified['name'] = $data[0]->FirstName . ' ' . $data[0]->LastName;
		$simplified['first_name'] = $data[0]->FirstName;
		$simplified['last_name'] = $data[0]->LastName;
		$simplified['picture'] = $data[0]->Picture;
		
		return $simplified;
	}
	
	//Enters the user into database
	function enterUserIntoDatabase($uid, $dataToEnter) {
		global $facebook, $pdo;
				
		$pic_small = 'http://graph.facebook.com/'.$uid.'/picture?type=small';
		$pic_large = 'http://graph.facebook.com/'.$uid.'/picture?type=large';
		
		//Enter into database
		$pdo->exec("INSERT INTO User (UserID, FirstName, LastName, Email, Gender, Picture, LargePicture)
				    VALUES (?, ?, ?, ?, ?, ?, ?)",
				   array($uid, 
						 $dataToEnter['first_name'],
						 $dataToEnter['last_name'],
						 $dataToEnter['email'],
						 $dataToEnter['gender'],
						 $pic_small,
						 $pic_large));
		
		//Connect friendships
		enterFriends($uid);
	}
	
	//Connects associates
	function enterFriends($id) {
		global $facebook, $pdo;
		
		$fql_query = array('method' => 'fql.query',
						   'query' => 'SELECT uid2 FROM friend WHERE uid1 ='.$id);
		
		try {
			$info = $facebook->api($fql_query);
		}
		catch (FacebookApiException $e) {
			//Do nothing for now
		}
		
		//Loop through all friends and enter into database
		for ($i = 0; $i < count($info); $i++) {
			//Check if uid2 is present in current database
			$present = $pdo->query("SELECT UserID FROM User WHERE UserID = ?",
								   array($info[$i]['uid2']));
			if (!empty($present)) {
				//Enter as associates
				$pdo->exec("INSERT INTO Associates (UserID, AssociateID) VALUES (?, ?)",
						   array($id, $info[$i]['uid2']));
			}
		}
	}
?>	