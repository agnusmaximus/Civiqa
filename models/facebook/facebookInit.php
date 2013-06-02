<?php
/* This php class gets the login url using the facebook php sdk
 * The login url will be stored in the variable:
 *		$loginUrl
 */

require_once('facebook-php-sdk-dafef11/src/facebook.php');
require_once('FacebookAppIdSecret.php');

$config = array();
$config['appId'] = APP_ID;
$config['secret'] = APP_SECRET;

$facebook = new Facebook($config);

$loginParams = array('scope'=>'email');

$loginUrl = $facebook->getLoginUrl($loginParams);
	
?>