<?php

/**
 * Created by PhpStorm.
 * User: Chexxor
 * Date: 5/8/2017
 * Time: 10:23 PM
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/support-classes/Login.class.php");
use Propel\Runtime\Propel;

/**
 * Start the session
 */
session_start();
/**
 * Check if user is logged in
 */
$success = false;
if(!isset($_SESSION["loginString"]) || !Login_class::check_login()) {
	$message = 'Du må logge inn for å kommentere!';
} elseif (isset($_POST['type'])){
	switch ($_POST['type']){
		case 'deactivate':
			if($_POST['post']){
				$post = PostsQuery::create()->findOneByPostId($_POST['id']);
				if($post->getActive() < 1){
					$message = "Posten er allerede inaktiv";
				} else {
					$post->setActive(0);
					$post->save();
					$success = true;
					$message = "Post deaktivert";
				}
			} else {
				$message = "Post ikke spesifisert";
			}
			break;
		case 'activate':
			if($_POST['post']){
				$post = PostsQuery::create()->findOneByPostId($_POST['id']);
				if($post->getActive() != 0){
					$message = "Posten er allerede aktiv";
				} else {
					$post->setActive(1);
					$post->save();
					$success = true;
					$message = "Post aktivert";
				}
			} else {
				$message = "Post ikke spesifisert";
			}
			break;
		default:
			$message = "Funksjon må være spesifisert vha. POST.";
	}
} else {
	$message = "Type forespørsel må være spesifisert vha. POST.";
}
$data = new stdClass();
$data->success = $success;
$data->message = $message;
echo json_encode($data);
