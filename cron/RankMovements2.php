#!/opt/local/bin/php
<?php
	/* This file will rank all of the movements.
	 *
	 * !!Further description of the algorithm will be needed!!
	 */
	require_once('Includes.php');
	require_once(MODEL);
	
	DEFINE('E', 2.718281828459045);
		
	$test = true;
	
	//Create new query object
	$pdo = new QueryObject();
	
	//Get all movement ids
	$movement = $pdo->query("SELECT MovementID, PowerIndex, NumSupporters FROM Movement");
	
	if (empty($movement))
		exit;
	
	//Get data
	$xArray = array();
	$yArray = array();
	
	//Loop through all movements
	for ($i = 0; $i < count($movement); $i++) {
		$partialX = array();
		$partialY = array();
		
		//Get gains
		$supporterGains = $pdo->query("SELECT SupporterGain FROM MovementStatistics WHERE MovementID = ? ORDER BY Date ASC",
									  array($movement[$i]->MovementID));
		
		//Loop through all gains enter into partial data
		for ($j = 0; $j < count($supporterGains); $j++) {
			array_push($partialX, $j);
			array_push($partialY, log($supporterGains[$j]->SupporterGain, E));
		}
		
		//Merge partial data with total data
		$xArray = array_merge($xArray, $partialX);
		$yArray = array_merge($yArray, $partialY);
	}
	
	//After all data is collected, calculate intercept and slope
	$slopeAndIntercept = linear_regression($xArray, $yArray);
	
	//Loop through all movements again
	for ($i = 0; $i < count($movement); $i++) {
		if ($test) {
			echo 'Movement Id: '.$movement[$i]->MovementID.' ';
		}
		
		//For each movement, get all of its supporter 
		//gains ordered by date
		$supporterGains = $pdo->query("SELECT SupporterGain FROM MovementStatistics WHERE MovementID = ? ORDER BY Date DESC",
									  array($movement[$i]->MovementID));

		//Predict final gain
		$predictedGain = $slopeAndIntercept["m"] * count($supporterGains) + $slopeAndIntercept["b"];
		$actualGain = $supporterGains[0]->SupporterGain;
		
		if ($predictedGain < 0)
			$predictedGain = 0;
		
		if ($test) {
			echo 'Predicted Gain: '.$predictedGain.' ';
			echo 'Actual Gain: '.$actualGain.' ';
		}
		
		//Get the current power of the movement
		$power = $movement[$i]->PowerIndex;
		$numTotalSupporters = $movement[$i]->NumSupporters;
		
		if ($test) {
			echo 'Power: '.$power.' ';
			echo 'Total Supporters: '.$numTotalSupporters.' ';
		}
		
		//Compare with actual gain
		if ($predictedGain > $actualGain) {
			//Since the predicted gain was suppose to be higher than the actual one,
			//Power index will decrease (if its not already 0)
			//Decrease the power index by the difference between actual and predicted
			$power -= ($predictedGain - $actualGain);
		}
		else if ($predictedGain < $actualGain) {
			//Since the predicted gain was lower than the actual one,
			//Power index will increase
			//It will be increased by # of supporters * (ActualGain - PredictedGain)
			$power += log($numTotalSupporters, 2) * ($actualGain - $predictedGain);
		}
		else {
			//$predictedGain and $actualGain are equal
			//If this is so, then the movement power should increase by the number of 
			//gains
			if ($actualGain != 0) {
				$power += $actualGain;
			}
			else {
				//0 improvement
				$power -= log($numTotalSupporters, 2) / log($power, 2);
			}
		}
		
		//Round power
		$power = round($power);
		
		if ($power < 0)
			$power = 0;
		
		if ($test) {
			echo 'New Power: '.$power.' ';
		}
		
		//Update power of the movement
		$pdo->exec("UPDATE Movement SET PowerIndex = ? WHERE MovementID = ?",
				   array($power, $movement[$i]->MovementID));
	}
?>