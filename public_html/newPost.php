<?php
//require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(__DIR__ . "/global_init.php");
require_once(__DIR__ . "/support-classes/SessionManager.class.php");
require_once(__DIR__ . "/support-classes/Login.class.php");
require_once(__DIR__ . "/support-classes/UserManager.php");
require_once(__DIR__ . "/support-classes/OutputFormat.php");

define("IMAGE_SIZE_LIMIT", 5000000);

use Propel\Runtime\Propel;

/**
 * Start the session
 */
session_start();
//SessionManager::sessionStart('ITE1805-Blogg', 0, '/', 'http://kark.uit.no/~aar029/ITE1805/Blogg-Prosjekt/public_html/', true);

/**
 * load the twig template from template folder
 */
$template = $twig->load('newPost.twig');

$data = $GLOBALS['twigdata'];
$um = new UserManager();
$of = new OutputFormat();

/**
 * Fetch site settings for the page from the database
 */
$sitesettings = SitesettingsQuery::create()->findOneById(1);

/**
 * Check if the user is logged in, and fetch the session data if we have a logged in user
 */
if(isset($_SESSION["loginString"])){
	if(Login_class::check_login()){
		$user = UsersQuery::create()->findOneByEmail($_SESSION['usermail']);
		$data['loginString'] = $_SESSION["loginString"];
		$data['user'] = $user;
		$data['name'] = $um->getFullName($_SESSION['usermail']);
	}
	else{
		header("Location: index.php"); // TODO: add dir and error code/message
		return;
	}
}

/**
 * Saving a blog-post
 */
if(isset($_POST['save'])){
	/*
	 * Image uploading example from
	 * https://www.w3schools.com/php/php_file_upload.asp
	 */
	if($_POST['post']){
		$post = PostsQuery::create()->findOneByPostId($_POST['post']);
	} else {
		$post = new Posts();
		$post->setActive(1);
		$post->setPostDate(new DateTime());
		$post->setUserId($_SESSION['usermail']);
	}

	if(!isset($_POST['imageOption'])) {
		$error = "noImageOption";
	} else {
		if($_POST['imageOption'] == 'upload'){
			$target_dir = "/uploaded-imgs";
			//echo $target_dir;
			$filename = basename($_FILES["image"]["name"]);
			$target_file = $target_dir . $filename;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			if ($check != false) {
				$uploadOk = 1;
			} else {
				$uploadOk = 0;
				// TODO: Code for fake image
			}

			if (file_exists($target_file)) {
				$uploadOk = 0;
				// TODO: Code for already existing file
			}

			if ($_FILES["image"]["size"] > IMAGE_SIZE_LIMIT) {
				$uploadOk = 0;
				// TODO: Code for too big image file
			}

			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
				$uploadOk = 0;
				// TODO: Code for wrong file extension
			}

			if ($uploadOk == 0) {
				// TODO: IMPORTANT, handle case where image upload failed

			} else {
				if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
					// TODO: file uploaded

				} else {
					// TODO: In case of unexpected error while uploading
				}
			}
			if($uploadOk > 0) {
				$post->setPostImageUrl($data['image_dir'] . "/" . $filename);
			}
		} elseif ($_POST['imageOption'] == 'url'){
			$post->setPostImageUrl($_POST['url']);
		} elseif ($_POST['imageOption'] == 'noImage'){
			$post->setPostImageUrl(null);
		}
	}

	if(isset($_POST['title'])) {
		$post->setPostTitle($_POST['title']);
	}
	if(isset($_POST['content'])) {
		$post->setPostText($_POST['content']);
	}

	// TODO: Save in sequence of rows for very long posts.
	$post->save();
	$post->reload();


	header("Location: post.php?post=" . $post->getPostId());
	return;
} elseif(isset($_GET['post'])){
	$post = PostsQuery::create()->findOneByPostId($_GET['post']);
	if($user->getEmail() != $post->getUserId()) {
		header("Location: post.php?error=noEditPrivileges");
		return;
	}
	$data['post'] = $post;
}

/**
 * Adding all our data for the template
 */
$data['date'] = $of->dtOut(new DateTime());
$data['postsearch'] = PostsQuery::create()->addDescendingOrderByColumn('post_id')->find()->getData();
/**
 * Page relevant information
 */

$data['site_name'] = $sitesettings->getSiteName(); // To be read from the db -> User settings.
$data['page_title'] = ' Post name'; // -> To either be Hjem, Settings, MyPage or postTitle
$data['post_title'] = 'POST-TITTEL'; // -> To be post title
$data['writer'] = 'username or name'; // -> To be set by user in settings
/**
 * server urls
 */
$data['project_path'] = $public_path;
$data['server_url'] = $GLOBALS['server_url'];
$data['public_html_dir']= $GLOBALS['user_dir'] . $GLOBALS['prj_dir'];
$data['logoutLink'] = $GLOBALS['user_dir'] . $GLOBALS['prj_dir'] . "/controller/logout.php";
$data['isPrivate'] = false;
/**
 * Finally echo the template with all our data
 */
echo $template->render($data);