/* Handles comment submissions */
$(document).ready(function() {
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
                                commentsArea.empty().append(data);
                            });
                });
    }); 
});