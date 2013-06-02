/* Handles the behavior of movement-based events */
$(document).ready(function() {
    //Check for any clicks on objects with 
    //name = "movement"
    $("[name='movement']").live('click', function(event) {
        event.preventDefault();
        var movementId = $(this).attr("label");
        //History
        addState("movement", movementId);   
        inactivate();
        $.post('models/content/outputMovement.php',
               {moveId : movementId},
               function(data) {

                    $("#content").append(data);
                    $("#modal").modal('show');
                                  
                    $("#modal").on('hidden', function() {
                        //Remove self
                        $(this).remove();
                    });
                });
    });
    
    //Handle movement comments
    $("[name='comment_movement']").live("submit", function(event) {
        event.preventDefault();
        var commentArea = $("div[name='comment_area']");
        var commentText = $(this).children(0).val();
        var input = $(this).children(0);
        var movementId = $(this).attr("label");
        
        //Upate comment Area
        $.post('models/content/commentOnMovement.php',
               {comment : commentText,
                movementId : movementId},
                function(data) {
                    $.post('models/content/movementComments.php',
                           {movementId : movementId},
                           function(data) {
                                input.attr("value", '');
                                commentArea.empty().append(data);
                                $('#modal').animate({scrollTop:$("#modal").get(0).scrollHeight}, 800);
                           });
                });
    });
    
    //Handle movement supports
    $("[name='support_movement']").live("click", function(event) {
        event.preventDefault();
        var movementId = $(this).attr("label");
        
        $.post('models/content/supportMovement.php',
               {movementId : movementId},
               function(data) {
                    //Refresh content                    
                    $("#modal").modal("hide");
            });
    });
    $('body').popover({
        selector: '[rel=popover]',
        html: true
    });
    
    //Check for movement form submissions
    $("[name='create_movement']").live('click', function(event) {
        event.preventDefault();
        //Check if the title has input...
        var titleInput = $("[name='movement_title']");
        if ($.trim(titleInput.val()) == "") {
            //Error, can not have blank title
            $("#control").addClass("error");
            $("#control").append('<br/><br/><span class="help-inline">* Title must not be blank</span>');
        }
        else {
            //Proceed to create this movement
            var title = $.trim(titleInput.val());
            var text = $.trim($("[name='movement_info']").val());
            $.post('models/content/startMovement.php',
                   {title : title,
                    text : text},
                    function(data) {
                        //Check for duplicate movement title
                        if (data == 0) {
                            //Error
                             $("#control").addClass("error");
                             $("#control").append('<br/><br/><span class="help-inline">* This title is taken</span>');
                        }
                        else {
                            $("#start_movement").modal('hide');
                            //Refresh
                            $('.brand').click();
                        }
                    });
        }   
    });
    
    $("#start_movement").live('submit', function(event) {
        event.preventDefault();
    });
});