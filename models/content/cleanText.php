<?php
	/* Cleans text */
	require_once('../../models/htmlpurifier/HTMLPurifier.standalone.php');

	function clean($text) {
		//clean
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Core.Encoding', 'UTF-8');
		$config->set('HTML.Doctype', 'HTML 4.01 Transitional');
		
		//Create html purifier
		$purify = new HTMLPurifier($config);
		$text = $purify->purify($text);
		
		//Clean some more
		$text = strip_tags($text);
		$text = stripslashes($text);
		
		return $text;
	}
	
	function cleanText($text) {
		//clean
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Core.Encoding', 'UTF-8');
		$config->set('HTML.Doctype', 'HTML 4.01 Transitional');
		
		//Create html purifier
		$purify = new HTMLPurifier($config);
		$text = $purify->purify($text);
		
		//Clean some more
		$text = strip_tags($text);
		$text = stripslashes($text);
		
		return $text;
	}
?>