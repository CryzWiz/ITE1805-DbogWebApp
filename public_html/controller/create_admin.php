<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 16.04.2017
 * Time: 23.52
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/controller/create_admin_action.php");
require_once(dirname(__DIR__, 1) . "/support-classes/CreateAdminDbTasks.class.php");
require_once(dirname(__DIR__, 1) . "/controller/basic_functions.php");
/**
 * This file is part of the five-some CreateAdminDbTasks.class.php,
 * create_admin.php, create_admin_action.php and create_admin.twig, create_admin.css.
 *
 * These files are not exactly part of the blog. They are supposed to work in that way
 * that if the database holds no data ( precisely site_activated and a user with role 2)
 * the user get routed though this and has to give up some basic information for the site.
 * Make a admin account, set site name, site mail, give up full name etc etc.
 *
 * Just a quick way to get the site running after a fresh installation -> But not developed
 * very far since its not part of the exercise. Just a very simple implementation. Probably
 * not bug free.
 */
$template = $twig->load('create_admin.twig');



$data = $GLOBALS['twigdata'];

$data['step'] = $_GET['step'];
if(isset($_GET['error'])){
    $error = $_GET['error'];
    $data['error'] = $error;
}
if(isset($_GET['message'])){
    $message = $_GET['message'];
    $data['message'] = $message;
}
if(isset($_GET['email'])) {
    $email = $_GET['email'];
    $data['email'] = $email;
}
if(isset($_GET['current_id'])) {
    $current_id = $_GET['current_id'];
    $data['current_id'] = $current_id;
}

$data['page_title'] = 'Aktiver Bloggen Din';
$data['project_path'] = $public_path;
$data['server_url'] = $GLOBALS['server_url'];
$data['public_html_dir']= $GLOBALS['user_dir'] . $GLOBALS['prj_dir'];
$data['isPrivate'] = false;


echo $template->render($data);