<?php
	/* Search */
	
	require_once('../../models/facebook/facebookFunctions.php');
	require_once('../../models/database/database.php');
	require_once('linkToMovement.php');
	require_once('linkToUser.php');
	require_once('cleanText.php');
	
	$userId = $facebook->getUser();
	$search = clean($_POST['input']);

	if ($userId) {
		//$movements = $pdo->query("SELECT a.MovementID FROM Supporters a INNER JOIN Movement b ON a.MovementID = b.MovementID
//								  WHERE a.SupporterID = ? ORDER BY b.PowerIndex DESC", 
//								 array($userId));
//		
//		for ($i = 0; $i < count($movements); $i++) {
//			echo linkToMovement($movements[$i]->MovementID);
//		}
		
		echo '<h2> Search: '.$search.'</h2>';
		echo '<hr/>';
		
		$movementResults = $pdo->query("SELECT MovementID FROM Movement WHERE
										dm(Title) = dm(?) OR
										MATCH (Title, Text) AGAINST (?) OR
										Title LIKE ? ORDER BY PowerIndex DESC",
										array($search, $search, '%'.$search.'%'));
		
		if (!empty($movementResults)) {
			//Output movements
			echo '<h2> Movements </h2>';
		
			for ($i = 0; $i < count($movementResults); $i++) {
				echo linkToMovement($movementResults[$i]->MovementID);
			}
			echo '<hr/>';
		}

		$userResults = $pdo->query("SELECT UserID FROM User WHERE
									dm(FirstName) = dm(?) OR dm(LastName) = dm(?) OR 
									dm(CONCAT(CONCAT(FirstName, ' '), LastName)) = dm(?) OR
									dm(CONCAT(CONCAT(LastName, ' '), FirstName)) = dm(?) OR
									FirstName LIKE ? OR
									LastName LIKE ?",
									array($search, $search, $search, 
										  $search, '%'.$search.'%', '%'.$search.'%'));
		
		if (!empty($userResults)) {		
			//Output users
			echo '<h2> Users </h2>';
			
			for ($i = 0; $i < count($userResults); $i++) {
				echo linkToUser($userResults[$i]->UserID, "user");
			}
			
			echo '<hr/>';
		}
		
		if (empty($userResults) && empty($movementResults)) {
			echo '<div class="label label-info">No Results</div>';
		}
	}
?>