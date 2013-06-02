/* This file handles the updates that occur when
 * you click on the left side bar (which include pages/movements/etc.)
 * It handles the highlighting, changing the color of the icon to show
 * that the element is chosen, etc.
 */
 
    
    function inactivate() {
        //Dehighlight icon
        $("li.active > a > i").removeClass("icon-white");
    
        $("li.active").removeClass("active").addClass("sidebar");
    }
    
    function activate(element) {
        $(element).removeClass("sidebar");
        $(element).addClass("active");
        
         $("li.active > a > i").addClass("icon-white");
    }
    
    //Toggles sidebar active state
    $("li.sidebar, li.active").click(function(event) {
        event.preventDefault();
        inactivate();
        activate(this);
    });
