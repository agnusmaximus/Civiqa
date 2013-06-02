<?php
	/* Function activates links and turns image links into pictures and youtube video
	 * links into real-time videos
	 */
	function activateLinks($string, $shouldVid = true) {  
		
		$string = ' '.$string;
		
		$string = preg_replace('/(((f|ht){1}tp:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i',
							   '<br/><a href="\\1" target=_blank>\\1</a>', $string);
		
		$string = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i',
							   '\\1<br/><a href="http://\\2" target=_blank>\\2</a>', $string);
		
		$string = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i',
							   '<br/><a href="mailto:\\1 target=_blank">\\1</a>', $string);
		
		//Turn links into image
		$numFinds = 0;
		
		
		if (($numFinds = preg_match_all('#\s?<a.*/a>#', $string, $matches, PREG_SET_ORDER)) > 0) {
			
			//If there are matches for links, check if each link is an image
			for ($i = 0; $i < count($matches); $i++) {
				$startPos = strpos($matches[$i][0], '"');
				$endPos = strpos($matches[$i][0], '"', $startPos+1);
				$filtered = substr($matches[$i][0], $startPos+1, $endPos-$startPos-1);
				
				$copy = $filtered;
				
				$bits = explode('.', $copy);
				$ext = strtolower(end($bits));
				if ($ext == 'jpg' ||
					$ext == 'png' ||
					$ext == 'gif') {
					
					$newString = "<a rel=\"popover\" data-content=\"<img class='thumbnail' src='".$filtered."' 
					              onerror='.this.parentNode.removeChild(this);' 
					              style='max-height:300px;max-width:230px'/>\" 
					              target=\"_blank\" href=\"".$filtered."\">".$copy."</a>";
					
					$string = str_replace($matches[$i][0], $newString, $string);
				}
			} 
		}
		
		if ($shouldVid) {
			//Turn links into youtube videos
			if ((preg_match_all('#\s?<a.*/a>#', $string, $matches, PREG_SET_ORDER)) > 0) {
				for ($i = 0; $i < count($matches); $i++) {
					$startPos = strpos($matches[$i][0], '"');
					$endPos = strpos($matches[$i][0], '"', $startPos+1);
					$filtered = substr($matches[$i][0], $startPos+1, $endPos-$startPos-1);
					
					$copy = $filtered;
					
					$content;
					
					if (preg_match('/http:\/\/www\.youtube\.com\/watch\?v=[^&]+/', $copy, $content)) {
						
						$res = parse_url($copy);
						$query = $res['query'];
						
						$pos = strpos($query, "=");
						$query = substr($query, $pos+1);
						
						$source = 'http://www.youtube.com/embed/'.$query;
						
						$newString = '<hr/><iframe width="320" height="200" src="'.$source.'" frameborder="0" allowfullscreen onerror="this.parentNode.removeChild(this);"></iframe><hr/>';
						
						$string = str_replace($matches[$i][0], $newString, $string);
					}
				}
			}
		}	
		
		return $string;
	}
?>