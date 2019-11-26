$(document).ready(function(){
    $(".input-result").focus();
    $(".keypad-key").click(function(){
        var res = $(".input-result").val();
        if(res.length > 3) return false;
        $(".input-result").val(res + $(this).text());
        $(".input-result").focus();
    });
    $(".keypad-clear").click(function(){
        $(".input-result").val('');
        $(".input-result").focus();
    });
    $(".keypad-back").click(function(){
        var res = $(".input-result").val();
        $(".input-result").val(res.slice(0, -1));
        $(".input-result").focus();
    });
});
