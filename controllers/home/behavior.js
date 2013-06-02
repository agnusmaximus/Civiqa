/* This class handles transitions between home, about and other
 * elements that are related to "home" 
 * These may include About pages, home pages, how-to pages, and 
 * Contact pages
 */
 
 $(document).ready(function() {
     $("#aboutLearn").hide();

     //Direct to about page
     $("#about, #learn").click(function() {
	 event.preventDefault();
	 $("#home").parent().removeClass("active");
	 $("#about").parent().addClass("active");
	 
	 //Fade out front page hero unit
	 $("#front").fadeOut('fast', function() {
	     //Fade in about/learn page
	     $("#aboutLearn").fadeIn();
	 });
     });

     //The home/reset button
     $("#home, #reset").click(function() {
	 event.preventDefault();
	 $("#about").parent().removeClass("active");
	 $("#home").parent().addClass("active");

	 //Fade out about/learn page
	 $("#aboutLearn").fadeOut('fast', function() {
	     //Fade In page hero unit
	     $("#front").fadeIn();
	 });
     });
 });