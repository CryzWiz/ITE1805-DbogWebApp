<?php

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/support-classes/Login.class.php");
require_once(dirname(__DIR__, 1) . "/support-classes/UserManager.php");
use Propel\Runtime\Propel;
/**
 * Start the session
 */
session_start();

/**
 * First we check if the user is logged inn
 */
if(!isset($_SESSION["loginString"]) || !Login_class::check_login()) {
	/**
	 *
	 */
	$message = 'Du må logge inn for å kommentere!';
	$success = false;
	$data = new stdClass();
	$data->success = 'false';
	$data->message = $message;
	echo json_encode($data);
} elseif(isset($_POST['type'])) {
	switch($_POST['type']){
		case 'create':
			if (isset($_POST['comment']) && isset($_POST['post'])) {
				$commentText = $_POST['comment'];
				$postId = $_POST['post'];
				$comment = new Comments();
				$comment->setToPost($postId);
				$comment->setMadeByUser($_SESSION['usermail']); // Email is PK for users
				$comment->setCommentMade(new DateTime());
				$comment->setComment($commentText);
				$comment->save(); // TODO: Handle failed saving
				$comment->reload();
				$data = new stdClass();

				$template = $twig->load('newComment.twig');
				$um = new UserManager();
				$twigData = array(
					'name' => $um->getFullName($_SESSION['usermail']),
					'date' => 'August 25, 2014 at 9:30 PM', //Placeholder until comments get time
					'comment' => $commentText,
					'commentId' => $comment->getCommentId());
				$success = true;
				echo $commentHTML = $template->render($twigData);
			} else {
				/**
				 *
				 */
				$message = 'Mottok mangelfulle opplysninger!';
				$success = false;
				$data = ['success '=> '', 'message' => $message];
				echo json_encode($data);
			}
			break;
		case 'reply':
			if (isset($_POST['comment']) && isset($_POST['toComment'])) {
				$commentText = $_POST['comment'];
				$toComment = CommentsQuery::create()->findOneByCommentId($_POST['toComment']);
				$comment = new Comments();
				$comment->setMadeByUser($_SESSION['usermail']); // Email is PK for users
				$comment->setCommentMade(new DateTime());
				/**
				 * Making sure that the reply is not pointing to another reply
				 * If so, replace the pointer with a reference to that comments owner
				 * and setting the pointer to the original comment
				 */
				if($toComment->getToComment() != null){
					$owner = (new UserManager())->getFullName($toComment->getMadeByUser());
					$commentText = "@".$owner." ".$commentText;
					$comment->setToComment($toComment->getToComment());
				} else {
					$comment->setToComment($toComment->getCommentId());
				}
				$comment->setToPost($toComment->getToPost());
				$comment->setComment($commentText);
				$comment->save(); // TODO: Handle failed saving
				$comment->reload();

				$template = $twig->load('replyComment.twig');
				$twigData = array(
					'name' => (new UserManager())->getFullName($_SESSION['usermail']),
					'date' => 'August 25, 2014 at 9:30 PM', //Placeholder until comments get time
					'comment' => $commentText,
					'parentId' => $comment->getToComment(),
					'commentId' => $comment->getCommentId());
				$success = true;
				echo $commentHTML = $template->render($twigData);
			} else {
				/**
				 *
				 */
				$message = 'Mottok mangelfulle opplysninger!';
				$success = false;
				$data = ['success '=> '', 'message' => $message];
				echo json_encode($data);
			}
			break;
		case 'remove':
			$data = new stdClass();
			$success='';
			if(!isset($_POST['comment'])){
				$message = "Ingen kommentar valgt!";
			} else {
				$comment = CommentsQuery::create()->findOneByCommentId($_POST['comment']);
				$user = UsersQuery::create()->findOneByEmail($_SESSION{'usermail'});
				if($user->getRole() > 1 || $user->getEmail() == $comment->getMadeByUser()){
					// TODO: Move comments to another table
					$comment = CommentsQuery::create()->findOneByCommentId($_POST['comment']);
					if($comment != null) {
						$deleted = new CommentsDeleted();
						$deleted->setCommentId($comment->getCommentId());
						$deleted->setToPost($comment->getToPost());
						$deleted->setToComment($comment->getToComment());
						$deleted->setCommentMade($comment->getCommentMade());
						$deleted->setMadeByUser($comment->getMadeByUser());
						$deleted->setComment($comment->getComment());
						$deleted->save();
						CommentsQuery::create()->findByCommentId($comment->getCommentId())->delete();
						$message = $deleted->getCommentId();
						$success = 'true';
					} else {
						$message = "Requested comment does not exist";
					}
				} else {
					$message = "Du kan ikke slette andres kommentarer!";
				}
			}
			$data->success = $success;
			$data->message = $message;
			echo json_encode($data);
			break;
	}
}

