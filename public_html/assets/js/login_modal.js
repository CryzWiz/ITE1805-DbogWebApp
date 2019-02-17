/**
 * Created by allan on 15.04.2017.
 */
/* #####################################################################
 #
 #   Project       : Modal Login with jQuery Effects
 #   Author        : Rodrigo Amarante (rodrigockamarante)
 #   Version       : 1.0
 #   Created       : 07/29/2015
 #   Last Change   : 08/04/2015
 #
 ##################################################################### */
/**
 * Basic functions is from original script -> layout
 *
 * All ajax code is implemented by us
 */
$(function() {

    var $formLogin = $('#login-form');
    var $formLost = $('#lost-form');
    var $formRegister = $('#register-form');
    var $divForms = $('#div-forms');
    var $modalAnimateTime = 300;
    var $msgAnimateTime = 150;
    var $msgShowTime = 2000;

    $("form").submit(function () {
        switch(this.id) {
            case "login-form":
                var $lg_username=$('#login_email').val();
                var $lg_password=$('#login_password').val();

                var data = [
                    { 'name':'type', 'value':'login'},
                    { 'name':'inputEmail', 'value': $lg_username},
                    { 'name':'inputPassword', 'value': $lg_password}
                ];

                $.ajax({
                    type : 'POST',
                    dataType: 'json',
                    url  : 'controller/process_login.php',
                    data : data,
                    success: function (result, success) {
                        if(result != null){
                            if(result.success == "true"){
                                msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "success", "glyphicon-ok", result.message);

                                setTimeout(function(){
                                    location.reload();
                                }, 1000);
                            }
                            else{
                                msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "error", "glyphicon-remove", result.message);
                            }
                        }
                    }
                });
                break;
            case "lost-form":
                var $ls_email=$('#lost_email').val();

               var data = [
                    { 'name':'type', 'value':'generate_new_password'},
                    { 'name':'inputEmail', 'value': $ls_email}
                ];

                $.ajax({
                    type : 'POST',
                    dataType: 'json',
                    url  : 'controller/process_login.php',
                    data : data,
                    success: function (result, success) {
                        if(result != null){
                            if(result.success == "true"){
                                msgChange($('#div-lost-msg'), $('#icon-lost-msg'), $('#text-lost-msg'), "success", "glyphicon-ok", result.message);
                            }
                            else{
                                msgChange($('#div-lost-msg'), $('#icon-lost-msg'), $('#text-lost-msg'), "error", "glyphicon-remove", result.message);
                            }

                        }
                    }
                });

                return false;
                break;
            case "register-form":

                var $rg_username=$('#register_username').val();
                var $rg_email=$('#register_email').val();
                var $rg_password=$('#register_password').val();
                var $rg_firstname=$('#register_firstname').val();
                var $rg_lastname=$('#register_lastname').val();

                var data = [
                    { 'name':'type', 'value':'register_user'},
                    { 'name':'inputUsername', 'value': $rg_username},
                    { 'name':'inputFirstname', 'value': $rg_firstname},
                    { 'name':'inputLastname', 'value': $rg_lastname},
                    { 'name':'inputEmail', 'value': $rg_email},
                    { 'name':'inputPassword', 'value': $rg_password}
                ];

                $.ajax({
                    type : 'POST',
                    dataType: 'json',
                    url  : 'controller/process_registration.php',
                    data : data,
                    success: function (result, success) {
                        if(result != null){
                            if(result.success == "true"){
                                msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok", result.message);
                            }
                            else{
                                msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "error", "glyphicon-remove", result.message);
                            }
                        }
                    }
                });

                return false;
                break;
            default:
                return false;
        }
        return false;
    });

    $('#login_register_btn').click( function () { modalAnimate($formLogin, $formRegister) });
    $('#register_login_btn').click( function () { modalAnimate($formRegister, $formLogin); });
    $('#login_lost_btn').click( function () { modalAnimate($formLogin, $formLost); });
    $('#lost_login_btn').click( function () { modalAnimate($formLost, $formLogin); });
    $('#lost_register_btn').click( function () { modalAnimate($formLost, $formRegister); });
    $('#register_lost_btn').click( function () { modalAnimate($formRegister, $formLost); });


    function modalAnimate ($oldForm, $newForm) {
        var $oldH = $oldForm.height();
        var $newH = $newForm.height();
        $divForms.css("height",$oldH);
        $oldForm.fadeToggle($modalAnimateTime, function(){
            $divForms.animate({height: $newH}, $modalAnimateTime, function(){
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    }

    function msgFade ($msgId, $msgText) {
        $msgId.fadeOut($msgAnimateTime, function() {
            $(this).text($msgText).fadeIn($msgAnimateTime);
        });
    }

    function msgChange($divTag, $iconTag, $textTag, $divClass, $iconClass, $msgText) {
        var $msgOld = $divTag.text();
        msgFade($textTag, $msgText);
        $divTag.addClass($divClass);
        $iconTag.removeClass("glyphicon-chevron-right");
        $iconTag.addClass($iconClass + " " + $divClass);
        setTimeout(function() {
            msgFade($textTag, $msgOld);
            $divTag.removeClass($divClass);
            $iconTag.addClass("glyphicon-chevron-right");
            $iconTag.removeClass($iconClass + " " + $divClass);
        }, $msgShowTime);
    }
});