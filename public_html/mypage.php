<?php
//require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(__DIR__. "/global_init.php");
require_once(__DIR__. "/support-classes/SessionManager.class.php");
require_once(__DIR__. "/support-classes/Login.class.php");
require_once(__DIR__. "/support-classes/UserManager.php");
require_once(__DIR__. "/support-classes/OutputFormat.php");
require_once(__DIR__. "/support-classes/GetBlogStats.class.php");


/**
 * Start the session
 */
session_start();
//SessionManager::sessionStart('ITE1805-Blogg', 0, '/', 'http://kark.uit.no/~aar029/ITE1805/Blogg-Prosjekt/public_html/', true);
/**
 * load the twig template from template folder
 */
$template = $twig->load('mypage.twig');

/**
 * Adding all our data for the template
 */
$data = $GLOBALS['twigdata'];
/**
 * Check if the user is logged in, and fetch the session data if we have a logged in user
 */
if(Login_class::check_login()){

    $user = UsersQuery::create()->findOneByEmail($_SESSION['usermail']);
    $data['numberOfComments'] = CommentsQuery::create()->filterByMadeByUser($_SESSION['usermail'])->count();
    $data['numberOfPosts'] = PostsQuery::create()->filterByUserId($_SESSION['usermail'])->count();
    $data['loginString'] = $_SESSION["loginString"];
    $data['user'] = $user;
    $data['users'] = UsersQuery::create()->addAscendingOrderByColumn('email')->find();

}
else{
    header('Location: index.php?access=forbidden');
    exit();
}

/**
 * Fetch site settings for the page
 */
$sitesettings = SitesettingsQuery::create()->findOneById(1);
$data['sitesettings'] = $sitesettings;
/**
 * Admin information
 */

$data['topCommenters'] = GetStats::getTopCommenters();
$data['topPostsByComments'] = GetStats::getTopPostsByComments();

$data['totalNumberOfComments'] = CommentsQuery::create()->count();
$data['totalNumberOfPosts'] = PostsQuery::create()->count();
$data['topPostsByVisits'] = GetStats::getTopPosts();
$data['totalViews'] = GetStats::getTotalViews();
$data['totalNumberOfUsers'] = UsersQuery::create()->filterByRole(1)->count();

/**
 * Page relevant information
 */
$data['site_name'] = $sitesettings->getSiteName(); // To be read from the db -> User settings.
$data['page_heading'] = 'Min side'; // To be read from the db -> User settings.
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