<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 16.04.2017
 * Time: 23.52
 */

require_once(dirname(__DIR__, 1)."/global_init.php");
require_once(dirname(__DIR__, 1)."/controller/basic_functions.php");
/**
 * Landing page for users verifying their emails
 */
$template = $twig->load('verify_mail.twig');

$data = $GLOBALS['twigdata'];

if(isset($_GET['id'])){
    $val = ValidationLinkQuery::create()->findOneByValidationId($_GET['id']);
    if($val != null &&
    $val->getUsed() == null){
        $user = UsersQuery::create()->findOneByEmail($val->getUserId());
        if($user->getValidated()){
            $user->setPassword(getPasswordHash($val->getValidationId()));
            $user->save();

            $val->setUsed(date('Y/m/d H:i:s'));
            $val->save();

            $data['page_title'] = 'Vi har laget et nytt passord til deg!';
            $data['user'] = $user;
            $data['password'] = $_GET['id'];
            $data['status'] = '2';
            $data['validated'] = 'true';
        }
        else {
            $user->setActive(1);
            $user->setValidated(1);
            $user->save();

            $val->setUsed(date('Y/m/d H:i:s'));
            $val->save();

            $data['page_title'] = 'Velkommen som ny bruker!';
            $data['user'] = $user;
            $data['status'] = '1';
            $data['validated'] = 'true';
        }

    }
    else{
        $data['validated'] = 'false';
    }

}
/**
 * Fetch site settings for the page
 */
$sitename = SitesettingsQuery::create()->findOneBySiteActivated(true)->getSiteName();
$data['page_title'] = $sitename;
$data['project_path'] = $public_path;
$data['server_url'] = $GLOBALS['server_url'];
$data['public_html_dir']= $GLOBALS['user_dir'] . $GLOBALS['prj_dir'];
$data['isPrivate'] = false;


echo $template->render($data);