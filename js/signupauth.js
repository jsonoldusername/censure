

$(document).ready(function() {
    if (!authTW ){
        $("#twt").hover(
        function() {
            $(this).css('background-color', '#ffffff');
            $(this).css('color', '#4da7de');
        }, function() {
            $(this).css('background-color', '');
            $(this).css('color', '#ffffff');
    });
    
    $("#twt").click(function() {
        window.location = 'RequestTwitterAuth.php';
    });}
     if (!authFB ){
    $("#fb").hover(
    function() {
         if (!authFB){
        $(this).css('background-color', '#ffffff');
        $(this).css('color', '#3b5998');
         }
    }, function() {
        $(this).css('background-color', '');
        $(this).css('color', '#ffffff');
    });
    $("#fb").click(function() {
        window.location = 'GrantTest/fbconfig.php';
    });}
});

