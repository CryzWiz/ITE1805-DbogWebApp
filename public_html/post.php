<?php
//require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(__DIR__. "/global_init.php");
require_once(__DIR__. "/support-classes/SessionManager.class.php");
require_once(__DIR__. "/support-classes/Login.class.php");
require_once(__DIR__. "/support-classes/UserManager.php");
require_once(__DIR__. "/support-classes/OutputFormat.php");
require_once(__DIR__. "/support-classes/PostManager.class.php");
use Propel\Runtime\Propel;

/**
 * Start the session
 */
session_start();
//SessionManager::sessionStart('ITE1805-Blogg', 0, '/', 'http://kark.uit.no/~aar029/ITE1805/Blogg-Prosjekt/public_html/', true);

/**
 * load the twig template from template folder
 */
$template = $twig->load('post.twig');
/**
 * Fetch site settings for the page
 */
$sitesettings = SitesettingsQuery::create()->findOneBySiteActivated(true);
/**
 * Adding all our data for the template
 */
if(!isset($_GET['post'])){
	header("Location: index.php");
	return;
}
$data = $GLOBALS['twigdata'];
/**
 * Fetch our post and increment the visit counter
 * Also store the post to the twig data
 */
$post = PostsQuery::create()->findOneByPostId($_GET['post']);
$data['post'] = $post;
PostManager::addOneVisit($post->getPostId());

$data['comments'] = CommentsQuery::create()->filterByToComment(null)->findByToPost($_GET['post'])->getData();
$data['um'] = new UserManager();
$data['of'] = new OutputFormat();
$data['site_name'] = $sitesettings->getSiteName(); // To be read from the db -> User settings.
$data['page_title'] = $data['post']->getPostTitle(); // -> To either be Hjem, Settings, MyPage or postTitle

/**
 * Check if the user is logged in, and fetch the session data if we have a logged in user
 */
if(isset($_SESSION["loginString"])){

    if(Login_class::check_login()){
        $user = UsersQuery::create()->findOneByEmail($_SESSION['usermail']);
        $data['loginString'] = $_SESSION["loginString"];
        $data['user'] = $user;
    } else {
        $data['loginString'] = null;
        $data['usermail'] = null;
        $data['role'] = null;
    }
}
/**
 * Fetching all the posts for the search-field
 */
$data['postsearch'] = PostsQuery::create()->findByActive(1)->getData();
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