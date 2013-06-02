<?php
	//Provides convenient functions to interface with movements
	
	//Get relationship of user with movement
	function userRelationshipWithMovement($userId, $movementId) {
		global $pdo;
		
		//Is User creator
		$creatorId = $pdo->query("SELECT CreatorID FROM Movement WHERE MovementID = ?",
								 array($movementId));
		if ($creatorId[0]->CreatorID == $userId) 
			return 'creator';
		
		//Is User supporter
		$supporters = $pdo->query("SELECT SupporterID FROM Supporters WHERE MovementID = ?",
								  array($movementId));
		
		for ($i = 0; $i < count($supporters); $i++) {
			if ($supporters[$i]->SupporterID == $userId) {
				return 'supporter';
			}	
		}	
	}
	
	//Get movement title
	function movementTitle($movementId) {
		global $pdo;
		
		$name = $pdo->query("SELECT Title FROM Movement WHERE MovementID = ?",
							array($movementId));
		
		return $name[0]->Title;
	}
	
	//Colorcode title
	function colorcode($text) {
		$count = 0;
		
		for ($i = 0; $i < strlen($text); $i++) {
			if ($text[$i] == '"') {
				$first = substr($text, 0, $i);
				$second = substr($text, $i+1);
				
				if ($count % 2 == 0) {
					$replace = '<span style="color:#1B8080">';
					$text = $first.$replace.$second;
					$i += strlen($replace);
				}
				else {
					$replace = '</span>';
					$text = $first.$replace.$second;
					$i += strlen($replace);
				}
				
				$count++;
			}
		}
		return $text;
	}
	
	//Returns if the movement exists
	function doesMovementExist($moveId) {
		global $pdo;
		$movement = $pdo->query("SELECT MovementID FROM Movement WHERE MovementID = ?",
								array($moveId));
		return (!empty($movement));
	}
?>