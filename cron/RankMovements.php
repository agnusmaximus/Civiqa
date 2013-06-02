#!/opt/local/bin/php
<?php
	/* This file will rank all of the movements.
	 *
	 * !!Further description of the algorithm will be needed!!
	 */
	require_once('Includes.php');
	require_once(MODEL);
	
	$test = true;
	
	//Create new query object
	$pdo = new QueryObject();
	
	//Get all movement ids
	$movement = $pdo->query("SELECT MovementID, PowerIndex, NumSupporters FROM Movement");
	
	//Loop through all movements
	for ($i = 0; $i < count($movement); $i++) {
		if ($test) {
			echo 'Movement Id: '.$movement[$i]->MovementID.':\n';
		}
		
		//For each movement, get all of its supporter 
		//gains ordered by date
		$supporterGains = $pdo->query("SELECT SupporterGain FROM MovementStatistics WHERE MovementID = ? ORDER BY Date ASC",
									  array($movement[$i]->MovementID));
		
		//The array of x and y values
		$arrayX = array();
		$arrayY = array();
		
		//Loop through all supporter gains and add to the regression object (exclude last element
		//which will be the deciding factor of whether the movements' power will go up or down
		for ($j = 0; $j < count($supporterGains) - 1; $j++) {
			array_push($arrayX, $j);
			array_push($arrayY, $supporterGains[$j]->SupporterGain);
		}
		
		//Get the slope and intercept
		$slopeAndIntercept = linear_regression($arrayX, $arrayY);
		
		//Predict final gain
		$predictedGain = $slopeAndIntercept["m"] * count($supporterGains) + $slopeAndIntercept["b"];
		$actualGain = $supporterGains[count($supporterGains)-1]->SupporterGain;
		
		if ($predictedGain < 0)
			$predictedGain = 0;
		
		if ($test) {
			echo 'Predicted Gain: '.$predictedGain.'\n';
			echo 'Actual Gain: '.$actualGain.'\n';
		}
		
		//Get the current power of the movement
		$power = $movement[$i]->PowerIndex;
		$numTotalSupporters = $movement[$i]->NumSupporters;
		
		if ($test) {
			echo 'Power: '.$power.'\n';
			echo 'Total Supporters: '.$numTotalSupporters.'\n';
		}
		
		//Compare with actual gain
		if ($predictedGain > $actualGain) {
			//Since the predicted gain was suppose to be higher than the actual one,
			//Power index will decrease (if its not already 0)
			//Decrease the power index by the difference between actual and predicted
			$power -= ($predictedGain - $actualGain) * log($numTotalSupporters, 2) * 3 / 2;
		}
		else if ($predictedGain < $actualGain) {
			//Since the predicted gain was lower than the actual one,
			//Power index will increase
			//It will be increased by # of supporters * (ActualGain - PredictedGain)
			$power += log($numTotalSupporters, 2) * 5 * ($actualGain - $predictedGain);
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
			echo 'New Power: '.$power.'\n';
		}
		
		//Update power of the movement
		$pdo->exec("UPDATE Movement SET PowerIndex = ? WHERE MovementID = ?",
				   array($power, $movement[$i]->MovementID));
	}
?>