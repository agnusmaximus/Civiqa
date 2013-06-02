/* Handles messages */
$(document).ready(function() {
    //Check for click on messages
    $("a[name='messages']").live("click", function(event) {
        event.preventDefault();
        var otherUser = $(this).attr("label");
        //History
        addState("message", otherUser);   
        inactivate();
        //php to handle messages
        $.post("models/content/showMessages.php",
               {otherUserId : otherUser},
               function(data) {
                    var form = 	'<form class="form-inline" style="text-align:center" name="messageTo" label="'+ otherUser +'"><input maxlength="256" style="height:30px;" type="text" class="input" placeholder="Message..."></form>';
                    $("#content").hide().empty().append(data);
                    $("#content").append(form).fadeIn();
               });
    }); 
    
    $("form[name='messageTo']").live('submit', function(event) {
        event.preventDefault();
        var inputText = $(this).children("input").val();
        var label = $(this).attr("label");
        var input = $(this).children("input");
        $.post('models/content/messageTo.php',
               {otherUserId : label, 
                text : inputText},
                function(data) {
                    $.post("models/content/showMessages.php",
                            {otherUserId : label},
                            function(data) {
                            
                                var form = 	'<form class="form-inline" style="text-align:center" name="messageTo" label="'+ label +'"><input maxlength="256" style="height:30px;" type="text" class="input" placeholder="Message..."></form>';

                                $("#content").empty().append(data);
                                $("#content").append(form);
                                $("form[name='messageTo']").children("input").focus();
                            });
                    $('html, body').animate({scrollTop: $("#content").height()}, 800);
                });
    });
});