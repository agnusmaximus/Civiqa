#!/opt/local/bin/php
<?php
	/* This php file will update the MovementStatistics Table.
	 * Particularly, its functions will include:
	 *		- Updating the number of gains of supporters of every movement per hour, and add
	 *		  this to the MovementStatistics Table
	 *
	 * Timing to be executed will be determined by CronTimer.txt
	 */
	
	require_once('Includes.php');
	require_once(MODEL);
	
	//Create query object
	$pdo = new QueryObject();
	
	//Get all movement ids and its individual supporter gains
	$movements = $pdo->query("SELECT MovementID, SupporterGain FROM Movement");
	
	//Set all movement's supporter gains to 0
	$pdo->exec("UPDATE Movement SET SupporterGain = 0");
	
	//Loop through all Movements, inserting the gain, movement id and time (now)
	//into MovementStatistics table
	for ($i = 0; $i < count($movements); $i++) {
		$pdo->exec("INSERT INTO MovementStatistics (MovementID, SupporterGain, Date) VALUES (?, ?, NOW())",
				   array($movements[$i]->MovementID, $movements[$i]->SupporterGain));
	}
	
	//Get rid of movement Gains that are too old
	$pdo->exec("DELETE FROM MovementStatistics WHERE Date < (NOW() - INTERVAL 5 MINUTE)");
?>