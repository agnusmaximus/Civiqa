/* Handles the functionality of the top bar */
$(document).ready(function() {

    //Reset button
    $('.brand').click(function() {
        //Back to personal news
        $('[name="All_News"]').click();
    });
    
    $(".navbar-search").submit(function(event) {
        event.preventDefault();
        var inputVal = $(this).children("input").val();
       //History
        addState("searchFor", inputVal);
        $.post('models/content/search.php',
               {input : inputVal},
               function(data) {
                    $("#content").hide().empty().append(data).fadeIn();
               });
    });
});