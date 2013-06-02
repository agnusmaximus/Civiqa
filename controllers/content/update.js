/* Updates comments, movements, messages etc, at a fixed pace */
 
 $(document).ready(function() { 
    //Update comments section
    function updateCommentsSection() {
        $("[name='comments_section']").each(function(index) {
            var replaceEl = $(this);
            var newsId = $(this).attr("label");
            //Repost data
             $.post('models/content/comments.php',
               {newsId : newsId},
               function(data) {
                    replaceEl.replaceWith(data);
               });
        });
        setTimeout(updateCommentsSection, 5000);
    }
    
    updateCommentsSection();
    
    function updateMessagesSection() {
        $("[name='messages_section']").each(function(index) {
            var replaceEl = $(this);
            var otherUser = $(this).attr("label");
            //Repost data
             $.post('models/content/showMessages.php',
               {otherUserId : otherUser},
               function(data) {
                    replaceEl.replaceWith(data);
               });
        });
        setTimeout(updateMessagesSection, 5000);
    }
    
    updateMessagesSection();
    
    function updateMovementCommentsSection() {
        $("[name='comment_area']").each(function(index) {
            var replaceEl = $(this);
            var movementId = $("[name='comment_movement']").attr("label");
            //Repost data
             $.post('models/content/movementComments.php',
               {movementId : movementId},
               function(data) {
                    replaceEl.empty().append(data);
               });
        });
        setTimeout(updateMovementCommentsSection, 5000);
    }
    
    updateMovementCommentsSection();
});