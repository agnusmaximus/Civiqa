/* This class handles supplying the content.
 * It will find the active attribute <li> element
 * and accordingly post to php for content back
 */
 
var currentTab = $(".active").attr("name");
currentTab = currentTab.replace('_', ' ');
var userId = $("#userid").html();
 
 $(document).ready(function() {
        
    //The content-filling function
    function fillContent() {
        //Depending on the current tab, post to a differen php file
        //that will generate tab-specific content
        switch(currentTab) {
            case "Personal News":
            //Add state
            addState("personal","");
            $.post('models/content/outputPersonalNews.php',
                    {id : userId},
                    function(data) {
                        $("#content").empty().append('<h2>'+currentTab+'</h2><hr/>');
                        $("#content").hide().append(data).fadeIn();
                    });
            break;
            case "All News":
            addState("all","");
            $.post('models/content/outputAllNews.php',
                   {},
                   function(data) {
                        $("#content").empty().append('<h2>'+currentTab+'</h2><hr/>');
                        $("#content").hide().append(data).fadeIn();
                        $("#loadd").empty();                        
                   });
            break;
            case 'Messages':
            addState("messages","");
            $.post('models/content/outputConversations.php',
                   {id : userId},
                   function(data) {
                        $("#content").empty().append('<h2>'+currentTab+'</h2><hr/>');
                        $("#content").hide().append(data).fadeIn();
                        $("#loadd").empty();                         
                   });
            break;
            case 'Associates':
            addState("associates","");
            $.post('models/content/outputAssociates.php',
                   {id : userId},
                   function(data) {
                        $("#content").empty().append('<h2>'+currentTab+'</h2><hr/>');
                        $("#content").hide().append(data).fadeIn();
                        $("#loadd").empty();                        
                   });
            break;
            case 'Start':
                addState("start","");
                //Append the movement form
                $.post('models/content/createMovementForm.php',
                       {id : userId},
                       function(data) {
                            $("#content").append(data); 
                            $("#loadd").empty();                            
                            $("#start_movement").modal('show');
                            $("#start_movement").on('hidden', function() {
                                $(this).remove();
                            });
                       });               
            break;
            case 'Top':
                addState("top","");
                $.post('models/content/topMovements.php',
                       {},
                        function(data) {
                            $("#content").empty().append('<h2>'+currentTab+'</h2><hr/>');
                            $("#loadd").empty();                            
                            $("#content").hide().append(data).fadeIn();
                       });
                
            break;
            case 'Manage':
                addState("manage","");
                $.post('models/content/manageMovements.php',
                       {},
                        function(data) {
                            $("#content").empty().append('<h2>'+currentTab+'</h2><hr/>');
                            $("#loadd").empty();                            
                            $("#content").hide().append(data).fadeIn();
                       });
            break;
            case 'Supporting':
                 addState("supporting","");
                 $.post('models/content/supportingMovements.php',
                       {},
                        function(data) {
                            $("#content").empty().append('<h2>'+currentTab+'</h2><hr/>');
                            $("#loadd").empty();                            
                            $("#content").hide().append(data).fadeIn();
                       });
            break;
        }
    }
        
    //First input
    $("#content").empty().append('<h2>'+currentTab+'</h2><hr/>');
    
    fillContent();
    
    $("li.sidebar, li.active").click(function(event) {
        currentTab = $(this).attr("name");
        currentTab = currentTab.replace('_', ' ');
        fillContent();
    });
 });