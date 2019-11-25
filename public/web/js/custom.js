$(document).ready(function(){
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $("#bonus_splash").click(function(){
        $.get( "/m/read_bonus", function( data ) {
            $("#bonus_splash").fadeOut();
          });
    });
});