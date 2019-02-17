/**
 * Created by allan on 07.05.2017.
 */
$('#find_user_admin').on('click', function(){
    getUserInfo($('#find_username_admin2').val());
});

function getUserInfo($email){

    var data = [
        { 'name':'type', 'value': 'getUserInfo'},
        { 'name':'email', 'value': $email}
    ];
    $.ajax({
        url: "controller/process_sitedata.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if (result != null) {
                if (result.success == "true") { //success
                    $("#aucTable").empty();

                    var table = document.getElementById("aucTable");
                    $('#active_user').val(result.user['email']);
                    var headers = ["Epost","Brukernavn","Fornavn", "Etternavn", "Registrert","Siste innlogging",
                    "Kommentarer", "Kommentarer slettet", "Behandle konto"];
                    var responce = [result.user['email'], result.user['username'], result.user['firstname'], result.user['lastname'],
                        result.user['reg_date'], result.user['lastlogin'], result.user['commentsMade'], result.user['commentsDeleted'],
                    result.user['active']];

                    for (i = 0; i < responce.length; i++) {
                        var row = table.insertRow(i);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        cell1.innerHTML = headers[i];
                        if(i == 8){
                            if(responce[i] == true){
                                cell2.innerHTML = 'Konto er <span style="color:green;">aktiv</span> | <a href="#" OnClick="deactivateAccount()">Deaktiver konto</a>';
                            }
                            else {
                                cell2.innerHTML = 'Konto er <span style="color:red;">deaktivert</span> | <a href="#" OnClick="activateAccount()">Aktiver konto</a>';
                            }
                        }
                        else{
                            cell2.innerHTML = responce[i];
                        }


                    }

                }
                else { // error
                    var table = document.getElementById("aucTable");
                    var row = table.insertRow(0);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    cell1.innerHTML = "Ops";
                    cell2.innerHTML = "Noe gikk galt og ingen info ble funnet...";
                }

            }

        }
    });

}

function deactivateAccount(){
    var email = $('#active_user').val();
    var data = [
        { 'name':'type', 'value': 'deactivateAccount'},
        { 'name':'email', 'value': email}
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
                    getUserInfo(email);
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

function activateAccount(){
    var email = $('#active_user').val();
    var data = [
        { 'name':'type', 'value': 'activateAccount'},
        { 'name':'email', 'value': email}
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
                    getUserInfo(email);
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