/**
 * Created by allan on 01.05.2017.
 */

$('#edit_sitename').on('click', function(){

    var ans = $('#edit_sitename');

    $("#update_sitename").prop('disabled', false);
    $("#sitename").prop('disabled', false);

    ans.remove();

});

$('#edit_sitetitle').on('click', function(){

    var ans = $('#edit_sitetitle');

    $("#update_sitetitle").prop('disabled', false);
    $("#sitetitle").prop('disabled', false);

    ans.remove();

});

$('#edit_sitesubtitle').on('click', function(){

    var ans = $('#edit_sitesubtitle');

    $("#update_sitesubtitle").prop('disabled', false);
    $("#sitesubtitle").prop('disabled', false);

    ans.remove();

});

$('#edit_sitemail').on('click', function(){

    var ans = $('#edit_sitemail');

    $("#update_sitemail").prop('disabled', false);
    $("#sitemail").prop('disabled', false);

    ans.remove();

});
$('#update_sitename').on('click', function(){
    var type = 'update_sitename';
    updateDB(type, $('#sitename').val(), $('#email').val());
});
$('#update_sitetitle').on('click', function(){
    var type = 'update_sitetitle';
    updateDB(type, $('#sitetitle').val(), $('#email').val());
});
$('#update_sitesubtitle').on('click', function(){
    var type = 'update_sitesubtitle';
    updateDB(type, $('#sitesubtitle').val(), $('#email').val());
});
$('#update_sitemail').on('click', function(){
    var type = 'update_sitemail';
    updateDB(type, $('#sitemail').val(), $('#email').val());
});


function updateDB($type, $activeVal, $email){

    var data = [
        { 'name':'type', 'value': $type},
        { 'name':'activeVal', 'value': $activeVal},
        { 'name':'email', 'value': $email}
    ];
    $.ajax({
        url: "controller/process_sitedata.php",
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
