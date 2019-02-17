/**
 * Created by allan on 01.05.2017.
 */
$('#updateUsername').on('click', function(){
    updateUsername($('#uname').val(),$('#email').val());
});
$('#updateFirstname').on('click', function(){
    updateFirstname($('#fname').val(),$('#email').val());
});
$('#updateLastname').on('click', function(){
    updateLastname($('#lname').val(),$('#email').val());
});
$('#updatePassword').on('click', function(){
    updatePassword($('#passOne').val(), $('#passTwo').val(), $('#email').val());
})

function updateUsername($uname, $email){

    var data = [
        { 'name':'type', 'value':'updateUsername'},
        { 'name':'uname', 'value': $uname},
        { 'name':'email', 'value': $email}
    ];
    $.ajax({
        url: "controller/process_userdata.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {

            var ans = $('#alert_mypage');
            if (result != null) {
                if (result.success == "true") { //success
                    if (ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-success");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_mypage").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else { // error
                    if (ans.hasClass("alert-success"))
                        ans.removeClass("alert-success");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_mypage").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }

            }

        }
    });


}

function updateFirstname($fname, $email){

    var data = [
        { 'name':'type', 'value':'updateFirstName'},
        { 'name':'fname', 'value': $fname},
        { 'name':'email', 'value': $email}
    ];
    $.ajax({
        url: "controller/process_userdata.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {

            var ans = $('#alert_mypage');
            if (result != null) {
                if (result.success == "true") { //success
                    if (ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-success");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_mypage").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else { // error
                    if (ans.hasClass("alert-success"))
                        ans.removeClass("alert-success");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_mypage").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }

            }

        }
    });


}

function updateLastname($lname, $email){

    var data = [
        { 'name':'type', 'value':'updateLastName'},
        { 'name':'lname', 'value': $lname},
        { 'name':'email', 'value': $email}
    ];
    $.ajax({
        url: "controller/process_userdata.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {

            var ans = $('#alert_mypage');
            if (result != null) {
                if (result.success == "true") { //success
                    if (ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-success");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_mypage").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else { // error
                    if (ans.hasClass("alert-success"))
                        ans.removeClass("alert-success");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_mypage").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }

            }

        }
    });


}

function updatePassword($passOne, $passTwo, $email){
    var data = [
        { 'name':'type', 'value':'updatePassword'},
        { 'name':'passOne', 'value': $passOne},
        { 'name':'passTwo', 'value': $passTwo},
        { 'name':'email', 'value': $email}
    ];
    $.ajax({
        url: "controller/process_userdata.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {

            var ans = $('#alert_mypage');
            if (result != null) {
                if (result.success == "true") { //success
                    if (ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-success");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_mypage").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else { // error
                    if (ans.hasClass("alert-success"))
                        ans.removeClass("alert-success");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_mypage").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }

            }

        }
    });


}