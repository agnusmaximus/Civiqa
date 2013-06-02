/* This file handles the history of the site */

var globState, globSpec;

$(document).ready(function() {

    $(window).bind("hashchange", function(e) {
        //Get data
        var data = $.deparam.fragment();
        
        var state = data.state;
        var spec = data.spec;
        
        $(".modal").modal("hide");
        
        var change = '';
        
        if (spec == '') {
            //Depending on state and spec, change accordingly
            switch (state) {
                case "personal":
                    change = $("[name='Personal_News']");
                
                break;
                case "all":
                    change = $("[name='All_News']");
                
                break;
                case "messages":
                    change = $("[name='Messages']");
                
                break;
                case "associates":
                    change = $("[name='Associates']");
                
                break;
                case "start":
                    change = $("[name='Start']");
                
                break;
                case "top":
                    change = $("[name='Top']");
                break;
                case "manage":
                    change = $("[name='Manage']");
                break;
                case "supporting":
                    change = $("[name='Supporting']");  
                break;
                default:
                    change = $("[name='Personal_News']");
                break;
            }
        
            if (!change.hasClass("active"))
                    change.click();
        }
        else {
            if (globState != state ||
               globSpec != spec) {
                switch(state) {
                    case "user":
                        //User information
                        $.post('models/content/userInfo.php',
                        {userId : spec},
                        function(data) {
                            $("#content").hide().empty().append(data).fadeIn();
                        });
                    break;
                    case "message":
                        $.post("models/content/showMessages.php",
                                {otherUserId : spec},
                                function(data) {
                                $("#content").hide().empty().append(data).fadeIn();
                            });
                    break;
                    case "movement":
                        $.post('models/content/outputMovement.php',
                            {moveId : spec},
                            function(data) {
                                $("#content").append(data);
                                $("#modal").modal('show');
                                            
                                $("#modal").on('hidden', function() {
                                    //Remove self
                                    $(this).remove();
                                });
                        });
                    break;
                    case "searchFor":
                        $.post('models/content/search.php',
                                {input : spec},
                                function(data) {
                                    $("#content").hide().empty().append(data).fadeIn();
                        });
                    break;
                }
                inactivate();
            }
        }
    });
});
//Pushes state
    function addState(state, spec) {
        $.bbq.pushState({state : state, spec : spec},2);
        globState = state;
        globSpec = spec;
    }