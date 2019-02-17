

function post_deactivate($post_id) {
    var data = [
        {'name': 'type', 'value': 'deactivate'},
        {'name': 'post', 'value': $post_id}
    ];
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'controller/process_post_active.php',
        data: data,
        success: function (result, success) {
            if (result != null) {
                if (success == "success") {
                    // TODO: Indicate post as deactivated
                    //$('#comment' + commentId + ' .replies').append(result);
                }
                else {
                    alert("Noe gikk galt: " + result.message);
                    // TODO: Functionality to automatically show login form upon fail due to not being logged in
                }
            }
        },
        error: function (result, success) {
            alert("Noe gikk galt");
        }
    });
}

function post_activate(post_id) {
    var data = [
        {'name': 'type', 'value': 'activate'},
        {'name': 'post', 'value': post_id}
    ];
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'controller/process_post_active.php',
        data: data,
        success: function (result, success) {
            if (result != null) {
                if (success == "success") {
                    // TODO: Indicate post as activated
                    //$('#comment' + commentId + ' .replies').append(result);
                }
                else {
                    alert("Noe gikk galt: " + result.message);
                    // TODO: Functionality to automatically show login form upon fail due to not being logged in
                }
            }
        },
        error: function (result, success) {
            alert("Noe gikk galt");
        }
    });
}