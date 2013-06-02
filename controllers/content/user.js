/* This class will handle any clicks on links
 * to user profiles
 */
 
 $(document).ready(function() { 
    //Clicks on links
    $('[name="user"]').live('click', function(event) {
        event.preventDefault();
        //History
        addState("user", $(this).attr("label"));
        inactivate();
        if ($.trim($(this).attr("name")) == "user") {
            //User information
            $.post('models/content/userInfo.php',
                   {userId : $(this).attr("label")},
                   function(data) {
                        $("#content").hide().empty().append(data).fadeIn();
                   });
        }
    });
    
    //Check for message button clicks
    $('[name="message"]').live('click', function(event) {
        event.preventDefault();
        var otherUser = $(this).attr("label");
        //History
        addState("message", otherUser);   
        $.post('models/content/createConversation.php',
               {otherUserId : otherUser},
               function(data) {
                    //php to handle messages
                    $.post("models/content/showMessages.php",
                            {otherUserId : otherUser},
                            function(data) {
                                var form = 	'<form class="form-inline" style="text-align:center" name="messageTo" label="'+ otherUser +'"><input maxlength="256" style="height:30px;" type="text" class="input" placeholder="Message..."></form>';
                                $("#content").hide().empty().append(data).append(form).fadeIn();
                    });
               });
    });
});