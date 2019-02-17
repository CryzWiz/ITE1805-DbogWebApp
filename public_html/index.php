<?php
/**
 * Created by PhpStorm.
 * User: Allan Arnesen
 * Date: 30.03.2017
 * Time: 15.31
 */


require_once(__DIR__. "/global_init.php");
require_once(__DIR__. "/support-classes/SessionManager.class.php");
require_once(__DIR__. "/support-classes/Login.class.php");
require_once(__DIR__. "/support-classes/OutputFormat.php");
require_once(__DIR__. "/support-classes/UserManager.php");
require_once(__DIR__. "/controller/basic_functions.php");

use Propel\Runtime\Propel;

/**
 * Start the session
 */
session_start();
//SessionManager::sessionStart('ITE1805-Blogg', 0, '/', 'http://kark.uit.no/~aar029/ITE1805/Blogg-Prosjekt/public_html/', true);
/**
 * load the twig template from template folder
 */
$template = $twig->load('index.twig');
/**
 * If site_activated is false or NULL redirect user to
 * the create admin page. Its the first time the blog is being used
 */
if(!SitesettingsQuery::create()->findOneBySiteActivated(true)
    && UsersQuery::create()->findOneByRole(2) == false){

    header('Location: controller/create_admin.php?step=1');
    exit();
}
/**
 * Initial code for the page
 */
$data = $GLOBALS['twigdata'];
$page = 0;
$sitesettings = SitesettingsQuery::create()->findOneById(1);;
if(isset($_GET['page'])){ $page = $_GET['page']; }
$sitePostsPerPage = 3;
/**
 * Check if the user is logged in, and fetch the session data if we have a logged in user
 * and fetch the user-table-row from the database and put it in twig data array
 */

$posts = array();
if(isset($_SESSION["loginString"]) && Login_class::check_login()){
        $user = UsersQuery::create()->findOneByEmail($_SESSION['usermail']);
        $data['loginString'] = $_SESSION["loginString"];
        $data['user'] = $user;
        if($user->getRole()>1){
        	$posts = PostsQuery::create()->addDescendingOrderByColumn('post_id')->find()->getData();
        } else {
            $posts = PostsQuery::create()->addDescendingOrderByColumn('post_id')->filterByActive(1)->find()->getData();
        }
} else {
	$posts = PostsQuery::create()->addDescendingOrderByColumn('post_id')->filterByActive(1)->find()->getData();
	$data['loginString'] = null;
	$data['usermail'] = null;
	$data['role'] = null;
}

/**
 * Fetching all the posts for the search-field
 */
$data['postsearch'] = $posts;
/**
 * Adding all our data for the template
 */

$data['posts'] = subArray($posts, $sitePostsPerPage * $page, $sitePostsPerPage);
$data['of'] = new OutputFormat();
$data['um'] = new UserManager();

$data['page'] = $page;
$data['showNext'] = sizeof($posts) > $sitePostsPerPage * ($page + 1);
/**
 * Page relevant information
 */
$data['site_name'] = $sitesettings->getSiteName(); // To be read from the db -> User settings.
$data['page_heading'] = $sitesettings -> getSiteTitle(); // To be read from the db -> User settings.
$data['page_secondary_heading'] = $sitesettings->getSiteSubtitle(); // To be read from the db -> User settings.
$data['page_title'] = $sitesettings->getSiteName(); // To be read from the db -> User settings.
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