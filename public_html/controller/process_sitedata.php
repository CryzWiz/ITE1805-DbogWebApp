<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 01.05.2017
 * Time: 21.51
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/controller/basic_functions.php");
require_once(dirname(__DIR__, 1) . "/support-classes/SiteData.class.php");

if ( isset( $_POST['type'] ) ) {

    switch ($_POST['type']) {

        case 'update_sitename':
            $result = SiteData::updateSiteName($_POST['activeVal'], $_POST['email']);
            $res = new stdClass();
            if($result) {
                $res->message='Oppdateringen var vellykket! Men vil ikke være synlig for du oppdaterer siden';
                $res->success='true';
            }
            else{
                $res->message='Oppdateringen var mislykket';
                $res->success='false';
            }

            echo  json_encode($res);
            break;

        case 'update_sitetitle':
            $result = false;
            $res = new stdClass();
            if(SiteData::updateSiteTitle($_POST['activeVal'], $_POST['email'])) {
                $res->message='Oppdateringen var vellykket! Men vil ikke være synlig for du oppdaterer siden';
                $res->success='true';
            }
            else{
                $res->message='Oppdateringen var mislykket';
                $res->success='false';
            }
            echo  json_encode($res);
            break;

        case 'update_sitesubtitle':
            $result = false;
            $res = new stdClass();
            if(SiteData::updateSiteSubTitle($_POST['activeVal'], $_POST['email'])) {
                $res->message='Oppdateringen var vellykket! Men vil ikke være synlig for du oppdaterer siden';
                $res->success='true';
            }
            else{
                $res->message='Oppdateringen var mislykket';
                $res->success='false';
            }
            echo  json_encode($res);
            break;

        case 'update_sitemail':
            $result = false;
            $res = new stdClass();
            if(SiteData::updatesitemail($_POST['activeVal'], $_POST['email'])) {
                $res->message='Oppdateringen var vellykket! Men vil ikke være synlig for du oppdaterer siden';
                $res->success='true';
            }
            else{
                $res->message='Oppdateringen var mislykket';
                $res->success='false';
            }
            echo  json_encode($res);
            break;

        case 'getUserInfo':
            $userinfo = getUserInfo($_POST['email']);
            $res = new stdClass();
            $res->user=$userinfo;
            $res->success='true';
            echo  json_encode($res);
            break;

    }
}

function getUserInfo($email){

    $user = UsersQuery::create()->findOneByEmail($email);

    $comments = CommentsQuery::create()->findByMadeByUser($email)->count();

    $deletedComments = CommentsDeletedQuery::create()->findByMadeByUser($email)->count();



    $email = $user->getEmail();
    $username = $user->getUsername();
    $firstname = $user->getFirstname();
    $lastname = $user->getLastname();
    $reg_date = $user->getRegDate();
    $last_login = $user->getCurrentLogin();
    $commentsMade = $comments;
    $commentsDeleted = $deletedComments;
    $active = $user->getActive();

    if(!isset($email)){
        $email = '';
    }
    if(!isset($username)){
        $username = '';
    }
    if(!isset($firstname)){
        $firstname = '';
    }
    if(!isset($lastname)){
        $lastname = '';
    }
    if(!isset($reg_date)){
        $reg_date = '';
    }
    else {
        $reg_date = $reg_date->format('Y-m-d H:i:s');
    }
    if(!isset($last_login)){
        $last_login = '';
    }
    else{
        $last_login = $last_login->format('Y-m-d H:i:s');
    }
    if(!isset($commentsMade)){
        $commentsMade = '0';
    }
    if(!isset($commentsDeleted)){
        $commentsDeleted = 0;
    }
    if(!isset($active)){
        $active = '';
    }
    $userinfo = array("email" => $email, "username" => $username,
        "firstname" => $firstname, "lastname" => $lastname,
        "reg_date" => $reg_date, "lastlogin" => $last_login,
        "commentsMade" => $commentsMade, "commentsDeleted" => $commentsDeleted, "active" => $active);
    return $userinfo;
}