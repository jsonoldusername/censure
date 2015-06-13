$(document).ready(function() {
    var method = 1; var uvalid = 0; var pvalid = 0; var check = 0;
    $('.warning').hide();
    $('.roundedOne label').click(function(){
        if(check == 0) {
            check = 1;
        } else {
            check = 0;
        }
    });
    $("input:button").click(function(){
        if(uvalid == 1 && pvalid == 1) {
            $("#suser").val($("#ouser").val());
            $("#spass").val($("#opass").val());
            if(method == 1) {
                if(check == 1) {
                    $("#target").attr("action", "signup.php");
                    $("#target").submit();
                } else {
                    $('.warning').text("The TOS, Bro");
                    $('.warning').show();
                }
            } else if(method == 2) {
                $("#target").attr("action", "login.php");
                var usubmit = $('input[type=text]').val();
                var psubmit = $('input[type=password]').val();
                $.post("checkPassword.php", { username: usubmit, password: psubmit },  
                    function(result){  
                        if(result > 0) {
                            $("#target").submit();
                        } else {
                            $('input[type=text]').css({ 'color': 'red', 'border-color': 'red' });
                            $('input[type=password]').css({ 'color': 'red', 'border-color': 'red' });
                            $('.warning').text("Invalid Username/Password");
                            $('.warning').show();
                        }
                    }); 
            }
        } else {
            if(pvalid == 1) {
                $('.warning').text("Username Is Taken");
            } else {
                $('.warning').text("Invalid Username/Password");
            }
            $('.warning').show();
        }
    });
    $("#left").click(function(){
        method = 1;
        if($("input:button").val() == "Welcome Aboard") {
        } else {
            $("#tos").show();
            if($("input:button").val() == "Start") {
                $("#loginx").fadeToggle(200);
                $("input:button").val("Welcome Aboard");
            } else {
                $("input:button").val("Welcome Aboard");
            }
        }
    });
    $("#right").click(function(){
        method = 2;
        $("#tos").hide();
        if($("input:button").val() == "Welcome Back") {
        } 
        else {
            if($("input:button").val() == "Start") {
                $("input:button").val("Welcome Back");
                $("#loginx").fadeToggle(200);
            } else {
                $("input:button").val("Welcome Back");
            }
        }
    });
    $('input[type=password]').keyup(function() {
        var pass = $(this).val();
        if (pass.length < 8 || pass.length > 16) {
            pvalid = 0;
            $('input[type=password]').css({ 'color': 'red', 'border-color': 'red' });
            $('.warning').text("Invalid Username/Password");
            $('.warning').show();
        } else {
            pvalid = 1;
            $('input[type=password]').css({ 'color': '#ffffff', 'border-color': '#ffffff' });
            $('.warning').hide();
        }
    }).blur(function() {
        $('input[type=password]').css({ 'color': '#ffffff', 'border-color': '#ffffff' });
        $('.warning').hide();
    });
    $('input[type=text]').keyup(function() {
        var user = $(this).val();
        if (user.length < 6 || user.length > 20) {
            uvalid = 0;
            $('input[type=text]').css({ 'color': 'red', 'border-color': 'red' });
            $('.warning').text("Invalid Username/Password");
            $('.warning').show();
        } else {
            if(method == 1) {
                $.post("checkUser.php", { username: user },  
                    function(result){  
                        if(result > 0){  
                            uvalid = 1;
                            $('input[type=text]').css({ 'color': '#ffffff', 'border-color': '#ffffff' });
                            $('.warning').hide();
                        } else {  
                            uvalid = 0;
                            $('input[type=text]').css({ 'color': 'red', 'border-color': 'red' });
                            $('.warning').text("Username Is Taken");
                            $('.warning').show();
                        } 
                    });  
            } else {
            uvalid = 1;
            $('input[type=text]').css({ 'color': '#ffffff', 'border-color': '#ffffff' });
            $('.warning').hide();
            }
            }
    }).blur(function() {
        $('input[type=text]').css({ 'color': '#ffffff', 'border-color': '#ffffff' });
        $('.warning').hide();
    });
});