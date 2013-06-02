/* Handles comments */
$(document).ready(function() {
    //Check for clicks on comment buttons for personal news
    $('[name="personal_comment_button"]').live('click', function(event) {
        event.preventDefault();
        var commentsData = $(this).attr("label");
        
        //Post and insert comments
        var commentsArea = $("div[label="+commentsData+"]");
        
        //Check if comments area already has comments
        if ($.trim(commentsArea.html()) != "") {
            //Empty it
            commentsArea.fadeOut(function() {
                $(this).empty();
            });
            return;
        }
        
        //Insert comments
        $.post('models/content/comments.php',
               {newsId : commentsData},
               function(data) {
                    var form = 	'<form class="form-inline well" style="text-align:center;background-color:#FFFFFF" name="comment_input" label="' + commentsData +'"><input style="height:30px;" type="text" class="input" placeholder="Comment..."></form>';
                    commentsArea.hide().append(data);
                    commentsArea.append(form).fadeIn();
               });
    });
    
     //Check for submissions
    $('form[name="comment_input"]').live('submit', function(event) {
        event.preventDefault();
        var newsId = $(this).attr("label");
        var inputText = $(this).children("input").val();
        
        $.post('models/content/enterComments.php',
                {newsId : newsId, text : inputText},
                function(data) {
                    //Update the comment
                    var commentsArea = $("div[label="+newsId+"]");
                    
                    //Do another post request to comments.php
                    $.post('models/content/comments.php',
                            {newsId : newsId},
                            function(data) {
                            var form = 	'<form class="form-inline well" style="text-align:center;background-color:#FFFFFF" name="comment_input" label="' + newsId +'"><input style="height:30px;" type="text" class="input" placeholder="Comment..."></form>';
                                commentsArea.empty().append(data);
                                commentsArea.append(form);
                            });
                });
    });
});