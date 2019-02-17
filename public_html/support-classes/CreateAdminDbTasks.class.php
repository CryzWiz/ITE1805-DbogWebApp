<?php

/**
 * Created by PhpStorm.
 * User: allan
 * Date: 17.04.2017
 * Time: 19.07
 */
require_once(dirname(__DIR__, 1) . "/global_init.php");
use Propel\Runtime\Propel;

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
 * not bug free either.
 */

class CreateAdminDbTasks {


    public static function CreateAdminAccount($fname, $lname, $username, $email, $password){
        $message = '';
        $error = false;
        $con = Propel::getWriteConnection(\Map\UsersTableMap::DATABASE_NAME);
        $user = new Users();
        $user->setEmail($email);
        $user->setPassword(getPasswordHash($password));
        $user->setRole(2);
        $user->setActive(1);
        $user->setValidated(1);
        $user->setRegDate(date('Y/m/d H:i:s'));
        $user->setFirstname($fname);
        $user->setLastname($lname);
        $user->setUserName($username);
        $user->setCurrentLogin(date('Y/m/d H:i:s'));
        $user->setLastLogin(date('Y/m/d H:i:s'));
        $con->beginTransaction();
        try{
            //Internal errors:
            if($user->save() == 0) {
                $con->rollback();
                //insert row into user table failed.
                $message .= "Skriving til database feilet!";
                $error = true;
                redirect("/controller/create_admin.php?step=1&&error=" . $error . "&&message=" . $message . "");
                exit();
            }

            else{
                // Success -> Return for next step
                $con->commit();
                $message .= "Brukerkonto opprettet!";
                $error = false;
                $email = $user->getEmail();
                redirect("/controller/create_admin.php?step=2&&error=" . $error . "&&message=" . $message . "&&email=".$email); // Redirecting to info page
                exit();
            }

        }
        catch(Exception $ex){
            $con->rollback();
        }

    }

    public static function SetSiteSettings($site_name, $site_title, $site_subtitle, $email){

        $message = '';
        $error = false;
        $con = Propel::getWriteConnection(\Map\SitesettingsTableMap::DATABASE_NAME);
        $sitedetails = new Sitesettings();
        $sitedetails->setSiteName($site_name);
        $sitedetails->setSiteTitle($site_title);
        $sitedetails->setSiteSubtitle($site_subtitle);
        $sitedetails->setUpdated(date('Y/m/d H:i:s'));
        $sitedetails->setByUser($email);
        $sitedetails->setSiteMail($email);
        $sitedetails->setSiteActivated(true);
        $sitedetails->setId(1);
        $con->beginTransaction();
        try{
            //Internal errors:
            if($sitedetails->save() == 0) {
                $con->rollback();
                //insert row into user table failed.
                $message .= "Skriving til database feilet!";
                $error = true;
                redirect("/controller/create_admin.php?step=2&&error=" . $error . "&&message=" . $message . "");
                exit();
            }

            else{
                // Success -> Return for next step
                $con->commit();
                redirect("/controller/create_admin.php?step=3");
                exit();
            }

        }
        catch(Exception $ex){
            $con->rollback();
            redirect("/controller/create_admin.php?step=2&&error=" . $error . "&&message=" . $ex . "");
        }
    }
}