<?php 
	//Provides functions that interface with the user
	
	/* Sends a piece of news to user with id $id */
	function sendNewsTo($id, $regarder, $title, $text, $data, $type, $identifier = '') {
		global $pdo, $facebook;
		
		$ident = '';
		if ($identifier != '') {
			$ident = $identifier;
		}
		else {
			$ident = uniqid();
		}
				
		//Execute
		$pdo->exec("INSERT INTO News (UserID, RegarderID, Title, Text, Data, Date,Type, identifier)
					VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)",
					array($id,
						  $regarder,
						  $title,
						  $text,
						  $data,
						  $type,
						  $ident));
	}
	
	/* Sends news to all the friends of user with id $id */
	function newsToFriendWithId($id, $title, $text, $data, $type, $identifier = '') {
		global $pdo, $facebook;
		
		//Get all the user's friends
		$friends = $pdo->query("SELECT AssociateID as associateId FROM Associates WHERE UserID = ? UNION
								SELECT UserID as associateId FROM Associates WHERE AssociateID = ?",
								array($id, $id));
		
		//Loop through all friends and send news to them
		for	($i = 0; $i < count($friends); $i++) {
				sendNewsTo($friends[$i]->associateId,
						$id,
						$title,
						$text,
						$data,
						$type,
						$identifier);
		}
		
	}
	
	/* News to all */
	function newsToAll($regarderId, $title, $text, $data, $type, $identifier = '') {
		global $pdo, $facebook;
		
		if ($facebook->getUser()) {
			$ident = '';
			if ($identifier != '') {
				$ident = $identifier;
			}
			else {
				$ident = uniqid();
			}
			
			$pdo->exec("INSERT INTO AllNews (RegarderID, Title, Text, Data, Date, Type, identifier)
					VALUES (?, ?, ?, ?, NOW(), ?, ?)",
					  array($regarderId,
							$title,
							$text,
							$data,
							$type,
							$ident));
		}
	}
	
	/* Gets the user's name (firstname + lastname) */
	function nameOfUser($id) {
		global $pdo;
		
		$info = $pdo->query("SELECT FirstName, LastName FROM User WHERE UserID = ?",
							array($id));
		
		return $info[0]->FirstName . ' ' . $info[0]->LastName;
	}
	
	//Check if user with id exists
	function doesExist($uid) {
		global $pdo;
		$user = $pdo->query("SELECT UserID FROM User WHERE UserID = ?",
							array($uid));
		return (!empty($user));
	}
?>