$(document).ready(function(){
    $(".keypad-key").click(function(){
        var res = $(".input-result").val();
        if(res.length > 3) return false;
        $(".input-result").val(res + $(this).text());
    });
    $(".keypad-clear").click(function(){
        $(".input-result").val('');
    });
    $(".keypad-back").click(function(){
        var res = $(".input-result").val();
        $(".input-result").val(res.slice(0, -1));
    });
});
