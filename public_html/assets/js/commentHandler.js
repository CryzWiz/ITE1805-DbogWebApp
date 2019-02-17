/**
 * Created by Kenneth on 02.05.2017.
 */
/**
 * Script inspired by "Modal Login" script (by Rodrigo Amarante, expanded by Allan Arnesen)
 *
 * All ajax code is implemented by us
 */
function comment_reply_form(comment_id, reply_id){
    //alert(comment_id);
    var $divReply=$('#reply'+comment_id);
    $('#reply-form').remove();

    $divReply.append(
        '<form role="form" id="reply-form">' +
        '   <input type="hidden" name="replyTo" id="reply-to" value="'+ reply_id +'">' +
        '   <div class="input-group">' +
        '       <input type="text" name="replyContent" id="reply-content" class="form-control" placeholder="svar...">' +
        '       <span class="input-group-btn">' +
        '           <Button onclick="comment_reply()" class="btn btn-default">Svar</Button>' +
        '       </span>' +
        '   </div>' +
        '</form>');
}

function comment_reply(){
    var $input_comment=$('#reply-content').val();
    var $comment_id=$('#reply-to').val();

    if($input_comment.length > 0) {

        var data = [
            {'name': 'type', 'value': 'reply'},
            {'name': 'toComment', 'value': $comment_id},
            {'name': 'comment', 'value': $input_comment}
        ];
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: 'controller/process_comment.php',
            data: data,
            success: function (result, success) {
                if (result != null) {
                    if (success == "success") {
                        var commentId = $comment_id;
                        $('#comment'+ commentId +' .replies').append(result);
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
}

function comment_remove($comment_id) {
    var data = [
        {'name': 'type', 'value': 'remove'},
        {'name': 'comment', 'value': $comment_id},
    ];
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'controller/process_comment.php',
        data: data,
        success: function (result, success) {
            if (result != null) {
                if (success == "success") {
                    $('.media #comment' + result.message).remove();
                }
                else {
                    alert("Noe gikk galt: " + result.message);
                    // TODO: Functionality to automatically show login form upon fail due to not being logged in
                }
            }
        },
        error: function (result, success) {
            alert("Noe gikk galt\n"+success+"\n"+result.success);
        }
    });
}

$(function() {
    $("form").submit(function () {
        switch(this.id) {
            case "comment-form":
                var $input_comment=$('#input-comment').val();
                var $post_id=$('#input-post-id').val();

                if($input_comment.length > 0) {

                    var data = [
                        {'name': 'type', 'value': 'create'},
                        {'name': 'post', 'value': $post_id},
                        {'name': 'comment', 'value': $input_comment}
                    ];
                    $.ajax({
                        type: 'POST',
                        dataType: 'html',
                        url: 'controller/process_comment.php',
                        data: data,
                        success: function (result, success) {
                            if (result != null) {
                                if (success == "success") {
                                    $('#comments').append(result);
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
                break;

            case "reply-form":

            break;

            default:
                return false;
        }
        return false;
    });
});